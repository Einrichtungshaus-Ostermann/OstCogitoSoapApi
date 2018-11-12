<?php

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\SoapApiPart;

class OrderPosition implements SoapApiPart
{
    /**
     * @var int
     */
    protected $mainPositionNumber;

    /**
     * @var int
     */
    protected $subPositionNumber;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var int
     */
    protected $companyNumber;

    /**
     * @var int
     */
    protected $articleNumber;

    /**
     * @var int
     */
    protected $variationNumber;

    /**
     * @var string
     */
    protected $variationInformationAsText;

    /**
     * @var float
     */
    protected $pickupPrice;

    /**
     * @var string
     */
    protected $positionType;

    /**
     * @var int
     */
    protected $ean;

    /**
     * @var string
     */
    protected $manufacturerArticleNumber;

    /**
     * @var string
     */
    protected $xcaliburConfigurationId;

    /**
     * @var string
     */
    protected $xcaliburGeometryId;

    /**
     * @var string
     */
    protected $productId;

    /**
     * @var int
     */
    protected $consultantNumber;

    /**
     * @var int
     */
    protected $provisionKey;

    /**
     * @var string
     */
    protected $Anla;

    /**
     * @var int
     */
    protected $shippingType;

    /**
     * @var string
     */
    protected $desiredDate;

    /**
     * @var string
     */
    protected $desiredDateType;

    /**
     * @var string
     */
    protected $deliveryNote;

    /**
     * @var string
     */
    protected $serviceLevel;



