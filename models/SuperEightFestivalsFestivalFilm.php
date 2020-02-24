<?php

class SuperEightFestivalsFestivalFilm extends SuperEightFestivalsVideo
{
    public $festival_id;
    public $filmmaker_id;

    protected function _validate()
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Film';
    }
}