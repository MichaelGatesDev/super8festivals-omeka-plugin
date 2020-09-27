<?php

class SuperEightFestivalsFederationPhoto extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFederationImage;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            ),
            S8FFederationImage::get_db_columns()
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "federation_photo";
    }

    // ======================================================================================================================== \\
}