    /**
     * OrderPosition constructor.
     * @param int $mainPositionNumber
     * @param int $subPositionNumber
     * @param float $amount
     * @param int $companyNumber
     * @param int $articleNumber
     * @param int $variationNumber
     * @param string $variationInformationAsText
     * @param float $pickupPrice
     * @param string $positionType
     * @param int $ean
     * @param string $manufacturerArticleNumber
     * @param string $xcaliburConfigurationId
     * @param string $xcaliburGeometryId
     * @param string $productId
     * @param int $consultantNumber
     * @param int $provisionKey
     * @param string $Anla
     * @param int $shippingType
     * @param string $desiredDate
     * @param string $desiredDateType
     * @param string $deliveryNote
     * @param string $serviceLevel
     */
    public function __construct(int $mainPositionNumber, int $subPositionNumber, float $amount, int $companyNumber, int $articleNumber, int $variationNumber, string $variationInformationAsText, float $pickupPrice, string $positionType, int $ean, string $manufacturerArticleNumber, string $xcaliburConfigurationId, string $xcaliburGeometryId, string $productId, int $consultantNumber, int $provisionKey, string $Anla, int $shippingType, string $desiredDate, string $desiredDateType, string $deliveryNote, string $serviceLevel)
    {
        $this->mainPositionNumber = $mainPositionNumber;
        $this->subPositionNumber = $subPositionNumber;
        $this->amount = $amount;
        $this->companyNumber = $companyNumber;
        $this->articleNumber = $articleNumber;
        $this->variationNumber = $variationNumber;
        $this->variationInformationAsText = $variationInformationAsText;
        $this->pickupPrice = $pickupPrice;
        $this->positionType = $positionType;
        $this->ean = $ean;
        $this->manufacturerArticleNumber = $manufacturerArticleNumber;
        $this->xcaliburConfigurationId = $xcaliburConfigurationId;
        $this->xcaliburGeometryId = $xcaliburGeometryId;
        $this->productId = $productId;
        $this->consultantNumber = $consultantNumber;
        $this->provisionKey = $provisionKey;
        $this->Anla = $Anla;
        $this->shippingType = $shippingType;
        $this->desiredDate = $desiredDate;
        $this->desiredDateType = $desiredDateType;
        $this->deliveryNote = $deliveryNote;
        $this->serviceLevel = $serviceLevel;
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
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
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
    public function getArticleNumber(): int
    {
        return $this->articleNumber;
    }

    /**
     * @param int $articleNumber
     */
    public function setArticleNumber(int $articleNumber): void
    {
        $this->articleNumber = $articleNumber;
    }

    /**
     * @return int
     */
    public function getVariationNumber(): int
    {
        return $this->variationNumber;
    }

    /**
     * @param int $variationNumber
     */
    public function setVariationNumber(int $variationNumber): void
    {
        $this->variationNumber = $variationNumber;
    }

    /**
     * @return string
     */
    public function getVariationInformationAsText(): string
    {
        return $this->variationInformationAsText;
    }

    /**
     * @param string $variationInformationAsText
     */
    public function setVariationInformationAsText(string $variationInformationAsText): void
    {
        $this->variationInformationAsText = $variationInformationAsText;
    }

    /**
     * @return float
     */
    public function getPickupPrice(): float
    {
        return $this->pickupPrice;
    }

    /**
     * @param float $pickupPrice
     */
    public function setPickupPrice(float $pickupPrice): void
    {
        $this->pickupPrice = $pickupPrice;
    }

    /**
     * @return string
     */
    public function getPositionType(): string
    {
        return $this->positionType;
    }

    /**
     * @param string $positionType
     */
    public function setPositionType(string $positionType): void
    {
        $this->positionType = $positionType;
    }

    /**
     * @return int
     */
    public function getEan(): int
    {
        return $this->ean;
    }

    /**
     * @param int $ean
     */
    public function setEan(int $ean): void
    {
        $this->ean = $ean;
    }

    /**
     * @return string
     */
    public function getManufacturerArticleNumber(): string
    {
        return $this->manufacturerArticleNumber;
    }

    /**
     * @param string $manufacturerArticleNumber
     */
    public function setManufacturerArticleNumber(string $manufacturerArticleNumber): void
    {
        $this->manufacturerArticleNumber = $manufacturerArticleNumber;
    }

    /**
     * @return string
     */
    public function getXcaliburConfigurationId(): string
    {
        return $this->xcaliburConfigurationId;
    }

    /**
     * @param string $xcaliburConfigurationId
     */
    public function setXcaliburConfigurationId(string $xcaliburConfigurationId): void
    {
        $this->xcaliburConfigurationId = $xcaliburConfigurationId;
    }

    /**
     * @return string
     */
    public function getXcaliburGeometryId(): string
    {
        return $this->xcaliburGeometryId;
    }

    /**
     * @param string $xcaliburGeometryId
     */
    public function setXcaliburGeometryId(string $xcaliburGeometryId): void
    {
        $this->xcaliburGeometryId = $xcaliburGeometryId;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     */
    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getConsultantNumber(): int
    {
        return $this->consultantNumber;
    }

    /**
     * @param int $consultantNumber
     */
    public function setConsultantNumber(int $consultantNumber): void
    {
        $this->consultantNumber = $consultantNumber;
    }

    /**
     * @return int
     */
    public function getProvisionKey(): int
    {
        return $this->provisionKey;
    }

    /**
     * @param int $provisionKey
     */
    public function setProvisionKey(int $provisionKey): void
    {
        $this->provisionKey = $provisionKey;
    }

    /**
     * @return string
     */
    public function getAnla(): string
    {
        return $this->Anla;
    }

    /**
     * @param string $Anla
     */
    public function setAnla(string $Anla): void
    {
        $this->Anla = $Anla;
    }

    /**
     * @return int
     */
    public function getShippingType(): int
    {
        return $this->shippingType;
    }

    /**
     * @param int $shippingType
     */
    public function setShippingType(int $shippingType): void
    {
        $this->shippingType = $shippingType;
    }

    /**
     * @return null
     */
    public function getDesiredDate(): string
    {
        return $this->desiredDate;
    }

    /**
     * @param string $desiredDate
     */
    public function setDesiredDate(string $desiredDate): void
    {
        $this->desiredDate = $desiredDate;
    }

    /**
     * @return string
     */
    public function getDesiredDateType(): string
    {
        return $this->desiredDateType;
    }

    /**
     * @param string $desiredDateType
     */
    public function setDesiredDateType(string $desiredDateType): void
    {
        $this->desiredDateType = $desiredDateType;
    }

    /**
     * @return string
     */
    public function getDeliveryNote(): string
    {
        return $this->deliveryNote;
    }

    /**
     * @param string $deliveryNote
     */
    public function setDeliveryNote(string $deliveryNote): void
    {
        $this->deliveryNote = $deliveryNote;
    }

    /**
     * @return string
     */
    public function getServiceLevel(): string
    {
        return $this->serviceLevel;
    }

    /**
     * @param string $serviceLevel
     */
    public function setServiceLevel(string $serviceLevel): void
    {
        $this->serviceLevel = $serviceLevel;
    }

    public function getXML(): string
    {
        return '<ikv:OrderPosition>
                     <ikv:Abpr>' . $this->pickupPrice . '</ikv:Abpr>
                     <ikv:Aftx>' . $this->variationInformationAsText . '</ikv:Aftx>
                     <ikv:Ahpn>' . $this->mainPositionNumber . '</ikv:Ahpn>
                     <ikv:Anla>' . $this->Anla . '</ikv:Anla>
                     <ikv:Apnr>' . $this->variationNumber . '</ikv:Apnr>
                     <ikv:Arte>' . $this->articleNumber . '</ikv:Arte>
                     <ikv:Artf>' . $this->companyNumber . '</ikv:Artf>
                     <ikv:Aupn>' . $this->subPositionNumber . '</ikv:Aupn>
                     <ikv:Bmng>' . $this->amount . '</ikv:Bmng>
                     <ikv:Eanr>' . $this->ean . '</ikv:Eanr>
                     <ikv:Eb1n>' . $this->consultantNumber . '</ikv:Eb1n>
                     <ikv:Geid>' . $this->xcaliburGeometryId . '</ikv:Geid>
                     <ikv:Hbsn>' . $this->manufacturerArticleNumber . '</ikv:Hbsn>
                     <ikv:Koid>' . $this->xcaliburConfigurationId . '</ikv:Koid>
                     <ikv:Lart>' . $this->shippingType . '</ikv:Lart>
                     <ikv:Lfhw>' . $this->deliveryNote . '</ikv:Lfhw>
                     <ikv:Poar>' . $this->positionType . '</ikv:Poar>
                     <ikv:Prid>' . $this->productId . '</ikv:Prid>
                     <ikv:Prov>' . $this->provisionKey . '</ikv:Prov>
                     <ikv:Svgr>' . $this->serviceLevel . '</ikv:Svgr>
                     <ikv:Trma>' . $this->desiredDateType . '</ikv:Trma>
                     <ikv:Wter>' . $this->desiredDate . '</ikv:Wter>
                  </ikv:OrderPosition>';
    }
}