<?php


class SuperEightFestivalsCityTimeline extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public ?int $city_id = null;
    public ?int $timeline_id = null;

    // ======================================================================================================================== \\=

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`city_id`              INT UNSIGNED NOT NULL",
                "`timeline_id`          INT UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    public function get_db_foreign_keys()
    {
        return array_merge(
            array(
                "FOREIGN KEY (`city_id`)        REFERENCES {db_prefix}{table_prefix}cities(`id`)    ON DELETE CASCADE",
                "FOREIGN KEY (`timeline_id`)    REFERENCES {db_prefix}{table_prefix}timelines(`id`) ON DELETE CASCADE",
            ),
            parent::get_db_foreign_keys()
        );
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        if ($timeline = $this->get_timeline()) $timeline->delete();
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_timeline()) $res = array_merge($res, ["timeline" => $this->get_timeline()->to_array()]);
        return $res;
    }

    public static function create($arr = [])
    {
        $city_timeline = new SuperEightFestivalsCityTimeline();
        $timeline = SuperEightFestivalsTimeline::create($arr['timeline']);
        $city_timeline->timeline_id = $timeline->id;
        $city_timeline->update($arr, false);
        try {
            $city_timeline->save();
            return $city_timeline;
        } catch (Exception $e) {
            $timeline->delete();
            throw $e;
        }
    }

    public function update($arr, $save = true)
    {
        $cname = get_called_class();
        if (isset($arr['timeline'])) {
            $timeline = $this->get_timeline();
            if (!$timeline) throw new Exception("{$cname} is not associated with a SuperEightFestivalsTimeline");
            $timeline->update($arr['timeline']);
        }

        parent::update($arr, $save);
    }

    // ======================================================================================================================== \\

    /**
     * @param $search_id
     * @return SuperEightFestivalsCityTimeline|null
     */
    public static function get_by_id($search_id)
    {
        return parent::get_by_id($search_id);
    }

    /**
     * @return SuperEightFestivalsCityTimeline[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    /**
     * @return SuperEightFestivalsTimeline|null
     */
    public function get_timeline()
    {
        return SuperEightFestivalsTimeline::get_by_id($this->timeline_id);
    }

    /**
     * @return SuperEightFestivalsCountry|null
     */
    public function get_country()
    {
        return $this->get_city()->get_country() ?? null;
    }

    /**
     * @return SuperEightFestivalsCity|null
     */
    public function get_city()
    {
        return SuperEightFestivalsCity::get_by_id($this->city_id);
    }


    // ======================================================================================================================== \\
}