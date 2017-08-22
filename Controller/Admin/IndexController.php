<?php

namespace Duf\ECommerceBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->render('DufECommerceBundle:Admin\Index:index.html.twig');
    }
}
