<?php

class SuperEightFestivalsCityBanner extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public $city_id = 0;
    use S8FPreviewable;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
                "`city_id`   INT(10) UNSIGNED NOT NULL",
            ),
            S8FPreviewable::get_db_columns()
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_City_Banner';
    }

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Adding city banner for {$this->get_city()->name} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updating city banner for {$this->get_city()->name} ({$this->id})");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Added city banner for {$this->get_city()->name} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updated city banner for {$this->get_city()->name} ({$this->id})");
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        logger_log(LogLevel::Info, "Deleted city banner for city {$this->id}");
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "city_banner";
    }

    public function get_country()
    {
        return $this->get_city()->get_country();
    }

    public function get_city()
    {
        return SuperEightFestivalsCity::get_by_id($this->city_id);
    }

    public function get_dir(): ?string
    {
        if ($this->get_city() == null) return null;
        return $this->get_city()->get_dir();
    }

    // ======================================================================================================================== \\
}