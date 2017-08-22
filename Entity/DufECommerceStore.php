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
abstract class DufECommerceStore extends DufAdminAbstractEntity implements Translatable
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Indexable(index_column=true, index_column_name="Store name")
     * @Editable(is_editable=true, label="Store name", required=true, type="translatable_text", order=1, placeholder="Store name")
     * @Gedmo\Translatable
     */
    public $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=100, nullable=true)
     * @Editable(is_editable=true, label="Address", required=false, type="text", order=2, placeholder="Address")
     */
    public $address;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=100, nullable=true)
     * @Editable(is_editable=true, label="Address 2", required=false, type="text", order=3, placeholder="Address 2")
     */
    public $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=100, nullable=true)
     * @Editable(is_editable=true, label="Zipcode", required=false, type="text", order=4, placeholder="Zipcode")
     */
    public $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     * @Indexable(index_column=true, index_column_name="City")
     * @Editable(is_editable=true, label="City", required=false, type="text", order=5, placeholder="City")
     * @Gedmo\Translatable
     */
    public $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=5, nullable=true)
     * @Editable(is_editable=true, label="Country", required=false, type="choice", order=6, placeholder="Country")
     * @Gedmo\Translatable
     */
    public $country;

    /**
     * @var float
     *
     * @ORM\Column(type="text", length=50, nullable=true)
     * @Editable(is_editable=true, label="Latitude", required=false, type="text", order=7, placeholder="Longitude")
     */
    public $latitude;

    /**
     * @var float
     *
     * @ORM\Column(type="text", length=50, nullable=true)
     * @Editable(is_editable=true, label="Longitude", required=false, type="text", order=8, placeholder="Latitude")
     */
    public $longitude;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     * @Indexable(index_column=true, index_column_name="Enabled", boolean_column=true)
     * @Editable(is_editable=true, label="Enabled", required=false, type="checkbox", order=9)
     */
    public $enabled;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_virtual", type="boolean", nullable=true)
     * @Indexable(index_column=true, index_column_name="Is Virtual", boolean_column=true)
     * @Editable(is_editable=true, label="Is Virtual", required=false, type="checkbox", order=10)
     */
    public $is_virtual;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     * @Editable(is_editable=true, label="Email", required=false, type="email", order=11, placeholder="Email")
     */
    public $email;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=100)
     * @Editable(is_editable=true, label="Website", required=false, type="url", order=12, placeholder="Website")
     */
    public $url;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=100)
     * @Editable(is_editable=true, label="Phone", required=false, type="text", order=13, placeholder="Phone")
     */
    public $phone;

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
     * @return DufECommerceStore
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
     * Set name
     *
     * @param string $name
     *
     * @return DufECommerceStore
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return DufECommerceStore
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address2
     *
     * @param string $address2
     *
     * @return DufECommerceStore
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     *
     * @return DufECommerceStore
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return DufECommerceStore
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return DufECommerceStore
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return DufECommerceStore
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return DufECommerceStore
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return DufECommerceStore
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
     * Set is_virtual
     *
     * @param boolean $is_virtual
     *
     * @return DufECommerceStore
     */
    public function setIsVirtual($is_virtual)
    {
        $this->is_virtual = $is_virtual;

        return $this;
    }

    /**
     * Get is_virtual
     *
     * @return bool
     */
    public function getIsVirtual()
    {
        return $this->is_virtual;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return DufECommerceStore
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return DufECommerceStore
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return DufECommerceStore
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
}
