<?php

class SuperEightFestivalsFestivalPrintMedia extends SuperEightFestivalsDocument
{
    public int $festival_id = -1;

    public function __construct()
    {
        parent::__construct();
    }

    protected function _validate()
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Print_Media';
    }
}