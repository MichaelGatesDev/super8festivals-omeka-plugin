<?php

class SuperEightFestivals_AdminCountriesController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $country_param = $request->getParam('country');
        $country = is_numeric($country_param) ? SuperEightFestivalsCountry::get_by_id($country_param) : SuperEightFestivalsCountry::get_by_param("name", $country_param)[0];
        if (!$country) {
            throw new Omeka_Controller_Exception_404("No country exists with that name/ID: '${$country_param}'.");
        }
        $this->view->country = $country;
    }
}
