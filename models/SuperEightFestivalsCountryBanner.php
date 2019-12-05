<?php

class SuperEightFestivalsCountryBanner extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $country_id;
    public $path;
    public $thumbnail;

    protected function _validate()
    {
        if (empty($this->path)) {
            $this->addError('path', 'The path must be specified.');
        }
    }

    protected function beforeSave($args)
    {
    }

    protected function afterSave($args)
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Country_Banner';
    }
}