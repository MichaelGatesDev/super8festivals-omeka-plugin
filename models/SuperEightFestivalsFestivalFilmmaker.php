<?php

class SuperEightFestivalsFestivalFilmmaker extends SuperEightFestivalsPerson
{
    public $festival_id;

    protected function _validate()
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Filmmaker';
    }
}