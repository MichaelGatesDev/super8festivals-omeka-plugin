<?php

class SuperEightFestivalsContributor extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FPerson;

    // ======================================================================================================================== \\

    public function get_clazz()
    {
        return self::class;
    }

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
                "`city_id`   INT(10) UNSIGNED NOT NULL",
            ),
            S8FPerson::get_db_columns()
        );
    }

    public function get_db_pk()
    {
        return "id";
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Contributor';
    }

    // ======================================================================================================================== \\
}