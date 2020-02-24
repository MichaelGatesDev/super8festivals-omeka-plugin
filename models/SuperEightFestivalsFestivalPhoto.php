<?php

class SuperEightFestivalsFestivalPhoto extends SuperEightFestivalsImage
{
    public $festival_id;

    protected function _validate()
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Photo';
    }
}