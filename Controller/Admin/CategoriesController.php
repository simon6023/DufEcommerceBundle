<?php

namespace Duf\ECommerceBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoriesController extends Controller
{
    public function indexAction()
    {
        return $this->render('DufECommerceBundle:Admin\Index:index.html.twig');
    }
}
