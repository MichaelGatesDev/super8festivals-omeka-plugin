<?php

class SuperEightFestivalsFestivalFilm extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFestivalVideo;

//    use S8FPreviewable;
    public $filmmaker_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
                "`filmmaker_id`   INT(10) UNSIGNED NOT NULL",
            ),
            S8FFestivalVideo::get_db_columns()
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "festival_film";
    }

    function get_filmmaker()
    {
        return SuperEightFestivalsFilmmaker::get_by_id($this->filmmaker_id);
    }

    // ======================================================================================================================== \\
}