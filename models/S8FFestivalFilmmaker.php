<?php

trait S8FFestivalFilmmaker
{
    // ======================================================================================================================== \\

    use S8FFestivalPerson;

    public static function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            ),
            S8FFestivalPerson::get_db_columns()
        );
    }

    // ======================================================================================================================== \\

    public function get_festival()
    {
        return get_festival_by_id($this->festival_id);
    }

    public function get_city()
    {
        return $this->get_festival()->get_city();
    }

    public function get_country()
    {
        return $this->get_festival()->get_country();
    }

    // ======================================================================================================================== \\
}