<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\OrderBaseApiRequest;

class PutOrderRequest extends OrderBaseApiRequest
{
    /** @var string */
    protected $serverAddress;

    /** @var string */
    protected $serverEnvironment;

    /** @var CogitoOrder */
    protected $order;

    /** @var BillingAddress */
    protected $billingAddress;

    /** @var int */
    protected $billingAddressNumber;

    /** @var ShippingAddress */
    protected $shippingAddress;

    /** @var int */
    protected $shippingAddressNumber;

    /**
     * PutOrderRequest constructor.
     *
     * @param string $serverAddress
     * @param string $serverEnvironment
     * @param CogitoOrder $order
     * @param BillingAddress $billingAddress
     * @param int $billingAddressNumber
     * @param ShippingAddress $shippingAddress
     * @param int $shippingAddressNumber
     */
    public function __construct(string $serverAddress, string $serverEnvironment, CogitoOrder $order, BillingAddress $billingAddress, int $billingAddressNumber, ShippingAddress $shippingAddress, int $shippingAddressNumber)
    {
        parent::__construct();
        $this->serverAddress = $serverAddress;
        $this->serverEnvironment = $serverEnvironment;
        $this->order = $order;
        $this->billingAddress = $billingAddress;
        $this->billingAddressNumber = $billingAddressNumber;
        $this->shippingAddress = $shippingAddress;
        $this->shippingAddressNumber = $shippingAddressNumber;
    }

    /**
     * @return string
     */
    public function getServerAddress(): string
    {
        return $this->serverAddress;
    }

    /**
     * @param string $serverAddress
     */
    public function setServerAddress(string $serverAddress): void
    {
        $this->serverAddress = $serverAddress;
    }

    /**
     * @return string
     */
    public function getServerEnvironment(): string
    {
        return $this->serverEnvironment;
    }

    /**
     * @param string $serverEnvironment
     */
    public function setServerEnvironment(string $serverEnvironment): void
    {
        $this->serverEnvironment = $serverEnvironment;
    }

    /**
     * @return CogitoOrder
     */
    public function getOrder(): CogitoOrder
    {
        return $this->order;
    }

    /**
     * @param CogitoOrder $order
     */
    public function setOrder(CogitoOrder $order): void
    {
        $this->order = $order;
    }

    /**
     * @return BillingAddress
     */
    public function getBillingAddress(): BillingAddress
    {
        return $this->billingAddress;
    }

    /**
     * @param BillingAddress $billingAddress
     */
    public function setBillingAddress(BillingAddress $billingAddress): void
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return int
     */
    public function getBillingAddressNumber(): int
    {
        return $this->billingAddressNumber;
    }

    /**
     * @param int $billingAddressNumber
     */
    public function setBillingAddressNumber(int $billingAddressNumber): void
    {
        $this->billingAddressNumber = $billingAddressNumber;
    }

    /**
     * @return ShippingAddress
     */
    public function getShippingAddress(): ShippingAddress
    {
        return $this->shippingAddress;
    }

    /**
     * @param ShippingAddress $shippingAddress
     */
    public function setShippingAddress(ShippingAddress $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return int
     */
    public function getShippingAddressNumber(): int
    {
        return $this->shippingAddressNumber;
    }

    /**
     * @param int $shippingAddressNumber
     */
    public function setShippingAddressNumber(int $shippingAddressNumber): void
    {
        $this->shippingAddressNumber = $shippingAddressNumber;
    }

    public function getResult()
    {
        $result = $this->send();

        if ($this->isValidResponse($result)) {
            return $this->removeStdClass($result);
        }

        return null;
    }

    public function getRequestXML(): string
    {
        $soapXML = '<tem:SaveOrderData xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                        xmlns:tem="http://tempuri.org/" xmlns:ikv="http://schemas.datacontract.org/2004/07/IKVOrderImport">
                    <tem:request>';
        $soapXML .= $this->shippingAddress->getXML();
        $soapXML .= $this->order->getXML();
        $soapXML .= $this->billingAddress->getXML();
        $soapXML .= '<ikv:Server>' . $this->serverAddress . '</ikv:Server>
                    <ikv:Umgebung>' . $this->serverEnvironment . '</ikv:Umgebung>';

        $soapXML .= '<ikv:Kndn>' . ($this->shippingAddressNumber === 0 ? '' : $this->shippingAddressNumber) . '</ikv:Kndn>
                     <ikv:Anum>' . ($this->billingAddressNumber === 0 ? '' : $this->billingAddressNumber) . '</ikv:Anum>
                     </tem:request>
                     </tem:SaveOrderData>';

        return $soapXML;
    }

    public function getRequestMethod(): string
    {
        return 'SaveOrderData';
    }
}
