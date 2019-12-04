<?php

class SuperEightFestivalsFestivalFilm extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $city_id;
    public $filmmaker_id;
    public $title;
    public $url;
    public $embed;

    protected function _validate()
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Film';
    }
}