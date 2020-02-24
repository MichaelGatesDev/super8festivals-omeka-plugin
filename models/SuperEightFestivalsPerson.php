<?php

abstract class SuperEightFestivalsPerson extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public string $firstName = "";
    public string $lastName = "";
    public string $organizationName = "";
    public string $email = "";

    protected function _validate()
    {
        if (empty($this->firstName) && empty($this->lastName) && empty($this->organizationName)) {
            $this->addError('firstName', 'Either a name or organization name must be specified.');
        }
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'A valid email must be specified');
        }
    }


    protected function beforeSave($args)
    {
        $this->firstName = trim($this->firstName);
        $this->lastName = trim($this->lastName);
        $this->organizationName = trim($this->organizationName);
        $this->email = trim($this->email);
    }
}