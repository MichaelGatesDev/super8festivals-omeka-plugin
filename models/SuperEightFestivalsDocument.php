<?php

abstract class SuperEightFestivalsDocument extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public int $contributor_id = -1;
    public string $title = "";
    public string $description = "";
    public string $thumbnail_file_name = "";
    public string $thumbnail_url_web = "";
    public string $file_name = "";
    public string $file_url_web = "";
    public string $embed = "";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_file_type()
    {
        return pathinfo($this->file_name, PATHINFO_EXTENSION);
    }

    protected function beforeSave($args)
    {
        $this->title = trim($this->title);
        $this->description = trim($this->description);
    }
}