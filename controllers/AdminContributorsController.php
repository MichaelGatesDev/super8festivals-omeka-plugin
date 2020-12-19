<?php

class SuperEightFestivals_AdminContributorsController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
    }

    public function singleAction()
    {
        $request = $this->getRequest();

        $contributorID = $request->getParam('contributor');
        $contributor = SuperEightFestivalsContributor::get_by_id($contributorID);
        $this->view->contributor = $contributor;
    }
}
