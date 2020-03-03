<?php

abstract class SuperEightFestivalsImage extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public int $contributor_id = -1;
    public string $title = "";
    public string $description = "";
    public string $thumbnail_file_name = "";
    public string $thumbnail_url_web = "";
    public string $file_name = "";
    public string $file_url_web = "";

    public function __construct()
    {
        parent::__construct();
    }

    protected function beforeSave($args)
    {
        $this->title = trim($this->title);
        $this->description = trim($this->description);
    }
}