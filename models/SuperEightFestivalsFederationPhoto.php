<?php

class SuperEightFestivalsFederationPhoto extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFederationImage;

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
            S8FFederationImage::get_db_columns()
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Adding federation photo ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updating federation photo ({$this->id})");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Added federation photo ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updated federation photo ({$this->id})");
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted federation photo ({$this->id})");
    }


    public function getResourceId()
    {
        return 'SuperEightFestivals_Federation_Photo';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "federation_photo";
    }

    public function get_dir(): ?string
    {
        if (get_federation_dir() == null) return null;
        return get_federation_dir() . "/photos";
    }

    // ======================================================================================================================== \\
}