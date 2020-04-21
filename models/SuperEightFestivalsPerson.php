<?php

abstract class SuperEightFestivalsPerson extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    /**
     * @var string
     */
    public $first_name = "";
    /**
     * @var string
     */
    public $last_name = "";
    /**
     * @var string
     */
    public $organization_name = "";
    /**
     * @var string
     */
    public $email = "";

    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    protected function _validate()
    {
//        if (empty($this->first_name) && empty($this->last_name) && empty($this->organization_name)) {
//            $this->addError('firstName', 'Either a name or organization name must be specified.');
//        }
//        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
//            $this->addError('email', 'A valid email must be specified');
//        }
    }

    protected function beforeSave($args)
    {
        $this->first_name = trim($this->first_name);
        $this->last_name = trim($this->last_name);
        $this->organization_name = trim($this->organization_name);
        $this->email = trim($this->email);
    }

    // ======================================================================================================================== \\

    public function get_display_name()
    {
        if ($this->first_name != "") return $this->first_name . " " . $this->last_name;
        if ($this->organization_name != "") return $this->organization_name;
        return $this->email;
    }

    // ======================================================================================================================== \\
}