<?php

class SuperEightFestivalsCountry extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public ?int $location_id = null;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`location_id`      INT UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    public function get_db_foreign_keys()
    {
        return array_merge(
            array(
                "FOREIGN KEY (`location_id`) REFERENCES {db_prefix}{table_prefix}locations(`id`) ON DELETE CASCADE",
            ),
            parent::get_db_foreign_keys()
        );
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        $this->delete_children();
    }

    function delete_children()
    {
        foreach ($this->get_cities() as $city) {
            $city->beforeDelete();
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
        $country = new SuperEightFestivalsCountry();
        $location = SuperEightFestivalsLocation::create($arr['location']);
        $country->location_id = $location->id;
        try {
            $country->save();
            return $country;
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
     * @return SuperEightFestivalsCountry[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    /**
     * @param $name string name of the country
     * @return SuperEightFestivalsCountry|null
     */
    public static function get_by_name(string $name)
    {
        $all = SuperEightFestivalsCountry::get_all();
        foreach ($all as $single) {
            if ($single->get_location()->name === $name) return $single;
        }
        return null;
    }

    /**
     * @return SuperEightFestivalsCity[]|null
     */
    function get_cities()
    {
        return SuperEightFestivalsCity::get_by_param('country_id', $this->id);
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