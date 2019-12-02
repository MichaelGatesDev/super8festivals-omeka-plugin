<?php

class SuperEightFestivalsCountry extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $name;

    protected function _validate()
    {
        if (empty($this->name)) {
            $this->addError('name', 'The country must be given a name.');
        }
    }

    protected function beforeSave($args)
    {
        $this->name = trim($this->name);
    }

    protected function afterSave($args)
    {
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Country';
    }
}