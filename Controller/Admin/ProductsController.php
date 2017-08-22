<?php

namespace Duf\ECommerceBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends Controller
{
    public function getProductsByCategoryAction($category_id, Request $request)
    {
        $products 	= $this->getDoctrine()
        				   ->getRepository('DufECommerceBundle:DufECommerceProductCategory')
        				   ->findProductsByCategory($category_id, $request->get('category_entity'), true);

        $previous_products = $request->get('previous_products');
        if (null !== $previous_products) {
            $previous_products = explode(',', $previous_products);

            if (!empty($previous_products)) {
                foreach ($previous_products as $previous_product_infos) {
                    $previous_product_infos = explode('|', $previous_product_infos);

                    if (isset($previous_product_infos[0]) && isset($previous_product_infos[1])) {
                        $previous_product_id    = $previous_product_infos[0];
                        $previous_product_class = $previous_product_infos[1];

                        foreach ($products as $key => $product) {
                            if ($product['id'] == $previous_product_id && $product['class_name'] == $previous_product_class) {
                                unset($products[$key]);
                            }
                        }
                    }
                }
            }
        }

        return $this->render('DufECommerceBundle:Admin\\Crud:store-products-list.html.twig',
        	array(
        		'products' 			=> $products,
        	)
        );
    }
}
