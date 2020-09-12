<?php

class SuperEightFestivals_AdminCountryCitiesController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('country');
        $country = is_numeric($countryName) ? get_country_by_id($countryName) : get_country_by_name($countryName);
        if (!$country) {
            throw new Omeka_Controller_Exception_404("No country exists with that name/ID: '${countryName}'.");
        }
        $this->view->country = $country;

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name));
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

        $cityName = $request->getParam('city');
        $city = is_numeric($cityName) ? get_city_by_id($cityName) : get_city_by_name($country->id, $cityName);
        if (!$city) {
            throw new Omeka_Controller_Exception_404("No city exists with that name/ID: '${cityName}'.");
        }
        $this->view->city = $city;
    }
}
