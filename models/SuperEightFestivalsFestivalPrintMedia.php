<?php

class SuperEightFestivalsFestivalPrintMedia extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $city_id;
    public $path;
    public $thumbnail;

    protected function _validate()
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Print_Media';
    }
}