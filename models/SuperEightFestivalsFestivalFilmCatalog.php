<?php

class SuperEightFestivalsFestivalFilmCatalog extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $city_id;
    public $path;
    public $thumbnail;

    protected function _validate()
    {
        if (empty($this->path)) {
            $this->addError('path', 'The path must be specified.');
        }
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Film_Catalog';
    }
}