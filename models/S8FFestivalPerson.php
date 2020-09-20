<?php

trait S8FFestivalPerson
{
    // ======================================================================================================================== \\

    public $festival_id = 0;
    use S8FPerson;

    public static function get_db_columns()
    {
        return array_merge(
            array(
                "`festival_id`  INT(10) UNSIGNED NOT NULL",
            ),
            S8FPerson::get_db_columns()
        );
    }

    // ======================================================================================================================== \\

    public function get_festival()
    {
        return SuperEightFestivalsFestival::get_by_id($this->festival_id);
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