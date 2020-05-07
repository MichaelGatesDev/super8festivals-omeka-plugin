<?php

class SuperEightFestivals_PublicController extends Omeka_Controller_AbstractActionController
{
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

    public function filmmakersFunction()
    {
    }

    public function historyAction()
    {
    }

    public function filmmakersAction()
    {
    }

    public function citiesAction()
    {
    }

    public function cityAction()
    {
        $request = $this->getRequest();
        $cityName = $request->getParam('cityName');
        $city = get_city_by_name_ambiguous($cityName);
        $this->view->city = $city;
    }
}
