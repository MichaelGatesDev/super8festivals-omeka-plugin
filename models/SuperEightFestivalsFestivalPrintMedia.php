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

    /**
     * @return SuperEightFestivalsFestivalPrintMedia[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "festival_print_media";
    }

    // ======================================================================================================================== \\
}