<?php

class SuperEightFestivalsFestivalFilmCatalog extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public int $festival_id = 0;
    public int $file_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`festival_id`      INT(10) UNSIGNED NOT NULL",
                "`file_id`          INT(10) UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        $this->get_file()->delete();
    }

    // ======================================================================================================================== \\

    /**
     * @param $search_id
     * @return SuperEightFestivalsFestivalFilmCatalog|null
     */
    public static function get_by_id($search_id)
    {
        return parent::get_by_id($search_id);
    }

    /**
     * @return SuperEightFestivalsFestivalFilmCatalog[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    /**
     * @return SuperEightFestivalsFile|null
     */
    public function get_file()
    {
        return SuperEightFestivalsFile::get_by_id($this->file_id);
    }

    /**
     * @return SuperEightFestivalsFestival|null
     */
    public function get_festival()
    {
        return SuperEightFestivalsFestival::get_by_id($this->festival_id);
    }

    /**
     * @return SuperEightFestivalsCountry|null
     */
    public function get_country()
    {
        return SuperEightFestivalsCountry::get_by_id($this->get_festival()->get_country());
    }

    /**
     * @return SuperEightFestivalsCity|null
     */
    public function get_city()
    {
        return SuperEightFestivalsCity::get_by_id($this->get_festival()->get_city());
    }

    // ======================================================================================================================== \\
}