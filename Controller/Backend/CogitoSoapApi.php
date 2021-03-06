<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Controller\Backend;

use Shopware_Controllers_Backend_ExtJs;

/**
 * Backend controllers extending from Shopware_Controllers_Backend_Application do support the new backend components
 */
class CogitoSoapApi extends Shopware_Controllers_Backend_ExtJs implements \Shopware\Components\CSRFWhitelistAware
{
    public function printerListAction()
    {
        $apiService = $this->container->get('ost_cogito_soap_api.cogito_api_service');

        $allPrinter = $apiService->getPrinterList();

        /* @noinspection PhpParamsInspection */
        $this->View()->assign(['success' => true, 'data' => $allPrinter, 'total' => count($allPrinter)]);
    }

    public function printOrderAction()
    {
        $printerKey = $this->request->get('printerKey');

        if ( substr_count($printerKey, "PRT") == 0)
            $printerKey = "PRT" . $printerKey;

        $apiService = $this->container->get('ost_cogito_soap_api.cogito_api_service');

        $printOrderResult = $apiService->printOrder($this->request->get('orderNumber'), $printerKey);

        /* @noinspection PhpParamsInspection */
        $this->View()->assign(['success' => true, 'data' => $printOrderResult, 'total' => count($printOrderResult)]);
    }

    public function getDefaultPrinterAction()
    {
        $apiService = $this->container->get('ost_cogito_soap_api.cogito_api_service');

        $defaultPrinterResult = $apiService->getDefaultPrinter($this->request->get('user'), $this->request->get('function'));

        /* @noinspection PhpParamsInspection */
        $this->View()->assign(['success' => true, 'data' => $defaultPrinterResult,
                               'total'   => count($defaultPrinterResult),
        ]
        );
    }

    public function setDefaultPrinterAction()
    {
        $apiService = $this->container->get('ost_cogito_soap_api.cogito_api_service');

        $defaultPrinterResult = $apiService->setDefaultPrinter($this->request->get('user'), $this->request->get('function'), $this->request->get('printer'));

        /* @noinspection PhpParamsInspection */
        $this->View()->assign(['success' => true, 'data' => $defaultPrinterResult,
                               'total'   => count($defaultPrinterResult),
        ]
        );
    }



    public function exportOrderAction()
    {
        $apiService = $this->container->get('ost_cogito_soap_api.cogito_api_service');

        $exportOrderResult = $apiService->exportOrder($this->request->get('orderNumber'));

        /* @noinspection PhpParamsInspection */
        $this->View()->assign(
            [
                'success' => $exportOrderResult !== null,
                'data'    => $exportOrderResult,
                'total'   => count($exportOrderResult),
            ]
        );
    }



    /**
     * Returns a list with actions which should not be validated for CSRF protection
     *
     * @return string[]
     */
    public function getWhitelistedCSRFActions()
    {
        return [
            'printerList',
            'printOrder',
            'getDefaultPrinter',
            'setDefaultPrinter',
            'exportOrder',
        ];
    }
}
