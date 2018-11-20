<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle;

use SoapClient;

abstract class OrderBaseApiRequest extends BaseApiRequest
{
    public function getSoapClient(): SoapClient
    {
        $wsdlPath = Shopware()->Config()->getByNamespace('OstCogitoSoapApi', 'orderWsdlPath');
        $params = [
            'trace' => 1,
            'use'   => SOAP_LITERAL,
            'style' => SOAP_DOCUMENT,
        ];

        return new SoapClient($wsdlPath, $params);
    }
}