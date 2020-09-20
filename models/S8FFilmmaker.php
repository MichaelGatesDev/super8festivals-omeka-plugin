<?php

trait S8FFilmmaker
{
    // ======================================================================================================================== \\

    public $city_id = 0;
    use S8FPerson;

    public static function get_db_columns()
    {
        return array_merge(
            array(
                "`city_id`        INT(10) UNSIGNED NOT NULL",
            ),
            S8FPerson::get_db_columns()
        );
    }

    // ======================================================================================================================== \\

    public function get_city()
    {
        return SuperEightFestivalsCity::get_by_id($this->city_id);
    }

    public function get_country()
    {
        return $this->get_city()->get_country();
    }

    // ======================================================================================================================== \\
}