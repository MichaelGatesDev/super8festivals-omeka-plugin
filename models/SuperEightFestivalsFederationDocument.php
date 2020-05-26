<?php

class SuperEightFestivalsFederationDocument extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    use S8FFederationDocument;

    // ======================================================================================================================== \\

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Adding federation document ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updating federation document ({$this->id})");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Added federation document ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updated federation document ({$this->id})");
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted federation document ({$this->id})");
    }


    public function getResourceId()
    {
        return 'SuperEightFestivals_Federation_Document';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "federation_document";
    }

    public function get_dir(): ?string
    {
        if (get_federation_dir() == null) return null;
        return get_federation_dir() . "/documents";
    }

    // ======================================================================================================================== \\
}