<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\BillingAddress;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\CogitoOrder;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\CogitoOrderNumber;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\OrderDiscount;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\OrderPosition;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\PutOrderRequest;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\ShippingAddress;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\CogitoPrinter;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\GetAllPrinterRequest;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\PrintOrderRequest;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Order\Billing;
use Shopware\Models\Order\Detail;
use Shopware\Models\Order\Order;
use Shopware\Models\Order\Shipping;
use Shopware\Models\Payment\Payment;

class CogitoApiService
{
    /**
     * @var SoapApiRequestService
     */
    private $soapApiRequestService;

    /**
     * @var ModelManager
     */
    private $modelManager;

    public function __construct(SoapApiRequestService $soapApiRequestService, ModelManager $modelManager)
    {
        $this->soapApiRequestService = $soapApiRequestService;
        $this->modelManager = $modelManager;
    }

    /**
     * @param string $ordernumber
     * @param string $printer
     *
     * @throws \Exception
     *
     * @return array|null
     */
    public function printOrder(string $ordernumber, string $printer)
    {
        $cogitoPrinter = new CogitoPrinter($printer);
        $cogitoOrderNumber = new CogitoOrderNumber($ordernumber);

        /** @var PrintOrderRequest $printOrderRequest */
        $printOrderRequest = $this->soapApiRequestService->getRequest(SoapApiRequestService::PRINT_ORDER, [
            'printer'     => $cogitoPrinter,
            'orderNumber' => $cogitoOrderNumber
        ]);

        if ($printOrderRequest === null) {
            return [];
        }

        return $printOrderRequest->getResult();
    }

    /**
     * @throws \Exception
     *
     * @return array|null
     */
    public function getPrinterList()
    {
        /** @var GetAllPrinterRequest $getAllPrinterRequest */
        $getAllPrinterRequest = $this->soapApiRequestService->getRequest(SoapApiRequestService::GET_ALL_PRINTER);

        if ($getAllPrinterRequest === null) {
            return [];
        }

        return $getAllPrinterRequest->getResult();
    }

    /**
     * @param string $user
     * @param string $function
     *
     * @throws \Exception
     *
     * @return array|null
     */
    public function getDefaultPrinter(string $user, string $function = '702')
    {
        /** @var GetAllPrinterRequest $getAllPrinterRequest */
        $getAllPrinterRequest = $this->soapApiRequestService->getRequest(SoapApiRequestService::GET_DEFAULT_PRINTER, [
            'user'     => $user,
            'function' => $function
        ]);

        if ($getAllPrinterRequest === null) {
            return [];
        }

        return $getAllPrinterRequest->getResult();
    }

    /**
     * @param string $user
     * @param string $printer
     * @param string $function
     *
     * @throws \Exception
     *
     * @return array|null
     */
    public function setDefaultPrinter(string $user, string $printer, string $function = '702')
    {
        $cogitoPrinter = new CogitoPrinter($printer);

        /** @var GetAllPrinterRequest $getAllPrinterRequest */
        $getAllPrinterRequest = $this->soapApiRequestService->getRequest(SoapApiRequestService::SET_DEFAULT_PRINTER, [
            'user'     => $user,
            'function' => $function,
            'printer'  => $cogitoPrinter,
        ]);

        if ($getAllPrinterRequest === null) {
            return [];
        }

        return $getAllPrinterRequest->getResult();
    }

