<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle;

interface SoapApiPart
{
    public function getXML(): string;
}
