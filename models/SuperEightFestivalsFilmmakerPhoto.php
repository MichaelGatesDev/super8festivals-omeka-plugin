<?php

class SuperEightFestivalsFilmmakerPhoto extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public int $file_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`file_id`   INT(10) UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        $this->get_file()->delete();
    }

    public static function create($arr = [])
    {
    }

    public function update($arr, $save = true)
    {
        parent::update($arr, $save);
    }
    // ======================================================================================================================== \\

    /**
     * @param $search_id
     * @return SuperEightFestivalsFilmmakerPhoto|null
     */
    public static function get_by_id($search_id)
    {
        return parent::get_by_id($search_id);
    }

    /**
     * @return SuperEightFestivalsFilmmakerPhoto[]
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

    // ======================================================================================================================== \\
}