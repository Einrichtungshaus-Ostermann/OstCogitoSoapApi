<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle;

interface ApiRequestInterface
{
    public function send();



    public function getRequestXML(): string;



    public function getRequestMethod(): string;



    public function isValidResponse($response): bool;



    public function getResult();
}
