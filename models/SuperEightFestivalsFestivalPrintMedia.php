<?php

class SuperEightFestivalsFestivalPrintMedia extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public ?int $festival_id = null;
    public ?int $file_id = null;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`festival_id`      INT UNSIGNED NOT NULL",
                "`file_id`          INT UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    public function get_db_foreign_keys()
    {
        return array_merge(
            array(
                "FOREIGN KEY (`festival_id`) REFERENCES {db_prefix}{table_prefix}festivals(`id`) ON DELETE CASCADE",
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
        if ($this->get_festival()) $res = array_merge($res, ["festival" => $this->get_festival()->to_array()]);
        if ($this->get_file()) $res = array_merge($res, ["file" => $this->get_file()->to_array()]);
        return $res;
    }

    public static function create($arr = [])
    {
    }

    public function update($arr, $save = true)
    {
        $cname = get_called_class();
        if (isset($arr['festival'])) {
            $festival = $this->get_festival();
            if (!$festival) throw new Exception("{$cname} is not associated with a SuperEightFestivalsFestival");
            $festival->update($arr['festival']);
        }
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
     * @return SuperEightFestivalsFestivalPrintMedia|null
     */
    public static function get_by_id($search_id)
    {
        return parent::get_by_id($search_id);
    }

    /**
     * @return SuperEightFestivalsFestivalPrintMedia[]
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