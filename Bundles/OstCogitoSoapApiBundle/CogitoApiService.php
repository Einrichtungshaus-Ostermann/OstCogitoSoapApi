<?php

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\CogitoOrderNumber;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\CogitoPrinter;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\GetAllPrinterRequest;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\PrintOrderRequest;

class CogitoApiService
{

    /**
     * @var SoapApiRequestService
     */
    private $soapApiRequestService;


    public function __construct(SoapApiRequestService $soapApiRequestService)
    {
        $this->soapApiRequestService = $soapApiRequestService;
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
            'printer' => $cogitoPrinter,
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
            'user' => $user,
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
            'user' => $user,
            'function' => $function,
            'printer' => $cogitoPrinter,
        ]);

        if ($getAllPrinterRequest === null) {
            return [];
        }

        return $getAllPrinterRequest->getResult();
    }
}