<?php

namespace Duf\ECommerceBundle\Entity\Repository;

use Duf\AdminBundle\Entity\Repository\DufAdminRepository;

/**
 * DufECommerceStoreProductRepository
 */
class DufECommerceStoreProductRepository extends DufAdminRepository
{
	public function getStoreProducts($entity_name, $entity_id, $array = false)
	{
		$store_products 	= array();

        $qb 		= $this->_em->createQueryBuilder()
                         ->select('store_product.product_entity, store_product.product_id')
                         ->from($this->_entityName, 'store_product')
                         ->where('store_product.store_id = :entity_id')
                         ->andWhere('store_product.store_entity = :entity_name')
                         ->setParameter('entity_name', $entity_name)
                         ->setParameter('entity_id', $entity_id);

        $product_ids = $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        foreach ($product_ids as $product_infos) {
	        $qb_product 	= $this->_em->createQueryBuilder()
	        							->select('product')
	        							->from($product_infos['product_entity'], 'product')
	        							->where('product.id = :product_id')
	        							->setParameter('product_id', $product_infos['product_id']);

	        if ($array) {
	        	$product = $qb_product->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

	        	if (!empty($product) && isset($product[0])) {
	        		$product 					= $product[0];
	        		$product['class_name'] 		= $product_infos['product_entity'];

	        		$store_products[] = $product;
	        	}
	        }
	        else {
		        $product 	= $qb_product->getQuery()->getResult();

		        if (!empty($product) && isset($product[0]))
		        	$store_products[] = $product[0];
	        }
        }

        return $store_products;
	}
}