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

    public function getRecordUrl($action = 'show')
    {
        if ('show' == $action) {
            return public_url("countries/" . $this->name);
        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'countries',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Country';
    }
}