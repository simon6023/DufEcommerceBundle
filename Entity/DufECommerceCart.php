<?php

namespace Duf\ECommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Duf\AdminBundle\Entity\DufAdminAbstractEntity;

use Duf\AdminBundle\Annotations\IndexableAnnotation as Indexable;
use Duf\AdminBundle\Annotations\EditableAnnotation as Editable;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class DufECommerceCart extends DufAdminAbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Indexable(index_column=true, index_column_name="Id", index_column_order=1)
     */
    public $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Indexable(index_column=true, index_column_name="Created At", index_column_order=2)
     */
    public $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Indexable(index_column=true, index_column_name="Updated At", index_column_order=3)
     */
    public $updated_at;

    /**
     * @var string
     *
     * @ORM\Column(name="form_token", type="string", length=255, nullable=true)
     */
    public $form_token;

    /**
     * @var string
     *
     * @ORM\Column(name="product_id", type="string", length=10, nullable=false)
     */
    public $product_id;

    /**
     * @var string
     *
     * @ORM\Column(name="product_entity", type="string", length=255, nullable=false)
     */
    public $product_entity;

    /**
     * @var string
     *
     * @ORM\Column(name="client_ip", type="string", length=255, nullable=false)
     */
    public $client_ip;

    /**
     * @var string
     *
     * @ORM\Column(name="client_id", type="string", length=10, nullable=true)
     */
    public $client_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    public $quantity;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return DufECommerceCart
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return DufECommerceCart
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set formToken
     *
     * @param string $formToken
     *
     * @return DufECommerceCart
     */
    public function setFormToken($formToken)
    {
        $this->form_token = $formToken;

        return $this;
    }

    /**
     * Get formToken
     *
     * @return string
     */
    public function getFormToken()
    {
        return $this->form_token;
    }

    /**
     * Set productId
     *
     * @param string $productId
     *
     * @return DufECommerceCart
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
     * Set productEntity
     *
     * @param string $productEntity
     *
     * @return DufECommerceCart
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

    /**
     * Set clientIp
     *
     * @param string $clientIp
     *
     * @return DufECommerceCart
     */
    public function setClientIp($clientIp)
    {
        $this->client_ip = $clientIp;

        return $this;
    }

    /**
     * Get clientIp
     *
     * @return string
     */
    public function getClientIp()
    {
        return $this->client_ip;
    }

    /**
     * Set clientId
     *
     * @param string $clientId
     *
     * @return DufECommerceCart
     */
    public function setClientId($clientId)
    {
        $this->client_id = $clientId;

        return $this;
    }

    /**
     * Get clientId
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return DufECommerceCart
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
