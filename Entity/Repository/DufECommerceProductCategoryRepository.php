<?php

namespace Duf\ECommerceBundle\Entity\Repository;

use Duf\AdminBundle\Entity\Repository\DufAdminRepository;

/**
 * DufECommerceProductCategoryRepository
 */
class DufECommerceProductCategoryRepository extends DufAdminRepository
{
	public function getProductCategories($entity_id, $entity_name, $category_entity, $array = false)
	{
        $qb 		= $this->_em->createQueryBuilder()
                         ->select('category')
                         ->from($this->_entityName, 'product_category')
                         ->leftJoin($category_entity, 'category', 'WITH', 'category.id = product_category.category_id')
                         ->where('product_category.product_id = :entity_id')
                         ->andWhere('product_category.category_entity = :category_entity')
                         ->andWhere('product_category.product_entity = :entity_name')
                         ->setParameter('entity_id', $entity_id)
                         ->setParameter('category_entity', $category_entity)
                         ->setParameter('entity_name', $entity_name);

        if ($array)
        	return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        return $qb->getQuery()->getResult();
	}

     public function findProductsByCategory($category_id, $category_entity, $array = false)
     {
          $qb = $this->_em->createQueryBuilder()
                         ->select('product_category.product_id, product_category.product_entity')
                         ->from($this->_entityName, 'product_category')
                         ->where('product_category.category_id = :category_id')
                         ->andWhere('product_category.category_entity = :category_entity')
                         ->setParameter('category_id', $category_id)
                         ->setParameter('category_entity', $category_entity)
                         ;

          $product_ids             = $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
          $products                = array();

          foreach ($product_ids as $product_infos) {
               $product_id    = $product_infos['product_id'];
               $product_class = $product_infos['product_entity'];

               $product_qb       = $this->_em->createQueryBuilder()
                                             ->select('product')
                                             ->from($product_class, 'product')
                                             ->where('product.id = :product_id')
                                             ->setParameter('product_id', $product_id);

               if ($array) {
                    $product = $product_qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

                    if (!empty($product) && isset($product[0])) {
                         $product                 = $product[0];
                         $product['class_name']   = $product_class;
                         $products[]              = $product;
                    }
               }
               else {
                    $product = $qb->getQuery()->getResult();
                    if (!empty($product))
                         $products[] = $product;
               }
          }

          return $products;
     }
}