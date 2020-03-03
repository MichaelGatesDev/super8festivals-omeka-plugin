<?php

abstract class SuperEightFestivalsVideo extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public int $contributor_id = -1;
    public string $title = "";
    public string $description = "";
    public string $thumbnail_file_name = "";
    public string $thumbnail_url_web = "";
    public string $embed = "";

    public function __construct()
    {
        parent::__construct();
    }

    function get_contributor()
    {
        return get_contributor_by_id($this->contributor_id);
    }

    protected function beforeSave($args)
    {
        $this->title = trim($this->title);
        $this->description = trim($this->description);
    }
}