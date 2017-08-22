<?php

namespace Duf\ECommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class CartController extends Controller
{
    public function addToCartAction($product_id, $encoded_product_class, Request $request)
    {
    	$ecommerce_service 	= $this->get('duf_ecommerce.dufecommerce');
    	$cart_service 		= $this->get('duf_ecommerce.dufecommercecart');
    	$product_class 		= $ecommerce_service->getProductClassFromMd5($encoded_product_class);
    	$error 				= false;
    	$redirect_route 	= $cart_service->getCartRedirect();

    	if (false === ($cart_item = $cart_service->createCart($product_id, $product_class)))
    		$error 			= true;

    	if ($error && $request->isXmlHttpRequest())
    		return new JsonResponse(array('error' => $error), 400);

    	if ($error && !$request->isXmlHttpRequest())
    		return new Response('error', 400);

    	if (false !== $redirect_route)
    		return $this->redirect($this->generateUrl($redirect_route));

    	return new Response('success');
    }
}
