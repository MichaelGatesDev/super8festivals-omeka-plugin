<?php

class SuperEightFestivals_PublicController extends Omeka_Controller_AbstractActionController
{

    public function init()
    {
    }

    public function indexAction()
    {
    }

    public function searchAction()
    {
        $request = $this->getRequest();

        $query = $request->getParam("query");
        $this->view->query = $query;
    }

    public function aboutAction()
    {
    }

    public function contactAction()
    {
    }

    public function submitAction()
    {
    }

    public function federationAction()
    {
    }

    public function historyAction()
    {
    }

    public function filmmakersAction()
    {
    }

    public function countriesAction()
    {
    }

    public function countryAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;
    }

    public function citiesAction()
    {
        $request = $this->getRequest();
        $countryName = $request->getParam('countryName');
        $this->redirect("/countries/" . $countryName);
    }

    public function cityAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = get_country_by_name($countryName);
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = get_city_by_name($countryName, $cityName);
        $this->view->city = $city;
    }
}
