<?php

class SuperEightFestivalsFestivalFilmmaker extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $city_id;
    public $first_name;
    public $last_name;
    public $organization_name;

    protected function _validate()
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Filmmaker';
    }
}