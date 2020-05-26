<?php

class SuperEightFestivalsFestivalFilmCatalog extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    use S8FFestivalDocument;

    // ======================================================================================================================== \\

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Adding festival film catalog for {$this->get_festival()->get_title()} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updating festival film catalog for {$this->get_festival()->get_title()} ({$this->id})");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Added festival film catalog for {$this->get_festival()->get_title()} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updated festival film catalog for {$this->get_festival()->get_title()} ({$this->id})");
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted festival film catalog for festival {$this->id}");
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Film_Catalog';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "festival_film_catalog";
    }

    public function get_dir(): ?string
    {
        if ($this->get_festival() == null) return null;
        return $this->get_festival()->get_film_catalogs_dir();
    }

    // ======================================================================================================================== \\
}