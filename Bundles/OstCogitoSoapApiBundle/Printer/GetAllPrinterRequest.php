<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\BaseApiRequest;

class GetAllPrinterRequest extends BaseApiRequest
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
     * GetAllPrinterRequest constructor.
     *
     * @param string $companyNumber
     * @param string $serverAddress
     * @param string $serverEnvironment
     */
    public function __construct(string $companyNumber, string $serverAddress, string $serverEnvironment)
    {
        parent::__construct();
        $this->companyNumber = $companyNumber;
        $this->serverAddress = $serverAddress;
        $this->serverEnvironment = $serverEnvironment;
    }


    /**
     * @param null|array $printersResult
     *
     * @return CogitoPrinter[]
     * @throws \Exception
     */
    public function getPrinterArray($printersResult = null): array
    {
        if ($printersResult === null) {
            $printersResult = $this->getResult();
        }

        if ($printersResult === null) {
            return [];
        }

        $printers = [];
        foreach ($printersResult as $singlePrinter) {
            try {
                $printers[] = new CogitoPrinter($singlePrinter['Prnt'], $singlePrinter['Labz'], $singlePrinter['Dtyp']);
            } catch (\Exception $e) {
            }
        }

        return $printers;
    }


    /**
     * @return array|null
     * @throws \Exception
     */
    public function getResult()
    {
        $result = $this->send();

        if ($this->isValidResponse($result)) {
            $processedResult = $this->removeStdClass($result);

            if (isset($processedResult['GetAllPrintersResult']['Printer'])) {
                /* @var array $printersResult */
                return $this->trimArray($processedResult['GetAllPrintersResult']['Printer']);
            }
        }

        return null;
    }


    public function getRequestXML(): string
    {
        return '<tem:GetAllPrinters xmlns:ikv="http://schemas.datacontract.org/2004/07/IKVOrderImport" xmlns:tem="http://tempuri.org/">
                        <tem:request>
                            <ikv:Firm>' . $this->companyNumber . '</ikv:Firm>
                            <ikv:Server>' . $this->serverAddress . '</ikv:Server>
                            <ikv:Umgebung>' . $this->serverEnvironment . '</ikv:Umgebung>
                        </tem:request>
                     </tem:GetAllPrinters>';
    }


    public function getRequestMethod(): string
    {
        return 'GetAllPrinters';
    }
}
