<?php

class SuperEightFestivalsFestivalFilm extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    use S8FMetadata;
    use S8FVideo;

//    use S8FPreviewable;

    public $festival_id = 0;
    public $filmmaker_id = 0;

    // ======================================================================================================================== \\

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Adding festival film for {$this->get_festival()->get_title()} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updating festival film for {$this->get_festival()->get_title()} ({$this->id})");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Added festival film for {$this->get_festival()->get_title()} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updated festival film for {$this->get_festival()->get_title()} ({$this->id})");
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted festival film for festival {$this->id}");
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Film';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "festival_film";
    }

    function get_filmmaker()
    {
        return get_filmmaker_by_id($this->filmmaker_id);
    }

    public function get_festival()
    {
        return get_festival_by_id($this->festival_id);
    }

    public function get_city()
    {
        return $this->get_festival()->get_city();
    }

    public function get_country()
    {
        return $this->get_festival()->get_country();
    }

    public function get_dir(): ?string
    {
        if ($this->get_festival() == null) return null;
        return $this->get_festival()->get_films_dir();
    }

    // ======================================================================================================================== \\
}