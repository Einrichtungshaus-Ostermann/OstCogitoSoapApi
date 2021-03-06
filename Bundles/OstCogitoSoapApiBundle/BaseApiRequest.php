<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle;

use SoapClient;
use SoapVar;

abstract class BaseApiRequest implements ApiRequestInterface
{
    /**
     * @var SoapClient
     */
    protected $soapClient;

    public function __construct()
    {
        $this->soapClient = $this->getSoapClient();
    }

    public function send()
    {
        $data = new SoapVar($this->getRequestXML(), XSD_ANYXML);
        $requestMethod = $this->getRequestMethod();

        try {
            return $this->soapClient->$requestMethod($data);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function trimArray(array $array)
    {
        $newArray = [];
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $newArray[trim((string)$key)] = $this->trimArray($value);
            } else {
                $newArray[trim((string)$key)] = trim((string)$value);
            }
        }

        return $newArray;
    }

    public function removeStdClass($result): array
    {
        return objectToArray($result);
    }

    public function isValidResponse($response): bool
    {
        return $response !== null;
    }
}

function objectToArray($d)
{
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    }

    // Return array
    return $d;
}
