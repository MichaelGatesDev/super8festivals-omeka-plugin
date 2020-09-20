<?php

class SuperEightFestivals_AdminCountryCitiesController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();

        $country_param = $request->getParam('country');
        $country = is_numeric($country_param) ? SuperEightFestivalsCountry::get_by_id($country_param) : SuperEightFestivalsCountry::get_by_param("name", $country_param, 1)[0];
        if (!$country) {
            throw new Omeka_Controller_Exception_404("No country exists with that name/ID: '${countryName}'.");
        }
        $this->view->country = $country;

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name));
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $country_param = $request->getParam('country');
        $country = is_numeric($country_param) ? SuperEightFestivalsCountry::get_by_id($country_param) : SuperEightFestivalsCountry::get_by_param("name", $country_param, 1)[0];
        if (!$country) {
            throw new Omeka_Controller_Exception_404("No country exists with that name/ID: '${countryName}'.");
        }
        $this->view->country = $country;

        $cityName = $request->getParam('city');
        $city = is_numeric($cityName) ? SuperEightFestivalsCity::get_by_id($cityName) : SuperEightFestivalsCity::get_by_params(array('country_id' => $country->id, 'name', $cityName));;
        if (!$city) {
            throw new Omeka_Controller_Exception_404("No city exists with that name/ID: '${cityName}'.");
        }
        $this->view->city = $city;
    }
}
