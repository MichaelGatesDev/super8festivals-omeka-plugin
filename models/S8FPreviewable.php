<?php

trait S8FPreviewable
{
    // ======================================================================================================================== \\

    use S8FRecord;

    public $file_name = "";
    public $thumbnail_file_name = "";

    public static function get_db_columns()
    {
        return array(
            "`file_name`           TEXT(65535)",
            "`thumbnail_file_name` TEXT(65535)",
        );

    }

    // ======================================================================================================================== \\

    /**
     * @return string the directory which this resource belongs to
     */
    public abstract function get_dir(): string;

    /**
     * @return string The absolute path to the resource
     */
    public function get_path(): ?string
    {
        return $this->file_name != "" ? $this->get_dir() . "/" . $this->file_name : null;
    }

    /**
     * @return string The absolute path to the resource's thumbnail
     */
    public function get_thumbnail_path(): ?string
    {
        return $this->thumbnail_file_name != "" ? $this->get_dir() . "/" . $this->thumbnail_file_name : null;
    }

    /**
     * @return bool Returns true if the thumbnail file exists and is not a directory
     */
    public function has_thumbnail(): bool
    {
        return $this->get_thumbnail_path() != null && file_exists($this->get_thumbnail_path()) && !is_dir($this->get_thumbnail_path());
    }

    public function create_thumbnail()
    {
        // no file to create a thumbnail from
        if ($this->file_name === null || $this->file_name === "" || $this->get_path() === "" || is_dir($this->get_path()) || !file_exists($this->get_path())) {
            error_log("Failed to create thumbnail: file does not exist or is a directory!");
            return false;
        }
        if ($this->has_thumbnail()) {
            error_log("Failed to create thumbnail: a thumbnail already exists!");
            return false;
        }
        try {
            $name = pathinfo($this->file_name, PATHINFO_FILENAME) . "_thumb.jpg";
            $this->thumbnail_file_name = $name;
            $imagick = new Imagick($this->get_path());
//            $imagick = $imagick->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
            $imagick->setFirstIterator();
//            $imagick->setBackgroundColor("white");
            $imagick->scaleImage(300, 0);
            $imagick->setImageFormat("jpg");
            $imagick->writeImage($this->get_thumbnail_path());
            $this->save();
            return true;
        } catch (ImagickException $e) {
            error_log("Failed to create thumbnail (original: $this->file_name)");
            error_log($e);
            return false;
        }
    }

    public function delete_thumbnail()
    {
        if ($this->has_thumbnail()) {
            delete_file($this->get_thumbnail_path());
        }
        $this->thumbnail_file_name = "";
        $this->save();
    }

    public function delete_files()
    {
        delete_file($this->get_path());
        delete_file($this->get_thumbnail_path());
    }

    // ======================================================================================================================== \\
}