<?php

abstract class SuperEightFestivalsPerson extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    public string $first_name = "";
    public string $last_name = "";
    public string $organization_name = "";
    public string $email = "";

    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    protected function _validate()
    {
        if (empty($this->first_name) && empty($this->last_name) && empty($this->organization_name)) {
            $this->addError('firstName', 'Either a name or organization name must be specified.');
        }
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'A valid email must be specified');
        }
    }

    protected function beforeSave($args)
    {
        $this->first_name = trim(strtolower($this->first_name));
        $this->last_name = trim(strtolower($this->last_name));
        $this->organization_name = trim(strtolower($this->organization_name));
        $this->email = trim(strtolower($this->email));
    }

    // ======================================================================================================================== \\
}