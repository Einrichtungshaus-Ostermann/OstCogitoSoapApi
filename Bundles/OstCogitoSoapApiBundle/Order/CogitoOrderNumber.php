<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order;

class CogitoOrderNumber
{
    /**
     * @var string
     */
    private $orderNumber;


    /**
     * @var array
     */
    private $decomposedValues;


    /**
     * CogitoOrderNumber constructor.
     *
     * @param $orderNumber
     */
    public function __construct($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }


    public function getOrderTerm()
    {
        return $this->getSalehouseNumber() . '-' . $this->getSection() . '-' . $this->getOrderNumber();
    }


    public function getSalehouseNumber()
    {
        return $this->decomposeOrderNumber()['salehousenumber'];
    }


    /**
     * Zerlegt die Bestellungsnummer in Die Bestandteile "Saleshousenumber", "Section" und "OrderNumber" und gibt ein
     * Array mit den Bestandteilen zurück.
     *
     * @return array
     */
    private function decomposeOrderNumber()
    {
        if ($this->decomposedValues !== null) {
            return $this->decomposedValues;
        }

        $this->orderNumber = str_pad($this->orderNumber, 9, '0', STR_PAD_LEFT);

        $this->decomposedValues = [
            'salehousenumber' => substr($this->orderNumber, 0, 2),
            'section' => $this->orderNumber[2],
            'ordernumber' => substr($this->orderNumber, 3, 6)
        ];

        return $this->decomposedValues;
    }


    public function getSection()
    {
        return $this->decomposeOrderNumber()['section'];
    }


    /**
     * @return int
     */
    public function getOrderNumber()
    {
        return $this->decomposeOrderNumber()['ordernumber'];
    }


    /**
     * @return int
     */
    public function getOriginalOrderNumber()
    {
        return $this->orderNumber;
    }
}
