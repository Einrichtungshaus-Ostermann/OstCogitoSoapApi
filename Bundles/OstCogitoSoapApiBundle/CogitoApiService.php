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

    /**
     * @var array
     */
    private $configuration;

    /**
     * @param SoapApiRequestService $soapApiRequestService
     * @param ModelManager $modelManager
     */
    public function __construct(SoapApiRequestService $soapApiRequestService, ModelManager $modelManager)
    {
        $this->soapApiRequestService = $soapApiRequestService;
        $this->modelManager = $modelManager;
        $this->configuration = Shopware()->Container()->get('ost_cogito_soap_api.configuration');
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

        $result = $printOrderRequest->getResult();

        if ( (boolean) Shopware()->Container()->get( "ost_cogito_soap_api.configuration" )['debugLogStatus'] == true )
        {
            $data = print_r($result,true);
            $filename = "printer-xml." . date( "Y-m-d-H-i-s" ) . "." . substr( md5((string) $cogitoOrderNumber->getOrderNumber() . (string) $cogitoPrinter->getKey()), 0, 8 ) . "-response.xml";
            file_put_contents((string) Shopware()->Container()->get( "ost_cogito_soap_api.configuration" )['debugLogDirectory'] . $filename, $data);
        }

        return $result;
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
     * ...
     *
     * @param string $orderNumber
     *
     * @throws \Exception
     *
     * @return array|null
     */
    public function exportOrder(string $orderNumber)
    {
        /* @var $order Order */
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
            $orderPosition = $this->getOrderPositionForDetail($position + 1, $orderDetail, $order);
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

        // add shipping
        $orderPositions = $this->addShipping($order, $orderPositions);

        // get order number
        $cogitoOrderNumber = new CogitoOrderNumber($order->getNumber());

        // get the order
        $cogitoOrder = $this->getOrder($cogitoOrderNumber, $order, $orderPositions, $orderDiscounts);

        // get addresses
        $billingAddress = $this->getBillingAddress($order);
        $shippingAddress = $this->getShippingAddress($order);

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

        $result = $putOrderRequest->getResult();

        if ( (boolean) Shopware()->Container()->get( "ost_cogito_soap_api.configuration" )['debugLogStatus'] == true )
        {
            $data = print_r($result,true);
            $filename = "order-xml." . date( "Y-m-d-H-i-s" ) . "." . substr( (string) $cogitoOrder->getOrderNumber(), 0, 8 ) . "-response.xml";
            file_put_contents((string) Shopware()->Container()->get( "ost_cogito_soap_api.configuration" )['debugLogDirectory'] . $filename,$data);
        }

        return $result;
    }

    /**
     * ...
     */
    private function getConsultant()
    {
        return (int)Shopware()->Container()->get( "session" )->offsetGet( "ost-consultant" )['number'];
    }

    /**
     * ...
     *
     * @param integer $position
     * @param Detail  $detail
     * @param Order $order
     *
     * @return null|OrderPosition
     */
    private function getOrderPositionForDetail(int $position, Detail $detail, Order $order)
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

        // if Articlenumber begins with ZU1 then its a Service
        if (strpos($detail->getArticleNumber(), 'ZU1') === 0) {
            $articleNumber = 132735;
            $positionType = 'D';
        }

        $serviceLevel = false ? 'LM' : 'LO'; //TODO: Replace false with Assembly check

        $desiredDate = $detail->getOrder()->getOrderTime()->format('Y-m-d');

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
            $this->getShippingId($order),
            $desiredDate,
            'F',
            '',
            $serviceLevel
        );
    }

    /**
     * ...
     *
     * @param integer $position
     * @param Detail  $detail
     *
     * @return null|OrderDiscount
     */
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
            (int)$articleDetail->getAttribute()->getAttr1(),
            0,
            0,
            (int)$articleDetail->getAttribute()->getAttr1(),
            (int)$discountKey,
            $this->getConsultant(),
            (int)'012253',
            0.00,
            (float)number_format($detail->getPrice(), 2, '.', '')
        );
    }



    /**
     * ...
     *
     * @param CogitoOrderNumber $cogitoOrderNumber
     * @param Order             $order
     * @param array             $orderPositions
     * @param array             $orderDiscounts
     *
     * @return CogitoOrder
     */
    private function getOrder(CogitoOrderNumber $cogitoOrderNumber, Order $order, array $orderPositions, array $orderDiscounts)
    {
        // create the order
        $cogitoOrder = new CogitoOrder(
            (int) $this->configuration['companyNumber'],
            $cogitoOrderNumber->getSalehouseNumber(),
            $cogitoOrderNumber->getSection(),
            $cogitoOrderNumber->getOrderNumber(),
            $order->getOrderTime()->format('Y-m-d'),
            $order->getInvoiceAmount(),
            $this->getAdvancePayment($order),
            $order->getInvoiceAmount() - $order->getInvoiceAmountNet(),
            $this->getPaymentId($order),
            $this->getShippingId($order),
            0,
            $order->getComment(),
            '',
            $order->getTransactionId(),
            $order->getTransactionId(),
            $this->configuration['bakz'],
            $orderDiscounts,
            $orderPositions
        );

        // return it
        return $cogitoOrder;
    }

    /**
     * ...
     *
     * @param Order $order
     *
     * @return BillingAddress
     */
    private function getBillingAddress(Order $order)
    {
        /** @var Shipping $swShippingAddress */
        $swShippingAddress = $order->getShipping();
        /** @var Billing $swBillingAddress */
        $swBillingAddress = $order->getBilling();

        /** @var Shipping|Billing $swBillingShipping */
        $swBillingShipping = $swShippingAddress ?? $swBillingAddress;

        // create address
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

        // return it
        return $billingAddress;
    }

    /**
     * ...
     *
     * @param Order $order
     *
     * @return ShippingAddress
     */
    private function getShippingAddress(Order $order)
    {
        /** @var Shipping $swShippingAddress */
        $swShippingAddress = $order->getShipping();
        /** @var Billing $swBillingAddress */
        $swBillingAddress = $order->getBilling();

        /** @var Shipping|Billing $swShippingBilling */
        $swShippingBilling = $swBillingAddress ?? $swShippingAddress;

        // create the address
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

        // return the address
        return $shippingAddress;
    }

    /**
     * ...
     *
     * @param Order $order
     * @param array $orderPositions
     *
     * @return array
     */
    private function addShipping(Order $order, array $orderPositions)
    {
        /** @var Shipping $shipping */
        $shipping = $order->getDispatch();
        $shippingAttribute = Shopware()->Models()->toArray( $shipping->getAttribute() );

        // do we want to ignore the shipping costs?
        if ( (boolean) $shippingAttribute[$this->configuration['attributeShippingIgnoreCosts']] == true)
            // stop
            return $orderPositions;

        // add the shipping
        $orderPositions[] = $this->getShipping($order, count($orderPositions));

        // and return it
        return $orderPositions;
    }

    /**
     * ...
     *
     * @param Order $order
     * @param integer $countPositions
     *
     * @return OrderPosition
     */
    private function getShipping(Order $order, int $countPositions)
    {
        // return as order position
        return new OrderPosition(
            $countPositions + 1,
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
    }

    /**
     * ...
     *
     * @param Order $order
     *
     * @return integer
     */
    private function getShippingId(Order $order): int
    {
        /** @var Shipping $shipping */
        $shipping = $order->getDispatch();
        $shippingAttribute = Shopware()->Models()->toArray( $shipping->getAttribute() );
        return (int) $shippingAttribute[$this->configuration['attributeShipping']];
    }

    /**
     * ...
     *
     * @param Order $order
     *
     * @return string
     */
    private function getPaymentId(Order $order): string
    {
        /** @var Payment $payment */
        $payment = $order->getPayment();
        $paymentAttribute = Shopware()->Models()->toArray( $payment->getAttribute() );
        return (string) $paymentAttribute[$this->configuration['attributePayment']];
    }

    /**
     * ...
     *
     * @param Order $order
     *
     * @return float
     */
    private function getAdvancePayment(Order $order): float
    {
        /* @var $loader \Shopware\Bundle\AttributeBundle\Service\DataLoader */
        $loader = Shopware()->Container()->get("shopware_attribute.data_loader");

        // get the attributes for the order with underscore names
        $attributes = $loader->load("s_order_attributes", $order->getId());

        // advance payment via configuration
        return (float) $attributes[$this->configuration['attributeOrderAdvancePayment']];
    }
}
