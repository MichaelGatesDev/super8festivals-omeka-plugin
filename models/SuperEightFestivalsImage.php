<?php

abstract class SuperEightFestivalsImage extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    /**
     * @var int
     */
    public $contributor_id = -1;
    /**
     * @var string
     */
    public $title = "";
    /**
     * @var string
     */
    public $description = "";
    /**
     * @var string
     */
    public $thumbnail_file_name = "";
    /**
     * @var string
     */
    public $thumbnail_url_web = "";
    /**
     * @var string
     */
    public $file_name = "";
    /**
     * @var string
     */
    public $file_url_web = "";

    // ======================================================================================================================== \\

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
        $this->create_thumbnail();
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

    function create_thumbnail()
    {
        if (!$this->has_thumbnail()) {
            $name = str_replace($this->get_internal_prefix() . "_", $this->get_internal_prefix() . "_thumb_", $this->file_name);
            $result = create_thumbnail($this->get_path(), $this->get_dir() . "/" . $name, 300);
            if ($result) {
                $this->thumbnail_file_name = $name;
                $this->save();
            } else {
                error_log("Failed to create thumbnail (original: $this->file_name)");
            }
        }
    }

    // ======================================================================================================================== \\
}