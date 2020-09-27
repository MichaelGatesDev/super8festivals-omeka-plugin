<?php

class SuperEightFestivals_AdminCountryCityFestivalsController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $this->view->country = get_request_param_country($request);
        $this->view->city = get_request_param_city($request);
        $this->redirect("/super-eight-festivals/countries/" . urlencode($this->view->country->name) . "/cities/" . urlencode($this->view->city->name));
    }

    public function singleAction()
    {
        $request = $this->getRequest();
        $this->view->country = get_request_param_country($request);
        $this->view->city = get_request_param_city($request);
        $this->view->festival = get_request_param_festival($request);
    }
}
