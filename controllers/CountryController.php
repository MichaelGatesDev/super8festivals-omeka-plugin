<?php

class SuperEightFestivals_CountryController extends Omeka_Controller_AbstractActionController
{
    public function init()
    {
    }

    public function indexAction()
    {

        // Get the page object from the passed ID.
        $countryID = $this->_getParam('id');
        $country = $this->_helper->db->getTable('SuperEightFestivalsCountry')->find($countryID);

        $this->view->country = $country;

        return;
    }
}
