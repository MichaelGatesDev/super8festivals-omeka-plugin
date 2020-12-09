<?php

class   SuperEightFestivalsFilmmakerPhoto extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public int $filmmaker_id = 0;
    public int $file_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`filmmaker_id`     INT(10) UNSIGNED NOT NULL",
                "`file_id`          INT(10) UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        if ($file = $this->get_file()) $file->delete();
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_filmmaker()) $res = array_merge($res, ["filmmaker" => $this->get_filmmaker()->to_array()]);
        if ($this->get_file()) $res = array_merge($res, ["file" => $this->get_file()->to_array()]);
        return $res;
    }

    public static function create($arr = [])
    {
    }

    public function update($arr, $save = true)
    {
        $cname = get_called_class();
        if (isset($arr['file'])) {
            $loc = $this->get_file();
            if (!$loc) throw new Exception("{$cname} is not associated with a SuperEightFestivalsFile");
            $loc->update($arr['file']);
        }

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
     * @return SuperEightFestivalsFilmmaker|null
     */
    public function get_filmmaker()
    {
        return SuperEightFestivalsFilmmaker::get_by_id($this->filmmaker_id);
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