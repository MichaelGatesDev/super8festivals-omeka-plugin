<?php

class SuperEightFestivalsFestivalPrintMedia extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFestivalDocument;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            ),
            S8FFestivalDocument::get_db_columns()
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

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Print_Media';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "festival_print_media";
    }

    public function get_dir(): ?string
    {
        if ($this->get_festival() == null) return null;
        return $this->get_festival()->get_print_media_dir();
    }

    // ======================================================================================================================== \\
}