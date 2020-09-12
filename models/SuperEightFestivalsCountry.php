<?php

class SuperEightFestivalsCountry extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FLocation;

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
            S8FLocation::get_db_columns()
        );
    }

    public function get_db_pk()
    {
        return "id";
    }

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->name)) {
            $this->addError('name', "Name can not be blank!");
        }
        if (!is_numeric($this->latitude)) {
            $this->addError('latitude', "Latitude and Longitude may only be numeric.");
        }
        if (!is_numeric($this->longitude)) {
            $this->addError('longitude', "Latitude and Longitude may only be numeric.");
        }
    }


    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        if (array_key_exists("record", $args)) {
            $record = $args['record'];
        }
        if (array_key_exists("insert", $args)) {
            $insert = $args['insert'];
            if ($insert) {
                logger_log(LogLevel::Info, "Adding country: {$this->name} ({$this->id})");
            } else {
                logger_log(LogLevel::Info, "Updating country: {$this->name} ({$this->id})");
            }
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        if (array_key_exists("record", $args)) {
            $record = $args['record'];
        }
        if (array_key_exists("insert", $args)) {
            $insert = $args['insert'];
            if ($insert) {
                logger_log(LogLevel::Info, "Added country: {$this->name} ({$this->id})");
            } else {
                logger_log(LogLevel::Info, "Updated country: {$this->name} ({$this->id})");
            }
        }

        $this->create_files();
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        delete_country_records($this->id);
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted country: {$this->name} ({$this->id})");
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Country';
    }

    // ======================================================================================================================== \\

    function get_dir()
    {
        return get_countries_dir() . "/" . $this->name;
    }

    private function create_files()
    {
        if (!file_exists($this->get_dir())) {
            mkdir($this->get_dir());
        }
    }

    public function delete_files()
    {
        if (file_exists($this->get_dir())) {
            rrmdir($this->get_dir());
        }
    }

    // ======================================================================================================================== \\
}