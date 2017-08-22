<?php

namespace Duf\ECommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Duf\AdminBundle\Entity\DufAdminEntity;

/**
 * DufECommerceStoreProduct
 *
 * @ORM\Table(name="duf_ecommerce_store_product")
 * @ORM\Entity(repositoryClass="Duf\ECommerceBundle\Entity\Repository\DufECommerceStoreProductRepository")
 */
class DufECommerceStoreProduct extends DufAdminEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="product_id", type="string", length=10, nullable=false)
     */
    private $product_id;

    /**
     * @var string
     *
     * @ORM\Column(name="store_id", type="string", length=10, nullable=false)
     */
    private $store_id;

    /**
     * @var string
     *
     * @ORM\Column(name="store_entity", type="string", length=100, nullable=false)
     */
    private $store_entity;

    /**
     * @var string
     *
     * @ORM\Column(name="product_entity", type="string", length=100, nullable=false)
     */
    private $product_entity;

    /**
     * Set productId
     *
     * @param string $productId
     *
     * @return DufECommerceStoreProduct
     */
    public function setProductId($productId)
    {
        $this->product_id = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return string
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Set storeId
     *
     * @param string $storeId
     *
     * @return DufECommerceStoreProduct
     */
    public function setStoreId($storeId)
    {
        $this->store_id = $storeId;

        return $this;
    }

    /**
     * Get storeId
     *
     * @return string
     */
    public function getStoreId()
    {
        return $this->store_id;
    }

    /**
     * Set storeEntity
     *
     * @param string $storeEntity
     *
     * @return DufECommerceStoreProduct
     */
    public function setStoreEntity($storeEntity)
    {
        $this->store_entity = $storeEntity;

        return $this;
    }

    /**
     * Get storeEntity
     *
     * @return string
     */
    public function getStoreEntity()
    {
        return $this->store_entity;
    }

    /**
     * Set productEntity
     *
     * @param string $productEntity
     *
     * @return DufECommerceStoreProduct
     */
    public function setProductEntity($productEntity)
    {
        $this->product_entity = $productEntity;

        return $this;
    }

    /**
     * Get productEntity
     *
     * @return string
     */
    public function getProductEntity()
    {
        return $this->product_entity;
    }
}
