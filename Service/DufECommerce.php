<?php
namespace Duf\ECommerceBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Intl\Intl;

use Doctrine\ORM\EntityManager as EntityManager;

class DufECommerce
{
    private $container;
    private $em;
    private $router;

    public function __construct(Container $container, EntityManager $em, Router $router)
    {
        $this->container    = $container;
        $this->em           = $em;
        $this->router       = $router;
    }

    public function getPriceType($entity_class)
    {
        $uses   = class_uses($entity_class);

        if (isset($uses['Duf\ECommerceBundle\Traits\SinglePriceTrait']))
            return 'single';

        if (isset($uses['Duf\ECommerceBundle\Traits\MultiplePricesTrait']))
            return 'multiple';

        return null;
    }

    public function getCurrencies($array = false)
    {
        $currencies     = $this->em->getRepository('DufECommerceBundle:DufECommerceCurrency')->findAll();

        if ($array)
            return $this->getCurrenciesArray($currencies);

        return $currencies;
    }

    public function getProductCategories($entity_id, $entity_name, $category_entity_name, $array = false)
    {
        return $this->em->getRepository('DufECommerceBundle:DufECommerceProductCategory')->getProductCategories($entity_id, $entity_name, $category_entity_name, $array);
    }

    public function getCategoryEntityName()
    {
        $ecommerce_entities     = $this->container->get('duf_admin.dufadminconfig')->getDufAdminConfig('ecommerce_entities');

        foreach ($ecommerce_entities as $ecommerce_entity_name => $params) {
            if (isset($params['is_tree']) && true === $params['is_tree']) {
                return $ecommerce_entity_name;
            }
        }

        return null;
    }

    public function getStoreProducts($entity_name, $entity_id, $array = false)
    {
        return $this->em->getRepository('DufECommerceBundle:DufECommerceStoreProduct')->getStoreProducts($entity_name, $entity_id, $array);
    }

    public function getAllProducts()
    {
        $products   = array();

        // get products entities
        $ecommerce_entities = $this->container->get('duf_admin.dufadminconfig')->getDufAdminConfig('ecommerce_entities');

        foreach ($ecommerce_entities as $entity_name => $params) {
            if (isset($params['is_product']) && true === $params['is_product']) {
                $_products    = $this->em->getRepository($entity_name)->findBy(
                    array(
                        'enabled'   => true,
                    )
                );

                if (!empty($_products))
                    $products[$entity_name] = $_products;
            }
        }

        return $products;
    }

    public function getProductClassFromMd5($encoded_product_class)
    {
        // get products entities
        $ecommerce_entities = $this->container->get('duf_admin.dufadminconfig')->getDufAdminConfig('ecommerce_entities');

        foreach ($ecommerce_entities as $entity_name => $params) {
            if (isset($params['is_product']) && true === $params['is_product'] && md5($entity_name) === $encoded_product_class)
                return $entity_name;
        }

        return null;
    }

    private function getCurrenciesArray($currencies)
    {
        $currencies_array = array();

        foreach ($currencies as $currency) {
            $territories            = $currency->getTerritories();

            if (!empty($territories)) {
                $territories            = $this->getFullTerritories($territories);

                $currencies_array[]     = array(
                    'code'              => $currency->getCode(),
                    'name'              => Intl::getCurrencyBundle()->getCurrencyName($currency->getCode()),
                    'symbol'            => $currency->getSymbol(),
                    'rounding'          => $currency->getRounding(),
                    'fraction_digits'   => $currency->getFractionDigits(),
                    'territories'       => $territories,
                );
            }
        }

        return $currencies_array;
    }

    private function getFullTerritories($territories)
    {
        $full_territories = array();

        foreach ($territories as $country_code) {
            $country_name = Intl::getRegionBundle()->getCountryName($country_code);

            $full_territories[] = array(
                'code'      => $country_code,
                'name'      => $country_name,
            );
        }

        return $full_territories;
    }
}