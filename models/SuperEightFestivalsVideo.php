<?php

abstract class SuperEightFestivalsVideo extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $contributor_id = -1;
    public string $title = "";
    public string $description = "";
    public string $thumbnailPathFile = "";
    public string $thumbnailPathWeb = "";
    public string $embed = "";

    protected function beforeSave($args)
    {
        $this->title = trim($this->title);
        $this->description = trim($this->description);
    }
}