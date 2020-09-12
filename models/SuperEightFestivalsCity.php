<?php

class SuperEightFestivalsCity extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public $country_id = 0;
    public $description = "";
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
                "`id`           INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
                "`country_id`   INT(10) UNSIGNED NOT NULL",
                "`description`  TEXT(65535)",
            ),
            S8FLocation::get_db_columns()
        );
    }

    public function get_db_pk()
    {
        return "id";
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
                logger_log(LogLevel::Info, "Adding city: {$this->name} ({$this->id})");
            } else {
                logger_log(LogLevel::Info, "Updating city: {$this->name} ({$this->id})");
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
                logger_log(LogLevel::Info, "Adding city: {$this->name} ({$this->id})");
                add_festival($this->id, 0);
            } else {
                logger_log(LogLevel::Info, "Updating city: {$this->name} ({$this->id})");
            }
        }

        $this->create_files();
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        delete_city_records($this->id);
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted city: {$this->name} ({$this->id})");
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_City';
    }

    // ======================================================================================================================== \\

    public function get_country(): ?SuperEightFestivalsCountry
    {
        return $this->getTable('SuperEightFestivalsCountry')->find($this->country_id);
    }

    public function get_dir(): ?string
    {
        if ($this->get_country() == null) return null;
        return $this->get_country()->get_dir() . "/" . $this->name;
    }

    function get_festivals_dir(): ?string
    {
        if ($this->get_dir() == null) return null;
        return $this->get_dir() . "/festivals";
    }

    function get_filmmakers_dir(): ?string
    {
        if ($this->get_dir() == null) return null;
        return $this->get_dir() . "/filmmakers";
    }


    private function create_files()
    {
        if ($this->get_dir() == null) {
            logger_log(LogLevel::Error, "Root directory is null for city: {$this->name} ({$this->id})");
            return;
        }

        if ($this->get_dir() != null) {
            if (!file_exists($this->get_dir())) {
                mkdir($this->get_dir());
            }
        }
        if ($this->get_festivals_dir() != null) {
            if (!file_exists($this->get_festivals_dir())) {
                mkdir($this->get_festivals_dir());
            }
        }
    }

    public function delete_files()
    {
        if ($this->get_dir() != null) {
            if (file_exists($this->get_dir())) {
                rrmdir($this->get_dir());
            }
        }
    }

    // ======================================================================================================================== \\
}