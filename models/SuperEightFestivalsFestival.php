<?php

class SuperEightFestivalsFestival extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public int $city_id = 0;
    public int $year = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`city_id`      INT(10) UNSIGNED NOT NULL",
                "`year`         INT(4)           NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

//    protected function beforeDelete()
//    {
//        if ($this->year === 0) throw new Exception("The uncategorized (default) Festival can not be deleted!");
//        parent::beforeDelete();
//    }
//
//    protected function beforeSave($args)
//    {
//        if (array_key_exists("insert", $args)) {
//            $insert = $args['insert'];
//            if (!$insert) {
//                if ($this->year === 0) throw new Exception("The uncategorized (default) Festival can not be updated!");
//            }
//        }
//        parent::beforeSave($args);
//    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_children();
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_city()) $res = array_merge($res, ["city" => $this->get_city()->to_array()]);
        return $res;
    }

    public function delete_children()
    {
        foreach (SuperEightFestivalsFestivalFilm::get_by_param('festival_id', $this->id) as $record) $record->delete();
        foreach (SuperEightFestivalsFestivalFilmCatalog::get_by_param('festival_id', $this->id) as $record) $record->delete();
        foreach (SuperEightFestivalsFestivalMemorabilia::get_by_param('festival_id', $this->id) as $record) $record->delete();
        foreach (SuperEightFestivalsFestivalPhoto::get_by_param('festival_id', $this->id) as $record) $record->delete();
        foreach (SuperEightFestivalsFestivalPoster::get_by_param('festival_id', $this->id) as $record) $record->delete();
        foreach (SuperEightFestivalsFestivalPrintMedia::get_by_param('festival_id', $this->id) as $record) $record->delete();
    }

    public static function create($arr = [])
    {
        $festival = new SuperEightFestivalsFestival();
        $festival->year = $arr['year'];
        $city_id = $arr['city_id'];
        $festival->city_id = $city_id;

        try {
            $festival->save();
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
     * @return SuperEightFestivalsFestival[]
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

    public function get_posters()
    {
        return SuperEightFestivalsFestivalPoster::get_by_param('festival_id', $this->id);
    }

    public function get_photos()
    {
        return SuperEightFestivalsFestivalPhoto::get_by_param('festival_id', $this->id);
    }

    public function get_print_media()
    {
        return SuperEightFestivalsFestivalPrintMedia::get_by_param('festival_id', $this->id);
    }

    public function get_memorabilia()
    {
        return SuperEightFestivalsFestivalMemorabilia::get_by_param('festival_id', $this->id);
    }

    public function get_films()
    {
        return SuperEightFestivalsFestivalFilm::get_by_param('festival_id', $this->id);
    }

    public function get_film_catalogs()
    {
        return SuperEightFestivalsFestivalFilmCatalog::get_by_param('festival_id', $this->id);
    }

    public function get_title()
    {
        $year = $this->year != 0 ? $this->year : "uncategorized";
        return "{$this->get_city()->get_location()->name} {$year} festival";
    }

    // ======================================================================================================================== \\
}