    /**
     * @param string $orderNumber
     *
     * @throws \Exception
     *
     * @return array|null
     */
    public function exportOrder(string $orderNumber)
    {
        $order = $this->modelManager->getRepository(Order::class)->findOneBy(['number' => $orderNumber]);

        if ($order === null) {
            return null;
        }

        /** @var OrderPosition[] $orderPositions */
        $orderPositions = [];
        /** @var OrderDiscount[] $orderDiscounts */
        $orderDiscounts = [];
        /** @var Detail $orderDetail */
        foreach ($order->getDetails() as $position => $orderDetail) {
            $orderPosition = $this->getOrderPositionForDetail($position + 1, $orderDetail);
            if ($orderPosition !== null) {
                $orderPositions[] = $orderPosition;
                continue;
            }

            $orderDiscount = $this->getOrderDiscountForDetail($position + 1, $orderDetail);
            if ($orderDiscount !== null) {
                $orderDiscounts[] = $orderDiscount;
                continue;
            }
        }

        $orderPositions[] = new OrderPosition(
            count($orderPositions) + 1,
            0,
            1,
            1,
            131186,
            0,
            '',
            $order->getInvoiceShipping(),
            'D',
            0,
            '',
            '',
            '',
            '',
            $this->getConsultant(),
            99,
            '',
            0,
            $order->getOrderTime()->format('Y-m-d'),
            'F',
            '',
            'LO'
        );

        $config = Shopware()->Config();

        $paymentAttributeName = $config->getByNamespace('OstCogitoSoapApi', 'attributePayment');
        $shippingAttributeName = $config->getByNamespace('OstCogitoSoapApi', 'attributeShipping');

        /** @var Payment $payment */
        $payment = $order->getPayment();
        $paymentAttribute = Shopware()->Models()->toArray( $payment->getAttribute() );
        $paymentId = $paymentAttribute[$paymentAttributeName];
        // $paymentId = 'L'; //$payment->getAttribute()->//TODO: Mapping for Payment IDs

        /** @var Shipping $shipping */
        $shipping = $order->getDispatch();
        $shippingAttribute = Shopware()->Models()->toArray( $shipping->getAttribute() );
        $shippingId = $shippingAttribute[$shippingAttributeName];
        // $shippingId = '04'; //$shipping->getAttribute();//TODO: Mapping for Delivery Types

        $cogitoOrderNumer = new CogitoOrderNumber($order->getNumber());

        $cogitoOrder = new CogitoOrder(
            1,
            $cogitoOrderNumer->getSalehouseNumber(),
            $cogitoOrderNumer->getSection(),
            $cogitoOrderNumer->getOrderNumber(),
            $order->getOrderTime()->format('Y-m-d'),
            $order->getInvoiceAmount(),
            0,
            $order->getInvoiceAmount() - $order->getInvoiceAmountNet(),
            $paymentId,
            (int)$shippingId,
            0,
            $order->getComment(),
            '',
            $order->getTransactionId(),
            $order->getTransactionId(),
            'I',
            $orderDiscounts,
            $orderPositions
        );

        /** @var Shipping $swShippingAddress */
        $swShippingAddress = $order->getShipping();
        /** @var Billing $swBillingAddress */
        $swBillingAddress = $order->getBilling();

        /** @var Shipping|Billing $swShippingBilling */
        $swShippingBilling = $swBillingAddress ?? $swShippingAddress;
        $swBillingShipping = $swShippingAddress ?? $swBillingAddress;

        $billingAddress = new BillingAddress(
            $swBillingShipping->getCustomer()->getBirthday() ?? '1970-01-01',
            $swBillingShipping->getCity(),
            $swBillingShipping->getCompany(),
            $swBillingShipping->getCountry()->getIso(),
            $swBillingShipping->getCustomer()->getEmail(),
            $swBillingShipping->getFirstName(),
            'EG',
            '',
            $swBillingShipping->getLastName(),
            false,
            $swBillingShipping->getPhone(),
            $swBillingShipping->getPhone(),
            $swBillingShipping->getPhone(),
            (int)$swBillingShipping->getZipCode(),
            $swBillingShipping->getSalutation(),
            $swBillingShipping->getStreet()
        );

        $shippingAddress = new ShippingAddress(
            $swShippingBilling->getCustomer()->getBirthday() ?? '1970-01-01',
            $swShippingBilling->getCity(),
            $swShippingBilling->getCompany(),
            $swShippingBilling->getCountry()->getIso(),
            $swShippingBilling->getCustomer()->getEmail(),
            $swShippingBilling->getFirstName(),
            'EG',
            '',
            $swShippingBilling->getLastName(),
            false,
            $swShippingBilling->getPhone(),
            $swShippingBilling->getPhone(),
            $swShippingBilling->getPhone(),
            (int)$swShippingBilling->getZipCode(),
            $swShippingBilling->getSalutation(),
            $swShippingBilling->getStreet()
        );

        /** @var PutOrderRequest $getAllPrinterRequest */
        $putOrderRequest = $this->soapApiRequestService->getRequest(SoapApiRequestService::PUT_ORDER, [
            'order'                 => $cogitoOrder,
            'billingAddress'        => $billingAddress,
            'billingAddressNumber'  => 0,
            'shippingAddress'       => $shippingAddress,
            'shippingAddressNumber' => 0
        ]);

        if ($putOrderRequest === null) {
            return [];
        }

        return $putOrderRequest->getResult();
    }

    private function getConsultant()
    {
        return (int)Shopware()->Container()->get( "session" )->offsetGet( "ost-consultant" )['number'];
    }

    private function getOrderPositionForDetail(int $position, Detail $detail)
    {
        $articleDetail = $detail->getArticleDetail();

        if ($articleDetail === null) {
            return null;
        }

        /** @var string $articleNumber */
        $articleNumber = explode('-', $detail->getArticleNumber())[0];
        /** @var string|int $variationNumber */
        $variationNumber = explode('-', $detail->getArticleNumber())[1] ?? 0;

        $positionType = 'E';

        //If Articlenumber begins with ZU1 then its a Service
        if (strpos($detail->getArticleNumber(), 'ZU1') === 0) {
            $articleNumber = 132735;
            $positionType = 'D';
        }

        $serviceLevel = false ? 'LM' : 'LO'; //TODO: Replace false with Assembly check

        $desiredDate = $detail->getOrder()->getOrderTime()->format('Y-m-d');



        $config = Shopware()->Config();
        $shippingAttributeName = $config->getByNamespace('OstCogitoSoapApi', 'attributeShipping');

        /** @var Shipping $shipping */
        $shipping = $detail->getOrder()->getDispatch();
        $shippingAttribute = Shopware()->Models()->toArray( $shipping->getAttribute() );
        $shippingId = $shippingAttribute[$shippingAttributeName];



        return new OrderPosition(
            $position,
            0,
            $detail->getQuantity(),
            (int) $articleDetail->getAttribute()->getAttr1(),
            (int)$articleNumber,
            (int)$variationNumber,
            '',
            $detail->getPrice(),
            $positionType,
            (int)$detail->getEan(),
            '',
            '',
            '',
            '',
            $this->getConsultant(),
            99,
            '',
            (int)$shippingId,
            $desiredDate,
            'F',
            '',
            $serviceLevel
        );
    }



    private function getOrderDiscountForDetail(int $position, Detail $detail)
    {
        $articleDetail = $detail->getArticleDetail();

        if ($articleDetail === null) {
            return null;
        }

        if (strpos($detail->getArticleNumber(), 'GU') === 0) {
            $discountKey = '507';
        } elseif (strpos($detail->getArticleNumber(), 'NL') === 0) {
            $discountKey = '622';
        } else {
            return null;
        }

        return new OrderDiscount(
            $articleDetail->getAttribute()->getAttr1(),
            0,
            0,
            $articleDetail->getAttribute()->getAttr1(),
            $discountKey,
            $this->getConsultant(),
            '012253',
            0.00,
            number_format($detail->getPrice(), 2, '.', '')
        );
    }
}
