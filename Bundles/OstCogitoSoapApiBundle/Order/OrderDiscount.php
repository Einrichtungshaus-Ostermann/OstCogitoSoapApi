<?php

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\SoapApiPart;

class OrderDiscount implements SoapApiPart
{
    /**
     * @var int
     */
    protected $companyNumber;

    /**
     * @var int
     */
    protected $mainPositionNumber;

    /**
     * @var int
     */
    protected $subPositionNumber;

    /**
     * @var int
     */
    protected $discountCompany;

    /**
     * @var int
     */
    protected $discountKey;

    /**
     * @var int
     */
    protected $consultantKey;

    /**
     * @var int
     */
    protected $confirmingConsultantKey;

    /**
     * @var float
     */
    protected $discountPercent;

    /**
     * @var float
     */
    protected $discountValue;

    /**
     * OrderDiscount constructor.
     * @param int $companyNumber
     * @param int $mainPositionNumber
     * @param int $subPositionNumber
     * @param int $discountCompany
     * @param int $discountKey
     * @param int $consultantKey
     * @param int $confirmingConsultantKey
     * @param float $discountPercent
     * @param float $discountValue
     */
    public function __construct(int $companyNumber, int $mainPositionNumber, int $subPositionNumber, int $discountCompany, int $discountKey, int $consultantKey, int $confirmingConsultantKey, float $discountPercent, float $discountValue)
    {
        $this->companyNumber = $companyNumber;
        $this->mainPositionNumber = $mainPositionNumber;
        $this->subPositionNumber = $subPositionNumber;
        $this->discountCompany = $discountCompany;
        $this->discountKey = $discountKey;
        $this->consultantKey = $consultantKey;
        $this->confirmingConsultantKey = $confirmingConsultantKey;
        $this->discountPercent = $discountPercent;
        $this->discountValue = $discountValue;
    }

    /**
     * @return int
     */
    public function getCompanyNumber(): int
    {
        return $this->companyNumber;
    }

    /**
     * @param int $companyNumber
     */
    public function setCompanyNumber(int $companyNumber): void
    {
        $this->companyNumber = $companyNumber;
    }

    /**
     * @return int
     */
    public function getMainPositionNumber(): int
    {
        return $this->mainPositionNumber;
    }

    /**
     * @param int $mainPositionNumber
     */
    public function setMainPositionNumber(int $mainPositionNumber): void
    {
        $this->mainPositionNumber = $mainPositionNumber;
    }

    /**
     * @return int
     */
    public function getSubPositionNumber(): int
    {
        return $this->subPositionNumber;
    }

    /**
     * @param int $subPositionNumber
     */
    public function setSubPositionNumber(int $subPositionNumber): void
    {
        $this->subPositionNumber = $subPositionNumber;
    }

    /**
     * @return int
     */
    public function getDiscountCompany(): int
    {
        return $this->discountCompany;
    }

    /**
     * @param int $discountCompany
     */
    public function setDiscountCompany(int $discountCompany): void
    {
        $this->discountCompany = $discountCompany;
    }

    /**
     * @return int
     */
    public function getDiscountKey(): int
    {
        return $this->discountKey;
    }

    /**
     * @param int $discountKey
     */
    public function setDiscountKey(int $discountKey): void
    {
        $this->discountKey = $discountKey;
    }

    /**
     * @return int
     */
    public function getConsultantKey(): int
    {
        return $this->consultantKey;
    }

    /**
     * @param int $consultantKey
     */
    public function setConsultantKey(int $consultantKey): void
    {
        $this->consultantKey = $consultantKey;
    }

    /**
     * @return int
     */
    public function getConfirmingConsultantKey(): int
    {
        return $this->confirmingConsultantKey;
    }

    /**
     * @param int $confirmingConsultantKey
     */
    public function setConfirmingConsultantKey(int $confirmingConsultantKey): void
    {
        $this->confirmingConsultantKey = $confirmingConsultantKey;
    }

    /**
     * @return float
     */
    public function getDiscountPercent(): float
    {
        return $this->discountPercent;
    }

    /**
     * @param float $discountPercent
     */
    public function setDiscountPercent(float $discountPercent): void
    {
        $this->discountPercent = $discountPercent;
    }

    /**
     * @return float
     */
    public function getDiscountValue(): float
    {
        return $this->discountValue;
    }

    /**
     * @param float $discountValue
     */
    public function setDiscountValue(float $discountValue): void
    {
        $this->discountValue = $discountValue;
    }

    public function getXML(): string
    {
        return '<ikv:OrderNachlass>
                     <ikv:Ahpn>' . $this->mainPositionNumber . '</ikv:Ahpn>
                     <ikv:Aupn>' . $this->subPositionNumber . '</ikv:Aupn>
                     <ikv:Bnz1>' . $this->confirmingConsultantKey . '</ikv:Bnz1>
                     <ikv:Eb1n>' . $this->consultantKey . '</ikv:Eb1n>
                     <ikv:Nachlassprozent>' . $this->discountPercent . '</ikv:Nachlassprozent>
                     <ikv:Nachlasswert>' . $this->discountValue . '</ikv:Nachlasswert>
                     <ikv:Nlgf>' . $this->discountCompany . '</ikv:Nlgf>
                     <ikv:Nlgr>' . $this->discountKey . '</ikv:Nlgr>
                  </ikv:OrderNachlass>';
    }
}