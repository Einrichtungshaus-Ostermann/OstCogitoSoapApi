<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\CogitoOrderNumber;

class PrintOrderRequest extends PrinterBaseApiRequest
{
    /**
     * @var string
     */
    private $companyNumber;

    /**
     * @var string
     */
    private $serverAddress;

    /**
     * @var string
     */
    private $serverEnvironmentPrinter;

    /**
     * @var CogitoPrinter
     */
    private $printer;

    /**
     * @var CogitoOrderNumber
     */
    private $orderNumber;

    /**
     * GetAllPrinterRequest constructor.
     *
     * @param $companyNumber
     * @param $serverAddress
     * @param $serverEnvironmentPrinter
     * @param CogitoPrinter $printer
     * @param CogitoOrderNumber $orderNumber
     */
    public function __construct(string $companyNumber, string $serverAddress, string $serverEnvironmentPrinter, CogitoPrinter $printer, CogitoOrderNumber $orderNumber)
    {
        parent::__construct();
        $this->companyNumber = $companyNumber;
        $this->serverAddress = $serverAddress;
        $this->serverEnvironmentPrinter = $serverEnvironmentPrinter;
        $this->printer = $printer;
        $this->orderNumber = $orderNumber;
    }

    /**
     * @throws \Exception
     *
     * @return array|null
     */
    public function getResult()
    {
        $result = $this->send();

        return $this->removeStdClass($result);
    }

    public function getRequestXML(): string
    {
        $xml = '<tem:PrintOrderData xmlns:ikv="http://schemas.datacontract.org/2004/07/IKVOrderImport" xmlns:tem="http://tempuri.org/">
                    <tem:request>
                       <ikv:Aufn>' . $this->orderNumber->getOrderNumber() . '</ikv:Aufn>
                       <ikv:Firm>' . $this->companyNumber . '</ikv:Firm>
                       <ikv:Prnt>' . $this->printer->getKey() . '</ikv:Prnt>
                       <ikv:Server>' . $this->serverAddress . '</ikv:Server>
                       <ikv:Spar>' . $this->orderNumber->getSection() . '</ikv:Spar>
                       <ikv:Umgebung>' . $this->serverEnvironmentPrinter . '</ikv:Umgebung>
                       <ikv:Vkhs>' . $this->orderNumber->getSalehouseNumber() . '</ikv:Vkhs>
                    </tem:request>
                </tem:PrintOrderData>';


        if ( (boolean) Shopware()->Container()->get( "ost_cogito_soap_api.configuration" )['debugLogStatus'] == true )
        {
            $filename = "printer-xml." . date( "Y-m-d-H-i-s" ) . "." . substr( md5((string) $this->orderNumber->getOrderNumber() . (string) $this->printer->getKey()), 0, 8 ) . "-request.xml";
            file_put_contents((string) Shopware()->Container()->get( "ost_cogito_soap_api.configuration" )['debugLogDirectory'] . $filename, $xml);
        }

        return $xml;
    }

    public function getRequestMethod(): string
    {
        return 'PrintOrderData';
    }
}
