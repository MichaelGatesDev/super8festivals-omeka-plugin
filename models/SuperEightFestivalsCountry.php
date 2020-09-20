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

    public function get_table_pk()
    {
        return "id";
    }

    protected function _validate()
    {
        parent::_validate();
        $this->__validate();
        if (SuperEightFestivalsCountry::get_by_param('name', $this->name)) {
            throw new Error("A country with that name already exists!");
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
        $this->delete_children();
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted country: {$this->name} ({$this->id})");
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Country';
    }

    function delete_children()
    {
        foreach ($this->get_cities() as $city) {
            $city->delete();
        }
    }

    // ======================================================================================================================== \\

    function get_cities()
    {
        return SuperEightFestivalsCity::get_by_param('country_id', $this->id, 1);
    }

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