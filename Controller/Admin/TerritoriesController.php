<?php

namespace Duf\ECommerceBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Intl;

use Duf\ECommerceBundle\Entity\DufECommerceTerritory;

class TerritoriesController extends Controller
{
    public function indexAction()
    {
    	// get list of countries
    	$countries             = Intl::getRegionBundle()->getCountryNames();

        // get list of enabled countries
        $enabled_countries     = $this->getEnabledCountries();

        return $this->render('DufECommerceBundle:Admin\Territories:index.html.twig',
        	array(
        		'countries'           => $countries,
                'enabled_countries'   => $enabled_countries,
        	)
        );
    }

    public function saveAction(Request $request)
    {
        if (null !== ($countries = $request->get('countries'))) {
            // remove previous countries
            $this->removePreviousCountries();

            $em     = $this->getDoctrine()->getManager();

            // create ECommerceTerritory entities
            foreach ($countries as $country_code) {
                if (empty($check_territory)) {
                    $territory  = new DufECommerceTerritory();
                    $territory->setCountryCode($country_code);

                    $em->persist($territory);
                }
            }

            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'ECommerce active territories list updated');
        }
    	
        return $this->redirect($this->generateUrl('duf_admin_ecommerce_territories'));
    }

    private function getEnabledCountries()
    {
        $enabled_countries  = array();
        $_enabled_countries = $this->getDoctrine()->getRepository('Duf\ECommerceBundle\Entity\DufECommerceTerritory')->findAll();

        foreach ($_enabled_countries as $territory) {
            $enabled_countries[] = $territory->getCountryCode();
        }

        return $enabled_countries;
    }

    private function removePreviousCountries()
    {
        $em             = $this->getDoctrine()->getManager();
        $territories    = $this->getDoctrine()->getRepository('Duf\ECommerceBundle\Entity\DufECommerceTerritory')->findAll();

        foreach ($territories as $territory) {
            $em->remove($territory);
        }

        $em->flush();
    }
}
