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
//        $this->create_thumbnail();
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        delete_file($this->get_thumbnail_path());
        delete_file($this->get_path());
    }

    // ======================================================================================================================== \\

    public abstract function get_internal_prefix(): string;

    public abstract function get_dir(): string;

    public abstract function get_path(): string;

    public abstract function get_thumbnail_path(): string;

    public function has_thumbnail(): bool
    {
        return file_exists($this->get_thumbnail_path()) && !is_dir($this->get_thumbnail_path());
    }

    public function delete_files()
    {
        delete_file($this->get_path());
        delete_file($this->get_thumbnail_path());
    }

    // ======================================================================================================================== \\
}