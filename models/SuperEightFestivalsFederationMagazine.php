<?php

class SuperEightFestivalsFederationMagazine extends Super8FestivalsRecord
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

    public function to_array()
    {
        $res = parent::to_array();
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
            $file = $this->get_file();
            if (!$file) throw new Exception("{$cname} is not associated with a SuperEightFestivalsFile");
            $file->update($arr['file']);
        }

        parent::update($arr, $save);
    }

    // ======================================================================================================================== \\

    /**
     * @param $search_id
     * @return SuperEightFestivalsFederationMagazine|null
     */
    public static function get_by_id($search_id)
    {
        return parent::get_by_id($search_id);
    }

    /**
     * @return SuperEightFestivalsFederationMagazine[]
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