<?php

class SuperEightFestivals_AdminCountryCitiesController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $this->view->country = $country = get_request_param_country($request);
        $this->redirect("/super-eight-festivals/countries/" . urlencode($this->view->country->name));
    }

    public function singleAction()
    {
        $request = $this->getRequest();
        $this->view->country = $country = get_request_param_country($request);
        $this->view->city = get_request_param_city($request);
    }
}
