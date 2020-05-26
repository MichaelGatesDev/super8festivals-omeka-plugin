<?php

class SuperEightFestivalsCity extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    use S8FLocation;

    public $country_id = 0;

    // ======================================================================================================================== \\

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Adding city: {$this->name} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updating city: {$this->name} ({$this->id})");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Added city: {$this->name} ({$this->id})");
            add_festival($this->id, 0, "{$this->name} default festival", "this is the default festival for {$this->name}");
        } else {
            logger_log(LogLevel::Info, "Updated city: {$this->name} ({$this->id})");
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