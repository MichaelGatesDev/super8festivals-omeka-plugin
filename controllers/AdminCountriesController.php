<?php

class SuperEightFestivals_AdminCountriesController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
    }

    public function singleAction()
    {
        $request = $this->getRequest();
        $this->view->country = $country = get_request_param_country($request);
    }
}
