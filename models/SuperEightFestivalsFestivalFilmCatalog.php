<?php

class SuperEightFestivalsFestivalFilmCatalog extends SuperEightFestivalsDocument
{
    public $festival_id;

    protected function _validate()
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Film_Catalog';
    }
}