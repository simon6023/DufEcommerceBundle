<?php

namespace Duf\ECommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Duf\AdminBundle\Entity\DufAdminEntity;

/**
 * DufECommerceTerritory
 *
 * @ORM\Table(name="duf_ecommerce_territory")
 * @ORM\Entity(repositoryClass="Duf\ECommerceBundle\Entity\Repository\DufECommerceTerritoryRepository")
 */
class DufECommerceTerritory extends DufAdminEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=4)
     */
    private $country_code;

    /**
     * Set country_code
     *
     * @param string $country_code
     *
     * @return DufECommerceTerritory
     */
    public function setCountryCode($country_code)
    {
        $this->country_code = $country_code;

        return $this;
    }

    /**
     * Get country_code
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->country_code;
    }
}
