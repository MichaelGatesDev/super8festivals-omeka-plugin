<?php

abstract class SuperEightFestivalsLocation extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public string $name = "";
    public float $latitude = -1;
    public float $longitude = -1;

    public function __construct()
    {
        parent::__construct();
    }

    protected function _validate()
    {
        if (empty($this->name)) {
            $this->addError('name', 'The location must be given a name.');
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
        return 'SuperEightFestivals_Location';
    }
}