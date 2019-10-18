<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\SoapApiPart;

class CogitoOrder implements SoapApiPart
{
    /**
     * @var int
     */
    protected $companyNumber;

    /**
     * @var int
     */
    protected $storeKey;

    /**
     * @var int
     */
    protected $division;

    /**
     * @var int
     */
    protected $orderNumber;

    /**
     * @var string
     */
    protected $orderDate;

    /**
     * @var float
     */
    protected $totalOrderValue;

    /**
     * @var float
     */
    protected $depositValue;

    /**
     * @var float
     */
    protected $orderVAT;

    /**
     * @var string
     */
    protected $paymentType;

    /**
     * @var int
     */
    protected $deliveryType;

    /**
     * @var int
     */
    protected $pickupStore;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var string
     */
    protected $externalOrderId;

    /**
     * @var string
     */
    protected $internalPaymentReference;

    /**
     * @var string
     */
    protected $externalPaymentReference;

    /**
     * @var string
     */
    protected $orderEntryType;

    /**
     * @var string
     */
    protected $customerNotificationType;

    /** @var OrderDiscount[] */
    protected $orderDiscounts;

    /** @var OrderPosition[] */
    protected $orderPositions;

    /**
     * CogitoOrder constructor.
     *
     * @param int $companyNumber
     * @param int $storeKey
     * @param int $division
     * @param int $orderNumber
     * @param string $orderDate
     * @param float $totalOrderValue
     * @param float $depositValue
     * @param float $orderVAT
     * @param string $paymentType
     * @param int $deliveryType
     * @param int $pickupStore
     * @param string $comment
     * @param string $externalOrderId
     * @param string $internalPaymentReference
     * @param string $externalPaymentReference
     * @param string $orderEntryType
     * @param string $customerNotificationType
     * @param OrderDiscount[] $orderDiscounts
     * @param OrderPosition[] $orderPositions
     */
    public function __construct(int $companyNumber, int $storeKey, int $division, int $orderNumber, string $orderDate, float $totalOrderValue, float $depositValue, float $orderVAT, string $paymentType, int $deliveryType, int $pickupStore, string $comment, string $externalOrderId, string $internalPaymentReference, string $externalPaymentReference, string $orderEntryType, string $customerNotificationType, array $orderDiscounts, array $orderPositions)
    {
        $this->companyNumber = $companyNumber;
        $this->storeKey = $storeKey;
        $this->division = $division;
        $this->orderNumber = $orderNumber;
        $this->orderDate = $orderDate;
        $this->totalOrderValue = $totalOrderValue;
        $this->depositValue = $depositValue;
        $this->orderVAT = $orderVAT;
        $this->paymentType = $paymentType;
        $this->deliveryType = $deliveryType;
        $this->pickupStore = $pickupStore;
        $this->comment = $comment;
        $this->externalOrderId = $externalOrderId;
        $this->internalPaymentReference = $internalPaymentReference;
        $this->externalPaymentReference = $externalPaymentReference;
        $this->orderEntryType = $orderEntryType;
        $this->customerNotificationType = $customerNotificationType;
        $this->orderDiscounts = $orderDiscounts;
        $this->orderPositions = $orderPositions;
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
    public function getStoreKey(): int
    {
        return $this->storeKey;
    }

    /**
     * @param int $storeKey
     */
    public function setStoreKey(int $storeKey): void
    {
        $this->storeKey = $storeKey;
    }

    /**
     * @return int
     */
    public function getDivision(): int
    {
        return $this->division;
    }

    /**
     * @param int $division
     */
    public function setDivision(int $division): void
    {
        $this->division = $division;
    }

    /**
     * @return int
     */
    public function getOrderNumber(): int
    {
        return $this->orderNumber;
    }

    /**
     * @param int $orderNumber
     */
    public function setOrderNumber(int $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return string
     */
    public function getOrderDate(): string
    {
        return $this->orderDate;
    }

    /**
     * @param string $orderDate
     */
    public function setOrderDate(string $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return float
     */
    public function getTotalOrderValue(): float
    {
        return $this->totalOrderValue;
    }

    /**
     * @param float $totalOrderValue
     */
    public function setTotalOrderValue(float $totalOrderValue): void
    {
        $this->totalOrderValue = $totalOrderValue;
    }

    /**
     * @return float
     */
    public function getDepositValue(): float
    {
        return $this->depositValue;
    }

    /**
     * @param float $depositValue
     */
    public function setDepositValue(float $depositValue): void
    {
        $this->depositValue = $depositValue;
    }

    /**
     * @return float
     */
    public function getOrderVAT(): float
    {
        return $this->orderVAT;
    }

    /**
     * @param float $orderVAT
     */
    public function setOrderVAT(float $orderVAT): void
    {
        $this->orderVAT = $orderVAT;
    }

    /**
     * @return string
     */
    public function getPaymentType(): string
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     */
    public function setPaymentType(string $paymentType): void
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return int
     */
    public function getDeliveryType(): int
    {
        return $this->deliveryType;
    }

    /**
     * @param int $deliveryType
     */
    public function setDeliveryType(int $deliveryType): void
    {
        $this->deliveryType = $deliveryType;
    }

    /**
     * @return int
     */
    public function getPickupStore(): int
    {
        return $this->pickupStore;
    }

    /**
     * @param int $pickupStore
     */
    public function setPickupStore(int $pickupStore): void
    {
        $this->pickupStore = $pickupStore;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getExternalOrderId(): string
    {
        return $this->externalOrderId;
    }

    /**
     * @param string $externalOrderId
     */
    public function setExternalOrderId(string $externalOrderId): void
    {
        $this->externalOrderId = $externalOrderId;
    }

    /**
     * @return string
     */
    public function getInternalPaymentReference(): string
    {
        return $this->internalPaymentReference;
    }

    /**
     * @param string $internalPaymentReference
     */
    public function setInternalPaymentReference(string $internalPaymentReference): void
    {
        $this->internalPaymentReference = $internalPaymentReference;
    }

    /**
     * @return string
     */
    public function getExternalPaymentReference(): string
    {
        return $this->externalPaymentReference;
    }

    /**
     * @param string $externalPaymentReference
     */
    public function setExternalPaymentReference(string $externalPaymentReference): void
    {
        $this->externalPaymentReference = $externalPaymentReference;
    }

    /**
     * @return string
     */
    public function getOrderEntryType(): string
    {
        return $this->orderEntryType;
    }

    /**
     * @param string $orderEntryType
     */
    public function setOrderEntryType(string $orderEntryType): void
    {
        $this->orderEntryType = $orderEntryType;
    }

    /**
     * @return OrderDiscount[]
     */
    public function getOrderDiscounts(): array
    {
        return $this->orderDiscounts;
    }

    /**
     * @param OrderDiscount[] $orderDiscounts
     */
    public function setOrderDiscounts(array $orderDiscounts): void
    {
        $this->orderDiscounts = $orderDiscounts;
    }

    /**
     * @return OrderPosition[]
     */
    public function getOrderPositions(): array
    {
        return $this->orderPositions;
    }

    /**
     * @param OrderPosition[] $orderPositions
     */
    public function setOrderPositions(array $orderPositions): void
    {
        $this->orderPositions = $orderPositions;
    }

    public function getXML(): string
    {
        $xmlString = '<ikv:OrderInput>
                      <ikv:Anzl>' . $this->depositValue . '</ikv:Anzl>
                      <ikv:Aufn>' . $this->orderNumber . '</ikv:Aufn>
                      <ikv:Avad>' . $this->customerNotificationType . '</ikv:Avad>
                      <ikv:Bakz>' . $this->orderEntryType . '</ikv:Bakz>
                      <ikv:Date>' . $this->orderDate . '</ikv:Date>
                      <ikv:Firm>' . $this->companyNumber . '</ikv:Firm>
                      <ikv:Lart>' . $this->deliveryType . '</ikv:Lart>
                      <ikv:Mwst>' . $this->orderVAT . '</ikv:Mwst>
                      <ikv:OrderNachlass>
                      ';

        foreach ($this->orderDiscounts as $orderOrderNachlass) {
            $xmlString .= $orderOrderNachlass->getXML();
        }

        $xmlString .= '</ikv:OrderNachlass>
               <ikv:OrderPositions>';

        foreach ($this->orderPositions as $orderPosition) {
            $xmlString .= $orderPosition->getXML();
        }

        $xmlString .= '</ikv:OrderPositions>
                       <ikv:Spar>' . $this->division . '</ikv:Spar>
                       <ikv:Text>' . $this->comment . '</ikv:Text>
                       <ikv:Vkh2>' . $this->pickupStore . '</ikv:Vkh2>
                       <ikv:Vkhs>' . $this->storeKey . '</ikv:Vkhs>
                       <ikv:Vkpr>' . $this->totalOrderValue . '</ikv:Vkpr>
                       <ikv:Xauf>' . $this->externalOrderId . '</ikv:Xauf>
                       <ikv:Zart>' . $this->paymentType . '</ikv:Zart>
                       <ikv:Zide>' . $this->externalPaymentReference . '</ikv:Zide>
                       <ikv:Zidi>' . $this->internalPaymentReference . '</ikv:Zidi>
                    </ikv:OrderInput>';

        return $xmlString;
    }
}
