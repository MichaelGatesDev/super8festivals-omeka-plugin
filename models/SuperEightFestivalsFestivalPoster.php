<?php

class SuperEightFestivalsFestivalPoster extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $city_id;
    public $title;
    public $description;
    public $path;

    protected function _validate()
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Poster';
    }
}