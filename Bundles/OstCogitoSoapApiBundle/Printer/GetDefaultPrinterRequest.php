<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\BaseApiRequest;

class GetDefaultPrinterRequest extends BaseApiRequest
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
     * @var string
     */
    private $user;



    /**
     * @var string
     */
    private $function;



    /**
     * GetDefaultPrinterRequest constructor.
     *
     * @param string $companyNumber
     * @param string $serverAddress
     * @param string $serverEnvironment
     * @param string $user
     * @param string $function
     */
    public function __construct(string $companyNumber, string $serverAddress, string $serverEnvironment, string $user, string $function)
    {
        parent::__construct();
        $this->companyNumber = $companyNumber;
        $this->serverAddress = $serverAddress;
        $this->serverEnvironment = $serverEnvironment;
        $this->user = $user;
        $this->function = $function;
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

//            if (isset($processedResult['GetDefaultPrinter'], $processedResult['GetAllPrintersResult']['Printer'])) {
//                /** @var array $printersResult */
//                return $processedResult['GetAllPrintersResult']['Printer'];
//            }

            return $processedResult;
        }

        return null;
    }



    public function getRequestXML(): string
    {
        return '<tem:GetDefaultPrinter xmlns:ikv="http://schemas.datacontract.org/2004/07/IKVOrderImport" xmlns:tem="http://tempuri.org/">
                        <tem:request>
                            <ikv:Bnzn>' . $this->user . '</ikv:Bnzn>
                            <ikv:Funk>' . $this->function . '</ikv:Funk>
                            <ikv:Firm>' . $this->companyNumber . '</ikv:Firm>
                            <ikv:Server>' . $this->serverAddress . '</ikv:Server>
                            <ikv:Umgebung>' . $this->serverEnvironment . '</ikv:Umgebung>
                        </tem:request>
                     </tem:GetDefaultPrinter>';
    }



    public function getRequestMethod(): string
    {
        return 'GetDefaultPrinter';
    }
}
