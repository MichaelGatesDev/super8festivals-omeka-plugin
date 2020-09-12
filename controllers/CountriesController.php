<?php

class SuperEightFestivals_CountriesController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
        return;
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        return;
    }
}
