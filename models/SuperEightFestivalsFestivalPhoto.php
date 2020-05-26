<?php

class SuperEightFestivalsFestivalPhoto extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    use S8FFestivalImage;

    // ======================================================================================================================== \\

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