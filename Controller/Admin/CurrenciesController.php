<?php

namespace Duf\ECommerceBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Intl;
use Symfony\Component\DomCrawler\Crawler;

use Duf\ECommerceBundle\Entity\DufECommerceCurrency;

class CurrenciesController extends Controller
{
    public function indexAction()
    {
    	// get list of currencies
        $currencies         = $this->getCurrencies();

        return $this->render('DufECommerceBundle:Admin\Currencies:index.html.twig',
        	array(
        		'currencies' => $currencies,
        	)
        );
    }

    public function addTerritoriesAction($currency_code)
    {
        $currency       = $this->getDoctrine()->getRepository('DufECommerceBundle:DufECommerceCurrency')->findOneByCode($currency_code);

        if (!empty($currency)) {
            $territories    = array();
            $_territories   = $this->getDoctrine()->getRepository('DufECommerceBundle:DufECommerceTerritory')->findAll();

            foreach ($_territories as $territory) {
                $territories[] = array(
                    'country_code'  => $territory->getCountryCode(),
                    'country_name'  => Intl::getRegionBundle()->getCountryName($territory->getCountryCode()),
                );
            }

            return $this->render('DufECommerceBundle:Admin\Currencies:territories.html.twig', array(
                    'currency'      => $currency,
                    'currency_name' => Intl::getCurrencyBundle()->getCurrencyName($currency->getCode()),
                    'territories'   => $territories,
                )
            );
        }

        $this->get('session')->getFlashBag()->add('error', 'This currency does not exist');

        return $this->redirect($this->generateUrl('duf_admin_ecommerce_currencies'));
    }

    public function saveTerritoriesAction($currency_code, Request $request)
    {
        $em             = $this->getDoctrine()->getManager();
        $currency       = $this->getDoctrine()->getRepository('DufECommerceBundle:DufECommerceCurrency')->findOneByCode($currency_code);

        if (!empty($currency) && null !== ($territories = $request->get('territories'))) {
            $currency->setTerritories($territories);

            $em->persist($currency);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Territories updated for ' . Intl::getCurrencyBundle()->getCurrencyName($currency->getCode()));
        }
        else {
            $this->get('session')->getFlashBag()->add('error', 'Currency not found');
        }

        return $this->redirect($this->generateUrl('duf_admin_ecommerce_currencies'));
    }

    public function enableCurrencyAction($currency_code)
    {
        // check if currency exists
        $check_currency     = $this->getDoctrine()->getRepository('Duf\ECommerceBundle\Entity\DufECommerceCurrency')->findOneBy(
            array(
                'code'     => $currency_code,
            )
        );

        if (empty($check_currency)) {
            // get currency XML details
            $intl_currency   = $this->getCurrencies($currency_code);

            if (null !== $intl_currency) {
                // get currency name
                $currency_name  = $this->getCurrencyName($currency_code);

                // create DufECommerceCurrency entity
                $currency   = new DufECommerceCurrency();
                $currency->setCode($currency_code);
                $currency->setSymbol($intl_currency['symbol']);
                $currency->setFractionDigits($intl_currency['fraction_digits']);
                $currency->setRounding($intl_currency['rounding']);

                $em         = $this->getDoctrine()->getManager();
                $em->persist($currency);
                $em->flush();

                return $this->redirect($this->generateUrl('duf_admin_ecommerce_currencies_add_territories', array('currency_code' => $currency_code)));
            }
            else {
                $this->get('session')->getFlashBag()->add('error', 'Impossible to find currency configuration for ' . $currency_code);
            }
        }
        else {
            $this->get('session')->getFlashBag()->add('warning', 'This currency is already enabled');
        }

        return $this->redirect($this->generateUrl('duf_admin_ecommerce_currencies'));
    }

    public function disableCurrencyAction($currency_code)
    {
        // get currency entity
        $currency     = $this->getDoctrine()->getRepository('Duf\ECommerceBundle\Entity\DufECommerceCurrency')->findOneBy(
            array(
                'code'     => $currency_code,
            )
        );

        if (!empty($currency)) {
            // get currency name
            $currency_name  = $this->getCurrencyName($currency_code);

            $em             = $this->getDoctrine()->getManager();
            $em->remove($currency);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Currency disabled : ' . $currency_code . ' - ' . $currency_name);
        }
        else {
            $this->get('session')->getFlashBag()->add('error', 'Impossible to find currency entity - ' . $currency_code);
        }

        return $this->redirect($this->generateUrl('duf_admin_ecommerce_currencies'));
    }

    private function getCurrencies($find_currency_code = null)
    {
        $currencies         = array();
        $_currencies        = Intl::getCurrencyBundle()->getCurrencyNames();
        $active_currencies  = $this->getActiveCurrencies();

        foreach ($_currencies as $currency_code => $currency_name) {
            $currencies[$currency_code] = array(
                'code'              => $currency_code,
                'name'              => $currency_name,
                'symbol'            => Intl::getCurrencyBundle()->getCurrencySymbol($currency_code),
                'fraction_digits'   => Intl::getCurrencyBundle()->getFractionDigits($currency_code),
                'rounding'          => Intl::getCurrencyBundle()->getRoundingIncrement($currency_code),
                'enabled'           => $this->getCurrencyState($currency_code, $active_currencies),
                'territories'       => $this->getCountriesForCurrency($currency_code, $active_currencies),
            );
        }

        if (null !== $find_currency_code && isset($currencies[$find_currency_code])) {
            return $currencies[$find_currency_code];
        }

        ksort($currencies);

        return $currencies;
    }

    private function getCurrencyName($currency_code)
    {
        $intl_currencies    = Intl::getCurrencyBundle()->getCurrencyNames();

        if (isset($intl_currencies[$currency_code]))
            return $intl_currencies[$currency_code];

        return null;
    }

    private function getCountriesForCurrency($currency_code, $currencies)
    {
        $territories = array();

        foreach ($currencies as $currency) {
            if ($currency_code === $currency->getCode())  {
                $currency_territories = $currency->getTerritories();

                foreach ($currency_territories as $country_code) {
                    $territories[]   = Intl::getRegionBundle()->getCountryName($country_code);
                }
            }
        }

        if (!empty($territories))
            return $territories;

        return null;
    }

    private function getCurrencyState($currency_code, $currencies)
    {
        foreach ($currencies as $currency) {
            if ($currency_code === $currency->getCode())
                return true;
        }

        return false;
    }

    private function getActiveCurrencies()
    {
        return $this->getDoctrine()->getRepository('Duf\ECommerceBundle\Entity\DufECommerceCurrency')->findAll();
    }
}
