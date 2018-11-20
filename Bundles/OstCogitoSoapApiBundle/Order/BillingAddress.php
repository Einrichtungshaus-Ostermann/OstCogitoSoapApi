<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order;

class BillingAddress extends AbstractAddress
{
    public function getXML(): string
    {
        $parentXML = '<ikv:Rechnungsadresse>' . "\n";
        $parentXML .= parent::getXML();
        $parentXML .= '</ikv:Rechnungsadresse>' . "\n";

        return $parentXML;
    }
}
