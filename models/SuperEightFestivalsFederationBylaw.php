<?php

class SuperEightFestivalsFederationBylaw extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public ?int $file_id = null;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`file_id`   INT UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    public function get_db_foreign_keys()
    {
        return array_merge(
            array(
                "FOREIGN KEY (`file_id`) REFERENCES {db_prefix}{table_prefix}files(`id`) ON DELETE CASCADE",
            ),
            parent::get_db_foreign_keys()
        );
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        if ($file = $this->get_file()) $file->delete_files();
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
     * @return SuperEightFestivalsFederationBylaw|null
     */
    public static function get_by_id($search_id)
    {
        return parent::get_by_id($search_id);
    }

    /**
     * @return SuperEightFestivalsFederationBylaw[]
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