<?php

namespace Duf\ECommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Duf\AdminBundle\Entity\DufAdminAbstractEntity;

use Duf\AdminBundle\Annotations\IndexableAnnotation as Indexable;
use Duf\AdminBundle\Annotations\EditableAnnotation as Editable;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class DufECommerceProduct extends DufAdminAbstractEntity implements Translatable
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
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     * @Editable(is_editable=true, label="Enabled", required=false, type="checkbox", order=1)
     * @Indexable(index_column=true, index_column_name="Enabled", boolean_column=true)
     */
    public $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Indexable(index_column=true, index_column_name="Title")
     * @Editable(is_editable=true, label="Title", required=true, type="translatable_text", order=2, placeholder="Write your title")
     * @Gedmo\Translatable
     */
    public $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Editable(is_editable=true, label="Description", required=false, type="translatable_textarea", order=3, placeholder="Write your description")
     * @Gedmo\Translatable
     */
    public $description;

    /**
     * @ORM\ManyToOne(targetEntity="Duf\AdminBundle\Entity\File")
     * @ORM\JoinColumn(nullable=true)
     * @Editable(is_editable=true, label="Cover", required=false, type="file", filetype="images", order=9876543210)
     */
    public $cover;

    /**
     * @var array
     *
     * @ORM\Column(name="images", type="json_array", nullable=true)
     * @Editable(is_editable=true, label="Images", required=false, type="multiple_file", filetype="images", order=4)
     */
    public $images;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

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
     * Set formToken
     *
     * @param string $formToken
     *
     * @return DufECommerceProduct
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
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return DufECommerceProduct
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return DufECommerceProduct
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return DufECommerceProduct
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set cover
     *
     * @param \Duf\AdminBundle\Entity\File $cover
     *
     * @return DufECommerceProduct
     */
    public function setCover(\Duf\AdminBundle\Entity\File $cover = null)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return \Duf\AdminBundle\Entity\File
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set images
     *
     * @param array $images
     *
     * @return DufECommerceProduct
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }
}
