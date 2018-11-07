<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Controller\Backend;

use OstCogitoSoapApi\Bundles\CogitoSoapAPIBundle\Order\CogitoOrderNumber;
use OstCogitoSoapApi\Bundles\CogitoSoapAPIBundle\Printer\CogitoPrinter;
use OstCogitoSoapApi\Bundles\CogitoSoapAPIBundle\Printer\GetAllPrinterRequest;
use OstCogitoSoapApi\Bundles\CogitoSoapAPIBundle\Printer\PrintOrderRequest;
use OstCogitoSoapApi\Bundles\CogitoSoapAPIBundle\SoapApiRequestService;
use Shopware_Controllers_Backend_ExtJs;

/**
 * Backend controllers extending from Shopware_Controllers_Backend_Application do support the new backend components
 */
class CogitoSoapAPI extends Shopware_Controllers_Backend_ExtJs
{
    public function printerListAction()
    {
        $companyNumber = Shopware()->Config()->getByNamespace('OstCogitoSoapApi', 'companyNumber');

        /* @noinspection PhpParamsInspection */
        $this->View()->assign($this->getPrinterList($companyNumber));
    }



    /**
     * @param $companyNumber
     *
     * @throws \Exception
     *
     * @return array
     */
    private function getPrinterList($companyNumber)
    {
        /** @var SoapApiRequestService $apiRequestService */
        $apiRequestService = $this->container->get('cogito_soap_api.soap_api_request_service');

        /** @var GetAllPrinterRequest $getAllPrinterRequest */
        $getAllPrinterRequest = $apiRequestService->getRequest(SoapApiRequestService::GET_ALL_PRINTER, ['companyNumber' => $companyNumber]);

        if ($getAllPrinterRequest === null) {
            return [];
        }

        $allPrinter = $getAllPrinterRequest->getResult();

        return ['success' => true, 'data' => $allPrinter, 'total' => count($allPrinter)];
    }



    public function printOrderAction()
    {
        $printer = new CogitoPrinter($this->request->get('printerKey'));
        $orderNumber = new CogitoOrderNumber($this->request->get('orderNumber'));
        $companyNumber = $this->request->get('companyNumber');

        /* @noinspection PhpParamsInspection */
        $this->View()->assign($this->printOrder($companyNumber, $printer, $orderNumber));
    }



    /**
     * @param $companyNumber
     * @param CogitoPrinter $printer
     * @param CogitoOrderNumber $orderNumber
     *
     * @throws \Exception
     *
     * @return array
     */
    private function printOrder($companyNumber, CogitoPrinter $printer, CogitoOrderNumber $orderNumber)
    {
        /** @var SoapApiRequestService $apiRequestService */
        $apiRequestService = $this->container->get('cogito_soap_api.soap_api_request_service');

        /** @var PrintOrderRequest $printOrderRequest */
        $printOrderRequest = $apiRequestService->getRequest(SoapApiRequestService::PRINT_ORDER, ['companyNumber' => $companyNumber,
                                                                                                 'printer'       => $printer,
                                                                                                 'orderNumber'   => $orderNumber]);

        if ($printOrderRequest === null) {
            return [];
        }

        $allPrinter = $printOrderRequest->getResult();

        return ['success' => true, 'data' => $allPrinter, 'total' => count($allPrinter)];
    }
}
