<?php declare(strict_types=1);

namespace OstCogitoSoapApi\Bundles\OstCogitoSoapApiBundle\Printer;

use Exception;

class CogitoPrinter
{
    const PRINTER_TYPE_LASER = 'L';
    const PRINTER_TYPE_MULTIPLEX = 'M';

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $type;

    /**
     * CogitoPrinter constructor.
     *
     * @param string $key
     * @param string $description
     * @param string $type
     *
     * @throws Exception
     */
    public function __construct(string $key = '', string $description = '', $type = self::PRINTER_TYPE_LASER)
    {
        $this->setKey($key);
        $this->setDescription($description);
        $this->setType(strtoupper($type));
    }

    /**
     * Gibt die Instanz als  assoziatives Array zurück.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'key'         => $this->getKey(),
            'description' => $this->getDescription(),
            'type'        => $this->getType(),
        ];
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = trim($key);
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = trim($description);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @throws Exception;
     */
    public function setType($type)
    {
        $typeToUpper = strtoupper(trim($type));
        switch ($typeToUpper) {
            case self::PRINTER_TYPE_LASER:
            case self::PRINTER_TYPE_MULTIPLEX:
                $this->type = $typeToUpper;
                break;
            default:
                throw new Exception('Unknown printer type "' . $typeToUpper . '"', 1001);
                break;
        }
    }
}
