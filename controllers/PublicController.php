<?php

class SuperEightFestivals_PublicController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
    }

    public function searchAction()
    {
        $request = $this->getRequest();

        $query = $request->getParam("query", "");
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

    public function filmmakersAction()
    {
    }

    public function filmmakerAction()
    {
        $request = $this->getRequest();
        $filmmakerID = $request->getParam('filmmakerID');
        $filmmaker = SuperEightFestivalsFilmmaker::get_by_id($filmmakerID);
        $this->view->filmmaker = $filmmaker;
    }

    public function historyAction()
    {
    }

    public function citiesAction()
    {
    }

    public function cityAction()
    {
        $request = $this->getRequest();
        $this->view->city = get_request_param_city($request);
    }

}
