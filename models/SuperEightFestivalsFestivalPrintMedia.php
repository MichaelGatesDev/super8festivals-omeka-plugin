<?php

class SuperEightFestivalsFestivalPrintMedia extends SuperEightFestivalsDocument
{
    public $festival_id;

    protected function _validate()
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Print_Media';
    }
}