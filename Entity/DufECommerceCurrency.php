<?php

namespace Duf\ECommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Duf\AdminBundle\Entity\DufAdminEntity;

/**
 * DufECommerceCurrency
 *
 * @ORM\Table(name="duf_ecommerce_currency")
 * @ORM\Entity(repositoryClass="Duf\ECommerceBundle\Entity\Repository\DufECommerceCurrencyRepository")
 */
class DufECommerceCurrency extends DufAdminEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=10)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="symbol", type="string", length=2)
     */
    private $symbol;

    /**
     * @var integer
     *
     * @ORM\Column(name="fraction_digits", type="integer")
     */
    private $fraction_digits;

    /**
     * @var integer
     *
     * @ORM\Column(name="rounding", type="integer")
     */
    private $rounding;

    /**
     * @var array
     *
     * @ORM\Column(name="territories", type="json_array", nullable=true)
     */
    private $territories;

    /**
     * Set code
     *
     * @param string $code
     *
     * @return DufECommerceCurrency
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set symbol
     *
     * @param string $symbol
     *
     * @return DufECommerceCurrency
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Set fractionDigits
     *
     * @param integer $fractionDigits
     *
     * @return DufECommerceCurrency
     */
    public function setFractionDigits($fractionDigits)
    {
        $this->fraction_digits = $fractionDigits;

        return $this;
    }

    /**
     * Get fractionDigits
     *
     * @return integer
     */
    public function getFractionDigits()
    {
        return $this->fraction_digits;
    }

    /**
     * Set rounding
     *
     * @param integer $rounding
     *
     * @return DufECommerceCurrency
     */
    public function setRounding($rounding)
    {
        $this->rounding = $rounding;

        return $this;
    }

    /**
     * Get rounding
     *
     * @return integer
     */
    public function getRounding()
    {
        return $this->rounding;
    }

    /**
     * Set territories
     *
     * @param array $territories
     *
     * @return DufECommerceCurrency
     */
    public function setTerritories($territories)
    {
        $this->territories = $territories;

        return $this;
    }

    /**
     * Get territories
     *
     * @return array
     */
    public function getTerritories()
    {
        return $this->territories;
    }
}
