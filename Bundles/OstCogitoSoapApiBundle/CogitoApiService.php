<?php

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\BillingAddress;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\CogitoOrder;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\CogitoOrderNumber;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\OrderPosition;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\PutOrderRequest;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\CogitoPrinter;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\GetAllPrinterRequest;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\PrintOrderRequest;
use Shopware\Components\Model\ModelManager;
use Shopware\Models\Order\Billing;
use Shopware\Models\Order\Detail;
use Shopware\Models\Order\Order;
use Shopware\Models\Order\Shipping;

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
     * @return array|null
     * @throws \Exception
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
     * @return array|null
     * @throws \Exception
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
     * @return array|null
     * @throws \Exception
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
     * @return array|null
     * @throws \Exception
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
     * @return array|null
     * @throws \Exception
     */
    public function exportOrder(string $orderNumber)
    {
        $order = $this->modelManager->getRepository(Order::class)->findOneBy(['number', $orderNumber]);
        if ($order === null) {
            return null;
        }

        /** @var OrderPosition $orderPositions */
        $orderPositions = [];
        /** @var Detail $orderDetail */
        foreach ($order->getDetails() as $position => $orderDetail) {
            $orderPositions[] = $this->getOrderPositionForDetail($position, $orderDetail);
        }

        $cogitoOrder = new CogitoOrder(
            1,
            96,
            0,
            $order->getNumber(),
            $order->getOrderTime(),
            $order->getInvoiceAmount(),
            0,
            $order->getInvoiceAmount() - $order->getInvoiceAmountNet(),
            '', //TODO: Mapping for Payment IDs
            '', //TODO: Mapping for Delivery Types
            0,
            $order->getComment(),
            '',
            $order->getTransactionId(),
            $order->getTransactionId(),
            '',
            [],
            $orderPositions
        );

        /** @var Billing $swBillingAddress */
        $swBillingAddress = $order->getBilling();
        $billingAddress = new BillingAddress(
            $swBillingAddress->getCustomer()->getBirthday(),
            $swBillingAddress->getCity(),
            '',
            $swBillingAddress->getCountry(),
            $swBillingAddress->getCustomer()->getEmail(),
            $swBillingAddress->getFirstName(),
            '',
            '',
            $swBillingAddress->getLastName(),
            false,
            $swBillingAddress->getPhone(),
            $swBillingAddress->getPhone(),
            $swBillingAddress->getPhone(),
            $swBillingAddress->getZipCode(),
            $swBillingAddress->getSalutation(),
            $swBillingAddress->getStreet()
        );

        /** @var Shipping $swShippingAddress */
        $swShippingAddress = $order->getShipping();
        $shippingAddress = new BillingAddress(
            $swShippingAddress->getCustomer()->getBirthday(),
            $swShippingAddress->getCity(),
            '',
            $swShippingAddress->getCountry(),
            $swShippingAddress->getCustomer()->getEmail(),
            $swShippingAddress->getFirstName(),
            '',
            '',
            $swShippingAddress->getLastName(),
            false,
            $swShippingAddress->getPhone(),
            $swShippingAddress->getPhone(),
            $swShippingAddress->getPhone(),
            $swShippingAddress->getZipCode(),
            $swShippingAddress->getSalutation(),
            $swShippingAddress->getStreet()
        );

        /** @var PutOrderRequest $getAllPrinterRequest */
        $putOrderRequest = $this->soapApiRequestService->getRequest(SoapApiRequestService::PUT_ORDER, [
            'order' => $cogitoOrder,
            'billingAddress' => $billingAddress,
            'billingAddressNumber' => 0,
            'shippingAddress' => $shippingAddress,
            'shippingAddressNumber' => 0
        ]);

        if ($putOrderRequest === null) {
            return [];
        }

        return $putOrderRequest ->getResult();
    }



    private function getOrderPositionForDetail(int $position, Detail $detail)
    {
        $articleDetail = $detail->getArticleDetail();

        if ($articleDetail === null) {
            return null;
        }

        return new OrderPosition(
            $position,
            0,
            $detail->getQuantity(),
            $articleDetail->getAttribute()->getAttr1(),
            str_pad(explode('.', $detail->getArticleNumber())[0], 7, '0', STR_PAD_LEFT),
            0,
            '',
            number_format($detail->getPrice(), 2, '.', ''),
            'E',
            $detail->getEan(),
            '',
            '',
            '',
            '',
            50,
            99,
            '',
            '',
            '',
            '',
            $detail->getAttribute()->getBestitMontage(), //TODO: Wat?
            0
        );
    }
}