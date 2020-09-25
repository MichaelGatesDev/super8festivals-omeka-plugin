<?php

class SuperEightFestivalsFederationMagazine extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFederationDocument;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            ),
            S8FFederationDocument::get_db_columns()
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
            logger_log(LogLevel::Info, "Adding federation magazine ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updating federation magazine ({$this->id})");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Added federation magazine ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updated federation magazine ({$this->id})");
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted federation magazine ({$this->id})");
    }


    public function getResourceId()
    {
        return 'SuperEightFestivals_Federation_Document';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "federation_magazine";
    }

    public function get_dir(): ?string
    {
        if (get_federation_dir() == null) return null;
        return get_federation_dir() . "/magazines";
    }

    // ======================================================================================================================== \\
}