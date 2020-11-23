<?php


class SuperEightFestivalsEmbed extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public string $embed = "";
    public string $title = "";
    public string $description = "";

    public int $contributor_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`embed`                        TEXT(65535)",
                "`title`                        VARCHAR(255)",
                "`description`                  TEXT(65535)",

                "`contributor_id`               INT(10) UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    // ======================================================================================================================== \\

    /**
     * @return SuperEightFestivalsFile[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    // ======================================================================================================================== \\
}