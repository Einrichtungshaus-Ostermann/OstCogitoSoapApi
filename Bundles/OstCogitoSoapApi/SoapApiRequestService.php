<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\CogitoSoapAPIBundle;

use OstCogitoSoapApi\Bundles\CogitoSoapAPIBundle\Order\CogitoOrderNumber;
use OstCogitoSoapApi\Bundles\CogitoSoapAPIBundle\Printer\CogitoPrinter;
use OstCogitoSoapApi\Bundles\CogitoSoapAPIBundle\Printer\GetAllPrinterRequest;
use OstCogitoSoapApi\Bundles\CogitoSoapAPIBundle\Printer\PrintOrderRequest;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use RuntimeException;

class SoapApiRequestService
{
    const GET_ALL_PRINTER = GetAllPrinterRequest::class;
    const PRINT_ORDER = PrintOrderRequest::class;



    private $allTypes = [self::GET_ALL_PRINTER, self::PRINT_ORDER];



    /** @var ContainerInterface */
    private $container;



    /**
     * RequestType constructor.
     *
     * @param ContainerInterface $container
     *
     * @internal param string $requestType
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }



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
