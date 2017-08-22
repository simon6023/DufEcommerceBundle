<?php

namespace Duf\ECommerceBundle\Traits;

use Duf\AdminBundle\Annotations\IndexableAnnotation as Indexable;
use Duf\AdminBundle\Annotations\EditableAnnotation as Editable;

use Doctrine\ORM\Mapping as ORM;

trait MultiplePricesTrait
{
    /**
     * @var array
     *
     * @ORM\Column(name="prices", type="json_array", nullable=true)
     * @Editable(is_editable=true, label="Prices", required=false, type="number", order=99999, number_type="float")
     */
    private $prices;

    /**
     * Set prices
     *
     * @param array $prices
     * @return DufECommerceProduct
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;

        return $this;
    }

    /**
     * Get prices
     *
     * @return array 
     */
    public function getPrices()
    {
        return $this->prices;
    }
}