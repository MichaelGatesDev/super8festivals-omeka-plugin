<?php


class SuperEightFestivalsEmbed extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public string $embed = "";
    public string $title = "";
    public string $description = "";

    public ?int $contributor_id = null;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`embed`                        TEXT(65535)",
                "`title`                        VARCHAR(255)",
                "`description`                  TEXT(65535)",

                "`contributor_id`               INT UNSIGNED",
            ),
            parent::get_db_columns()
        );
    }

    public function get_db_foreign_keys()
    {
        return array_merge(
            array(
                "FOREIGN KEY (`contributor_id`) REFERENCES {db_prefix}{table_prefix}contributors(`id`) ON DELETE SET NULL",
            ),
            parent::get_db_foreign_keys()
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

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_contributor()) $res = array_merge($res, ["contributor" => $this->get_contributor()->to_array()]);
        return $res;
    }

    // ======================================================================================================================== \\

    protected function beforeSave($args)
    {
        if($this->contributor_id == 0) $this->contributor_id = null;
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