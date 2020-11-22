<?php


class SuperEightFestivalsFile extends Super8FestivalsRecord
{
    public int $created_by_id = 0;
    public string $created_at = "";

    public int $last_modified_by_id = 0;
    public string $modified_at = "";

    public string $file_name = "";
    public string $thumbnail_file_name = "";
    public string $title = "";
    public string $description = "";

    public int $resource_relationship_id = 0;
    public int $contributor_id = 0;

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`                           INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
                "`created_by_id`                INT(10) UNSIGNED NOT NULL",
                "`created_at`                   VARCHAR(255) NOT NULL",

                "`last_modified_by_id`          INT(10) UNSIGNED NOT NULL",
                "`modified_at`                  VARCHAR(255) NOT NULL",

                "`file_name`                    VARCHAR(255)",
                "`thumbnail_file_name`          VARCHAR(255)",
                "`title`                        VARCHAR(255)",
                "`description`                  TEXT(65535)",

                "`resource_relationship_id`     INT(10) UNSIGNED NOT NULL",
                "`contributor_id`               INT(10) UNSIGNED NOT NULL",
            ),
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    protected function beforeSave($args)
    {
        if (array_key_exists("record", $args)) {
            $record = $args['record'];
        }
        if (array_key_exists("insert", $args)) {
            $insert = $args['insert'];
            if ($insert) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            else {
                $this->modified_at = date('Y-m-d H:i:s');
            }
        }
        parent::beforeSave($args);
    }
    protected function beforeDelete()
    {
        parent::beforeDelete();
        if($this->getRelationship())
        $this->getRelationship()->delete();
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
    }

    /**
     * @return string The absolute path to the resource
     */
    public function get_path(): ?string
    {
        if (empty($this->file_name)) return null;
        return get_uploads_dir() . "/" . $this->file_name;
    }

    /**
     * @return string The absolute path to the resource's thumbnail
     */
    public function get_thumbnail_path(): ?string
    {
        if (empty($this->thumbnail_file_name)) return null;
        return get_uploads_dir() . "/" . $this->thumbnail_file_name;
    }

    /**
     * @return bool Returns true if the thumbnail file exists and is not a directory
     */
    public function has_thumbnail(): bool
    {
        return $this->get_thumbnail_path() != null &&
            file_exists($this->get_thumbnail_path()) &&
            !is_dir($this->get_thumbnail_path());
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

    public function delete_files()
    {
        delete_file($this->get_path());
        delete_file($this->get_thumbnail_path());
    }

    public function upload_from_post($formInputName = "file", $file_prefix = "")
    {
        list($original_name, $temporary_name, $extension) = get_temporary_file($formInputName);
        $newFileName = uniqid($file_prefix . "_") . "." . $extension;
        move_tempfile_to_dir($temporary_name, $newFileName, get_uploads_dir());
        $this->file_name = $newFileName;
        $this->create_thumbnail();
    }

    /**
     * @return SuperEightFestivalsFile[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    public function getRelationship()
    {
        $relationship = SuperEightFestivalsResourceRelationship::get_by_id(($this->resource_relationship_id));
        if (!$relationship) return null;
        return $relationship;
    }
}