<?php

class SuperEightFestivalsContributor extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FPerson;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            ),
            S8FPerson::get_db_columns()
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    // ======================================================================================================================== \\
}