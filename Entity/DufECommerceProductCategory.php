<?php

namespace Duf\ECommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Duf\AdminBundle\Entity\DufAdminEntity;

/**
 * DufECommerceProductCategory
 *
 * @ORM\Table(name="duf_ecommerce_product_category")
 * @ORM\Entity(repositoryClass="Duf\ECommerceBundle\Entity\Repository\DufECommerceProductCategoryRepository")
 */
class DufECommerceProductCategory extends DufAdminEntity
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
     * @ORM\Column(name="category_id", type="string", length=10, nullable=false)
     */
    private $category_id;

    /**
     * @var string
     *
     * @ORM\Column(name="category_entity", type="string", length=255, nullable=false)
     */
    private $category_entity;

    /**
     * @var string
     *
     * @ORM\Column(name="product_entity", type="string", length=255, nullable=false)
     */
    private $product_entity;

    /**
     * Set productId
     *
     * @param string $productId
     *
     * @return DufECommerceProductCategory
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
     * Set categoryId
     *
     * @param string $categoryId
     *
     * @return DufECommerceProductCategory
     */
    public function setCategoryId($categoryId)
    {
        $this->category_id = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return string
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set categoryEntity
     *
     * @param string $categoryEntity
     *
     * @return DufECommerceProductCategory
     */
    public function setCategoryEntity($categoryEntity)
    {
        $this->category_entity = $categoryEntity;

        return $this;
    }

    /**
     * Get categoryEntity
     *
     * @return string
     */
    public function getCategoryEntity()
    {
        return $this->category_entity;
    }

    /**
     * Set productEntity
     *
     * @param string $productEntity
     *
     * @return DufECommerceProductCategory
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
