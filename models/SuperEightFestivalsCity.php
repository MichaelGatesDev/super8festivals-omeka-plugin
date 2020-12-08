<?php

class SuperEightFestivalsCity extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public int $country_id = 0;
    public int $location_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`country_id`       INT(10) UNSIGNED NOT NULL",
                "`location_id`      INT(10) UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        if (array_key_exists("insert", $args)) {
            $insert = $args['insert'];
            if ($insert) {
                $festival = new SuperEightFestivalsFestival();
                $festival->city_id = $this->id;
                $festival->save();
            }
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_children();
    }

    function delete_children()
    {
        // banner
        $banner = $this->get_banner();
        if ($banner != null) $banner->delete();

        // festivals
        $festivals = $this->get_festivals();
        foreach ($festivals as $festival) {
            $festival->delete();
        }
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_location()) $res = array_merge($res, ["location" => $this->get_location()->to_array()]);
        return $res;
    }


    public static function create($arr = [])
    {
        $city = new SuperEightFestivalsCity();
        $country_id = $arr['country_id'];
        $city->country_id = $country_id;
        $location = SuperEightFestivalsLocation::create($arr['location']);
        $city->location_id = $location->id;

        try {
            $city->save();
            return $city;
        } catch (Exception $e) {
            $location->delete();
            return null;
        }
    }

    public function update($arr, $save = true)
    {
        $cname = get_called_class();
        if (isset($arr['location'])) {
            $loc = $this->get_location();
            if (!$loc) throw new Exception("{$cname} is not associated with a SuperEightFestivalsLocation");
            $loc->update($arr['location']);
        }

        parent::update($arr, $save);
    }

    // ======================================================================================================================== \\

    /**
     * @return SuperEightFestivalsCity[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    /**
     * @param $name string name of the country
     * @return SuperEightFestivalsCity|null
     */
    public static function get_by_name(string $name)
    {
        $all = SuperEightFestivalsCity::get_all();
        foreach ($all as $single) {
            if ($single->get_location()->name === $name) return $single;
        }
        return null;
    }

    /**
     * @return SuperEightFestivalsCountry|null
     */
    public function get_country()
    {
        return SuperEightFestivalsCountry::get_by_id($this->country_id);
    }

    /**
     * @return SuperEightFestivalsCityBanner|null
     */
    public function get_banner()
    {
        $results = SuperEightFestivalsCityBanner::get_by_param('city_id', $this->id, 1);
        return count($results) > 0 ? $results[0] : null;
    }

    /**
     * @return SuperEightFestivalsFestival[]|null
     */
    function get_festivals()
    {
        return SuperEightFestivalsFestival::get_by_param('city_id', $this->id);
    }

    /**
     * @return SuperEightFestivalsLocation|null
     */
    public function get_location()
    {
        return SuperEightFestivalsLocation::get_by_id($this->location_id);
    }

    // ======================================================================================================================== \\
}