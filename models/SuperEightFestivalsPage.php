<?php

class SuperEightFestivalsPage extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    /**
     * @var string
     */
    public $title = "";
    /**
     * @var string
     */
    public $url = "";
    /**
     * @var string
     */
    public $content = "";

    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    protected function beforeSave($args)
    {
        $this->title = trim($this->title);
        $this->url = trim($this->url);
        $this->content = trim($this->content);
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Page';
    }

    // ======================================================================================================================== \\
}