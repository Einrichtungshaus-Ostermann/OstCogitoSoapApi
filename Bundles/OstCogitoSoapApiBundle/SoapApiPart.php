<?php


namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle;


interface SoapApiPart
{
    public function getXML(): string;
}