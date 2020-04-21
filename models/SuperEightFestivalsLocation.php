<?php

abstract class SuperEightFestivalsLocation extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    /**
     * @var string
     */
    public $name = "";
    /**
     * @var float
     */
    public $latitude = 0;
    /**
     * @var float
     */
    public $longitude = 0;

    // ======================================================================================================================== \\

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
        $this->name = trim(strtolower($this->name));
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Location';
    }

    // ======================================================================================================================== \\
}