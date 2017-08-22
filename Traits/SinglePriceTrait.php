<?php

namespace Duf\ECommerceBundle\Traits;

use Duf\AdminBundle\Annotations\IndexableAnnotation as Indexable;
use Duf\AdminBundle\Annotations\EditableAnnotation as Editable;

use Doctrine\ORM\Mapping as ORM;

trait SinglePriceTrait
{
	/**
	 * @var float
	 *
	 * @ORM\Column(name="price", type="float", nullable=true)
	 * @Indexable(index_column=true, index_column_name="price")
	 * @Editable(is_editable=true, label="Price", required=false, type="number", order=99999, number_type="float")
	 */
	private $price;

    /**
     * Set price
     *
     * @param float $price
     *
     * @return DufECommerceProduct
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}