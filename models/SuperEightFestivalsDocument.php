<?php

abstract class SuperEightFestivalsDocument extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    /**
     * @var int
     */
    public $contributor_id = 0;
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
    /**
     * @var string
     */
    public $embed = "";

    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        if (!parent::isValid()) return;
        $this->title = trim($this->title);
        $this->description = trim($this->description);
        $this->create_thumbnail();
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
    }

    // ======================================================================================================================== \\

    function get_contributor()
    {
        return get_contributor_by_id($this->contributor_id);
    }

    public abstract function get_internal_prefix(): string;

    public abstract function get_dir(): string;

    public abstract function get_path(): string;

    public abstract function get_thumbnail_path(): string;

    public function has_thumbnail(): bool
    {
        return file_exists($this->get_thumbnail_path()) && !is_dir($this->get_thumbnail_path());
    }

    private function create_thumbnail()
    {
        if (is_dir($this->get_path())) return; // path is a directory
        if ($this->has_thumbnail()) return; // already has thumbnail
        try {
            $name = str_replace($this->get_internal_prefix() . "_", $this->get_internal_prefix() . "_thumb_", $this->file_name);
            error_log("Creating thumbnail for: " . $this->get_path() . " (" . $this->file_name . ") as (" . $name . ")");

            $imagick = new Imagick();
            $imagick->readImage($this->get_path() . "[0]");
            $imagick = $imagick->flattenImages();
            $imagick->setImageFormat("jpg");
            $imagick->writeImage($name);
            error_log("Thumbnail creation complete!");
        } catch (ImagickException $e) {
            error_log("Failed to create thumbnail (original: $this->file_name)");
            error_log($e);
        }
    }

    public function delete_files()
    {
        if (file_exists($this->get_path())) {
            delete_file($this->get_path());
        }
        if (file_exists($this->get_thumbnail_path())) {
            delete_file($this->get_thumbnail_path());
        }
    }

    // ======================================================================================================================== \\

}