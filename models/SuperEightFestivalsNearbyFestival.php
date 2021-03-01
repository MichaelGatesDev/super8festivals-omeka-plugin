<?php

class SuperEightFestivalsNearbyFestival extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public ?int $city_id = null;
    public string $city_name = "";
    public int $year = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`city_id`      INT UNSIGNED    NOT NULL",
                "`city_name`    VARCHAR(255)    NOT NULL",
                "`year`         INT(4)          NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    public function get_db_foreign_keys()
    {
        return array_merge(
            array(
                "FOREIGN KEY (`city_id`) REFERENCES {db_prefix}{table_prefix}cities(`id`) ON DELETE CASCADE",
            ),
            parent::get_db_foreign_keys()
        );
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_city()) $res = array_merge($res, ["city" => $this->get_city()->to_array()]);
        return $res;
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        $this->delete_children();
    }

    public function delete_children()
    {
        foreach (SuperEightFestivalsNearbyFestivalPhoto::get_by_param('nearby_festival_id', $this->id) as $record) $record->beforeDelete();
        foreach (SuperEightFestivalsNearbyFestivalPrintMedia::get_by_param('nearby_festival_id', $this->id) as $record) $record->beforeDelete();
    }

    public static function create($arr = [])
    {
//        $existing = SuperEightFestivalsNearbyFestival::get_by_param("year", $arr["year"]);
//        if ($existing && count($existing) > 0) {
//            throw new Exception("A nearby festival with that year already exists for this city!");
//        }

        $festival = new SuperEightFestivalsNearbyFestival();

        try {
            $festival->update($arr);
            return $festival;
        } catch (Exception $e) {
            return null;
        }
    }

    public function update($arr, $save = true)
    {
        parent::update($arr, $save);
    }

    // ======================================================================================================================== \\

    /**
     * @return SuperEightFestivalsNearbyFestival[]
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

    public function get_country()
    {
        return $this->get_city()->get_country() ?? null;
    }

    public function get_photos()
    {
        return SuperEightFestivalsNearbyFestivalPhoto::get_by_param('nearby_festival_id', $this->id);
    }

    public function get_print_media()
    {
        return SuperEightFestivalsNearbyFestivalPrintMedia::get_by_param('nearby_festival_id', $this->id);
    }

    public function get_title()
    {
        $year = $this->year != 0 ? $this->year : "uncategorized";
        return "{$this->city_name} {$year} festival";
    }

    // ======================================================================================================================== \\
}