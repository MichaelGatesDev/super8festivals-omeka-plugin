<?php

class SuperEightFestivalsCountry extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    use S8FLocation;

    // ======================================================================================================================== \\

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Adding country: {$this->name} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updating country: {$this->name} ({$this->id})");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Added country: {$this->name} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updated country: {$this->name} ({$this->id})");
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