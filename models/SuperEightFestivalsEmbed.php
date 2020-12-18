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

    public static function create($arr = [])
    {
        $embed = new SuperEightFestivalsEmbed();
        $embed->update($arr);
        return $embed;
    }

    public function update($arr, $save = true)
    {
        parent::update($arr, $save);
    }

    // ======================================================================================================================== \\

    /**
     * @return SuperEightFestivalsFile[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    /**
     * @return SuperEightFestivalsContributor|null
     */
    public function get_contributor()
    {
        return SuperEightFestivalsContributor::get_by_id($this->contributor_id);
    }

    // ======================================================================================================================== \\
}