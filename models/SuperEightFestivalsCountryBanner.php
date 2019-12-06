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

    public function getRecordUrl($action = 'show')
    {
        if ('show' == $action) {
            return public_url($this->name);
        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'banners',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Country_Banner';
    }
}