<?php

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Order;

use OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\SoapApiPart;

abstract class AbstractAddress implements SoapApiPart
{
    /**
     * @var string
     */
    protected $birthday;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $company;

    /**
     * @var string
     */
    protected $countryCode;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $floor;

    /**
     * @var string
     */
    protected $houseNumber;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var bool
     */
    protected $receiveNewsletter;

    /**
     * @var string
     */
    protected $phoneMobile;

    /**
     * @var string
     */
    protected $phonePrivate;

    /**
     * @var string
     */
    protected $phoneWork;

    /**
     * @var int
     */
    protected $postalCode;

    /**
     * @var string
     */
    protected $salutation;

    /**
     * @var string
     */
    protected $street;



    /**
     * AbstractAddress constructor.
     * @param string $birthday
     * @param string $city
     * @param string $company
     * @param string $countryCode
     * @param string $email
     * @param string $firstName
     * @param string $floor
     * @param string $houseNumber
     * @param string $lastName
     * @param bool $receiveNewsletter
     * @param string $phoneMobile
     * @param string $phonePrivate
     * @param string $phoneWork
     * @param int $postalCode
     * @param string $salutation
     * @param string $street
     */
    public function __construct(string $birthday, string $city, string $company, string $countryCode, string $email, string $firstName, string $floor, string $houseNumber, string $lastName, bool $receiveNewsletter, string $phoneMobile, string $phonePrivate, string $phoneWork, int $postalCode, string $salutation, string $street)
    {
        $this->birthday = $birthday;
        $this->city = $city;
        $this->company = $company;
        $this->countryCode = $countryCode;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->floor = $floor;
        $this->houseNumber = $houseNumber;
        $this->lastName = $lastName;
        $this->receiveNewsletter = $receiveNewsletter;
        $this->phoneMobile = $phoneMobile;
        $this->phonePrivate = $phonePrivate;
        $this->phoneWork = $phoneWork;
        $this->postalCode = $postalCode;
        $this->salutation = $salutation;
        $this->street = $street;
    }



    /**
     * @return string
     */
    public function getBirthday(): string
    {
        return $this->birthday;
    }

    /**
     * @param string $birthday
     */
    public function setBirthday(string $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getFloor(): string
    {
        return $this->floor;
    }

    /**
     * @param string $floor
     */
    public function setFloor(string $floor): void
    {
        $this->floor = $floor;
    }

    /**
     * @return string
     */
    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    /**
     * @param string $houseNumber
     */
    public function setHouseNumber(string $houseNumber): void
    {
        $this->houseNumber = $houseNumber;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return bool
     */
    public function isReceiveNewsletter(): bool
    {
        return $this->receiveNewsletter;
    }

    /**
     * @param bool $receiveNewsletter
     */
    public function setReceiveNewsletter(bool $receiveNewsletter): void
    {
        $this->receiveNewsletter = $receiveNewsletter;
    }

    /**
     * @return string
     */
    public function getPhoneMobile(): string
    {
        return $this->phoneMobile;
    }

    /**
     * @param string $phoneMobile
     */
    public function setPhoneMobile(string $phoneMobile): void
    {
        $this->phoneMobile = $phoneMobile;
    }

    /**
     * @return string
     */
    public function getPhonePrivate(): string
    {
        return $this->phonePrivate;
    }

    /**
     * @param string $phonePrivate
     */
    public function setPhonePrivate(string $phonePrivate): void
    {
        $this->phonePrivate = $phonePrivate;
    }

    /**
     * @return string
     */
    public function getPhoneWork(): string
    {
        return $this->phoneWork;
    }

    /**
     * @param string $phoneWork
     */
    public function setPhoneWork(string $phoneWork): void
    {
        $this->phoneWork = $phoneWork;
    }

    /**
     * @return int
     */
    public function getPostalCode(): int
    {
        return $this->postalCode;
    }

    /**
     * @param int $postalCode
     */
    public function setPostalCode(int $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getSalutation(): string
    {
        return $this->salutation;
    }

    /**
     * @param string $salutation
     */
    public function setSalutation(string $salutation): void
    {
        $this->salutation = $salutation;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getXML(): string
    {
        return '<ikv:Birthday>' . $this->birthday . '</ikv:Birthday>
                <ikv:City>' . $this->city . '</ikv:City>
                <ikv:Company>' . $this->company . '</ikv:Company>
                <ikv:CountryCode>' . $this->countryCode . '</ikv:CountryCode>
                <ikv:Email>' . $this->email . '</ikv:Email>
                <ikv:FirstName>' . $this->firstName . '</ikv:FirstName>
                <ikv:Floor>' . $this->floor . '</ikv:Floor>
                <ikv:Housenumber>' . $this->houseNumber . '</ikv:Housenumber>
                <ikv:LastName>' . $this->lastName . '</ikv:LastName>
                <ikv:NLJN>' . ($this->receiveNewsletter ? 'J' : 'N') . '</ikv:NLJN>
                <ikv:PhoneMobile>' . $this->phoneMobile . '</ikv:PhoneMobile>
                <ikv:PhonePrivate>' . $this->phonePrivate . '</ikv:PhonePrivate>
                <ikv:PhoneWork>' . $this->phoneWork . '</ikv:PhoneWork>
                <ikv:PostalCode>' . $this->postalCode . '</ikv:PostalCode>
                <ikv:Salutation>' . $this->salutation . '</ikv:Salutation>
                <ikv:Street>' . $this->street . '</ikv:Street>';
    }
}