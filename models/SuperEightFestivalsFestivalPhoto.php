<?php

class SuperEightFestivalsFestivalPhoto extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFestivalImage;

    // ======================================================================================================================== \\

    public function get_clazz()
    {
        return self::class;
    }

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            ),
            S8FFestivalImage::get_db_columns()
        );
    }

    public function get_db_pk()
    {
        return "id";
    }

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Adding festival photo for {$this->get_festival()->get_title()} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updating festival photo for {$this->get_festival()->get_title()} ({$this->id})");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Added festival photo for {$this->get_festival()->get_title()} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updated festival photo for {$this->get_festival()->get_title()} ({$this->id})");
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted festival photo for festival: {$this->id}");
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Photo';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "festival_photo";
    }

    public function get_dir(): ?string
    {
        if ($this->get_festival() == null) return null;
        return $this->get_festival()->get_photos_dir();
    }

    // ======================================================================================================================== \\
}