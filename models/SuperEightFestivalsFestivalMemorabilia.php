<?php

class SuperEightFestivalsFestivalMemorabilia extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $festival_id;
    public $filmmaker_id;
    public $path;

    protected function _validate()
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Memorabilia';
    }
}