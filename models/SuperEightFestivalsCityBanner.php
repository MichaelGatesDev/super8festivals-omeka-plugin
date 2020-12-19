<?php

class SuperEightFestivalsCityBanner extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public int $city_id = 0;
    public int $file_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`city_id`   INT(10) UNSIGNED NOT NULL",
                "`file_id`   INT(10) UNSIGNED NOT NULL",
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
        if ($this->get_city()) $res = array_merge($res, ["city" => $this->get_city()->to_array()]);
        if ($this->get_file()) $res = array_merge($res, ["file" => $this->get_file()->to_array()]);
        return $res;
    }

    public static function create($arr = [])
    {
    }

    public function update($arr, $save = true)
    {
        if (!SuperEightFestivalsCity::get_by_id($city_id = $arr['city_id'])) throw new Exception("No city exists with id {$city_id}");
        parent::update($arr, $save);
    }

    // ======================================================================================================================== \\

    /**
     * @param $search_id
     * @return SuperEightFestivalsCityBanner|null
     */
    public static function get_by_id($search_id)
    {
        return parent::get_by_id($search_id);
    }

    /**
     * @return SuperEightFestivalsCityBanner[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    /**
     * @return SuperEightFestivalsCity|null
     */
    public function get_city()
    {
        return SuperEightFestivalsCity::get_by_id($this->city_id);
    }

    /**
     * @return SuperEightFestivalsCountry|null
     */
    public function get_country()
    {
        return $this->get_city()->get_country();
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