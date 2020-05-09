<?php

abstract class SuperEightFestivalsImage extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
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
    public $file_name = "";

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

    public function create_thumbnail()
    {
        // no file to create a thumbnail from
        if ($this->file_name === null || $this->file_name === "" || is_dir($this->get_path()) || !file_exists($this->get_path())) {
            error_log("Failed to create thumbnail: file does not exist or is a directory!");
            return;
        }
        if ($this->has_thumbnail()) {
            error_log("Failed to create thumbnail: a thumbnail already exists!");
            return;
        }
        try {
            $name = pathinfo($this->file_name, PATHINFO_FILENAME) . "_thumb.jpg";
            $this->thumbnail_file_name = $name;
            $imagick = new Imagick($this->get_path());
            $imagick = $imagick->flattenImages();
            $imagick->scaleImage(300, 0);
            $imagick->setImageFormat("jpg");
            $imagick->writeImage($this->get_thumbnail_path());
        } catch (ImagickException $e) {
            error_log("Failed to create thumbnail (original: $this->file_name)");
            error_log($e);
        }
    }

    public function delete_files()
    {
        delete_file($this->get_path());
        delete_file($this->get_thumbnail_path());
    }

    public function get_file_type()
    {
        return pathinfo($this->file_name, PATHINFO_EXTENSION);
    }

    // ======================================================================================================================== \\
}