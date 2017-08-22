<?php
namespace Duf\ECommerceBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Intl\Intl;

use Doctrine\ORM\EntityManager as EntityManager;

class DufECommerceCart
{
    private $container;
    private $em;
    private $router;
    private $token_storage;

    public function __construct(Container $container, EntityManager $em, Router $router, TokenStorage $token_storage)
    {
        $this->container        = $container;
        $this->em               = $em;
        $this->router           = $router;
        $this->token_storage    = $token_storage;
    }

    public function getProductAddToCartLink($params = array())
    {
        if (isset($params['product_entity']) && is_object($params['product_entity'])) {
            $product_class          = get_class($params['product_entity']);
            $encoded_product_class  = md5($this->container->get('duf_admin.dufadminrouting')->getEntityNameFromBundle($product_class));
            $product_id             = $params['product_entity']->getId();

            return $this->router->generate('duf_ecommerce_add_to_cart',
                                            array(
                                                'product_id'            => $product_id,
                                                'encoded_product_class' => $encoded_product_class,
                                            ),
                                            UrlGeneratorInterface::ABSOLUTE_URL
                                        );
        }

        return null;
    }

    public function createCart($product_id, $product_class)
    {
        // check if product exists and is enabled
        if (!$this->isProductEnabled($product_id, $product_class))
            return false;

        // get cart entity
        if (null === ($cart_entity = $this->container->get('duf_admin.dufadminconfig')->getDufAdminConfig('ecommerce_cart_entity')))
            return false;

        $cart_class     = $this->container->get('duf_admin.dufadminrouting')->getEntityClass($cart_entity);
        $client_ip      = $this->container->get('request_stack')->getMasterRequest()->getClientIp();
        $user           = $this->token_storage->getToken()->getUser();

        // check if cart exists
        if (null === ($cart = $this->getCartEntity($product_id, $product_class, $cart_class)))
            $cart           = new $cart_class;

        // get cart quantity
        $quantity       = (null !== $cart->getQuantity()) ? $cart->getQuantity() + 1: 1;

        // set user if not anonymous
        if (is_object($user) && 'anon.' !== $user) {
            $cart->setClientId($user->getId());
        }

        $cart->setProductId($product_id);
        $cart->setProductEntity($product_class);
        $cart->setClientIp($client_ip);
        $cart->setQuantity($quantity);

        $this->em->persist($cart);
        $this->em->flush();

        return $cart;
    }

    public function getCartRedirect()
    {
        if (null !== $redirect_route = $this->container->get('duf_admin.dufadminconfig')->getDufAdminConfig('ecommerce_cart_redirect_route'))
            return $redirect_route;

        return false;
    }

    private function isProductEnabled($product_id, $product_class)
    {
        $product    = $this->em->getRepository($product_class)->findOneById($product_id);

        if (!empty($product) && true === $product->getEnabled())
            return true;

        return false;
    }

    private function getCartEntity($product_id, $product_class, $cart_class = null)
    {
        if (null === $cart_class) {
            $cart_entity    = $this->container->get('duf_admin.dufadminconfig')->getDufAdminConfig('ecommerce_cart_entity');

            if (null !== $cart_entity)
                $cart_class     = $this->container->get('duf_admin.dufadminrouting')->getEntityClass($cart_entity);
        }

        if (null === $cart_class)
            return null;

        $user           = $this->token_storage->getToken()->getUser();
        $client_ip      = $this->container->get('request_stack')->getMasterRequest()->getClientIp();
        $client_id      = (is_object($user) && 'anon.' !== $user) ? $user->getId(): null;

        $check_params   = array(
            'product_id'        => $product_id,
            'product_entity'    => $product_class,
        );

        if (null !== $client_id) {
            $check_params['client_id']  = $client_id;
        }
        else {
            $check_params['client_ip']  = $client_ip;
        }

        $cart     = $this->em->getRepository($cart_class)->findOneBy($check_params);

        if (!empty($cart))
            return $cart;

        return null;
    }
}