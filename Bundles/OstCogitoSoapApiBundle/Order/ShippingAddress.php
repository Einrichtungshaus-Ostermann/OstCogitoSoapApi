<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order;

class ShippingAddress extends AbstractAddress
{
    public function getXML(): string
    {
        $parentXML = '<ikv:Lieferadresse>' . "\n";
        $parentXML .= parent::getXML();
        $parentXML .= '</ikv:Lieferadresse>' . "\n";

        return $parentXML;
    }
}
