<?php

class SuperEightFestivals_AdminCountriesController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('country');
        $country = is_numeric($countryName) ? get_country_by_id($countryName) : get_country_by_name($countryName);
        if (!$country) {
            throw new Omeka_Controller_Exception_404("No country exists with that name/ID: '${countryName}'.");
        }
        $this->view->country = $country;
    }
}
