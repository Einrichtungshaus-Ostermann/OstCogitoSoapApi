<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\CogitoOrderNumber;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\PrinterBaseApiRequest;

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
    private $serverEnvironment;

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
     * @param $serverEnvironment
     * @param CogitoPrinter $printer
     * @param CogitoOrderNumber $orderNumber
     */
    public function __construct(string $companyNumber, string $serverAddress, string $serverEnvironment, CogitoPrinter $printer, CogitoOrderNumber $orderNumber)
    {
        parent::__construct();
        $this->companyNumber = $companyNumber;
        $this->serverAddress = $serverAddress;
        $this->serverEnvironment = $serverEnvironment;
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
        return '<tem:PrintOrderData xmlns:ikv="http://schemas.datacontract.org/2004/07/IKVOrderImport" xmlns:tem="http://tempuri.org/">
                    <tem:request>
                       <ikv:Aufn>' . $this->orderNumber->getOrderNumber() . '</ikv:Aufn>
                       <ikv:Firm>' . $this->companyNumber . '</ikv:Firm>
                       <ikv:Prnt>' . $this->printer->getKey() . '</ikv:Prnt>
                       <ikv:Server>' . $this->serverAddress . '</ikv:Server>
                       <ikv:Spar>' . $this->orderNumber->getSection() . '</ikv:Spar>
                       <ikv:Umgebung>' . $this->serverEnvironment . '</ikv:Umgebung>
                       <ikv:Vkhs>' . $this->orderNumber->getSalehouseNumber() . '</ikv:Vkhs>
                    </tem:request>
                </tem:PrintOrderData>';
    }

    public function getRequestMethod(): string
    {
        return 'PrintOrderData';
    }
}