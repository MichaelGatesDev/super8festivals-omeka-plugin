<?php

class SuperEightFestivals_CitiesController extends Omeka_Controller_AbstractActionController
{

    public function init()
    {
        // Set the model class so this controller can perform some functions,
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('SuperEightFestivalsCity');
    }

    public function indexAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = SuperEightFestivalsCountry::get_by_param('name', $countryName, 1)[0];
        $this->view->country = $country;

        $this->redirect("/super-eight-festivals/countries/" . urlencode($country->name));
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $countryName = $request->getParam('countryName');
        $country = SuperEightFestivalsCountry::get_by_param('name', $countryName, 1)[0];
        $this->view->country = $country;

        $cityName = $request->getParam('cityName');
        $city = SuperEightFestivalsCity::get_by_params(array('country_id' => $country->id, 'name', $cityName, 1))[0];
        $this->view->city = $city;
    }
}
