<?php

class SuperEightFestivals_AdminFilmmakersController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
    }

    public function singleAction()
    {
        $request = $this->getRequest();
        $this->view->filmmaker = $filmmaker = get_request_param_by_id($request, SuperEightFestivalsFilmmaker::class, "filmmakerID");
    }
}
