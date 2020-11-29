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
        $this->get_file()->delete();
    }

    public function to_array()
    {
        return array_merge(
            parent::to_array(),
            ["city" => $this->get_city()],
            ["file" => $this->get_file()],
        );
    }

    public static function create($arr = [])
    {
    }

    public function update($arr, $save = true)
    {
        if (!SuperEightFestivalsCityBanner::get_by_id($city_id = $arr['city_id'])) throw new Exception("No city exists with id {$city_id}");
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