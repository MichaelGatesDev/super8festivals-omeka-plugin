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
        $country = SuperEightFestivalsCountry::get_by_param('name', $countryName, 1)[0];
        $this->view->country = $country;

        return;
    }
}
