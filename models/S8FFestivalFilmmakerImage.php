<?php

trait S8FFestivalFilmmakerImage
{
    // ======================================================================================================================== \\

    public $filmmaker_id = 0;
    use S8FFestivalImage;

    public static function get_db_columns()
    {
        return array_merge(
            array(
                "`filmmaker_id`  INT(10) UNSIGNED NOT NULL",
            ),
            S8FFestivalImage::get_db_columns()
        );
    }

    // ======================================================================================================================== \\

    public function get_festival()
    {
        return get_festival_by_id($this->filmmaker_id);
    }

    public function get_city()
    {
        return $this->get_festival()->get_city();
    }

    public function get_country()
    {
        return $this->get_festival()->get_country();
    }

    public function get_filmmaker()
    {
        return get_filmmaker_by_id($this->filmmaker_id);
    }

    // ======================================================================================================================== \\
}