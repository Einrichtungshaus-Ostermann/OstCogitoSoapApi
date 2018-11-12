<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\CogitoOrderNumber;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order\PutOrderRequest;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\CogitoPrinter;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\GetAllPrinterRequest;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\GetDefaultPrinterRequest;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\PrintOrderRequest;
use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer\SetDefaultPrinterRequest;
use ReflectionClass;
use RuntimeException;

class SoapApiRequestService
{
    public const GET_ALL_PRINTER = GetAllPrinterRequest::class;
    public const GET_DEFAULT_PRINTER = GetDefaultPrinterRequest::class;
    public const SET_DEFAULT_PRINTER = SetDefaultPrinterRequest::class;
    public const PRINT_ORDER = PrintOrderRequest::class;
    public const PUT_ORDER = PutOrderRequest::class;


    private $allTypes = [self::GET_ALL_PRINTER, self::GET_DEFAULT_PRINTER, self::SET_DEFAULT_PRINTER,
        self::PRINT_ORDER, self::PUT_ORDER];


    /**
     * @param string $requestType
     * @param array $constructorParameters
     *
     * @throws \ReflectionException
     * @throws \RuntimeException
     *
     * @return ApiRequestInterface
     */
    public function getRequest(string $requestType, array $constructorParameters = []): ApiRequestInterface
    {
        if (!in_array($requestType, $this->allTypes, true)) {
            throw new RuntimeException('Not a valid SoapType');
        }

        $oReflectionClass = new ReflectionClass($requestType);
        $config = Shopware()->Config();


        $sortedParameter = [];
        foreach ($oReflectionClass->getConstructor()->getParameters() as $parameter) {
            $parameterName = $parameter->getName();

            $testModeEnabled = $config->getByNamespace('OstCogitoSoapApi', 'testModeEnabled');
            if ($testModeEnabled === true) {
                if ($parameterName === 'printer') {
                    $sortedParameter[$parameterName] = new CogitoPrinter($config->getByNamespace('OstCogitoSoapApi', 'testPrinter'));
                    continue;
                }

                if ($parameterName === 'orderNumber') {
                    $sortedParameter[$parameterName] = new CogitoOrderNumber($config->getByNamespace('OstCogitoSoapApi', 'testOrdernumber'));
                    continue;
                }
            }

            if (!isset($constructorParameters[$parameterName])) {
                if ($parameter->isOptional()) {
                    continue;
                }

                $fromPluginConfig = Shopware()->Config()->getByNamespace('OstCogitoSoapApi', $parameterName, null);
                if ($fromPluginConfig !== null) {
                    $sortedParameter[$parameterName] = $fromPluginConfig;
                    continue;
                }

                throw new RuntimeException('Not all Parameter are given - "' . $parameterName . '"');
            }

            $sortedParameter[$parameterName] = $constructorParameters[$parameterName];
        }

        /** @var ApiRequestInterface $instance */
        $instance = $oReflectionClass->newInstanceArgs($sortedParameter);

        if ($instance === null) {
            throw new RuntimeException('There is no Request Instance');
        }

        return $instance;
    }
}
