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

    protected function _validate()
    {
        parent::_validate();
        if (!is_numeric($this->year) || ($this->year != 0 && strlen($this->year) != 4)) {
            throw new Error("The year may only be a 4-digit numeric year (e.g. 1974)");
        }
        if (($found = SuperEightFestivalsFestival::get_by_params(['city_id' => $this->city_id, 'year' => $this->year])) && count($found) > 0 && $found[0]->id !== $this->id) {
            throw new Error("A festival with that year already exists!");
        }
        return true;
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_children();
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
        return $this->year != 0 ? $this->year . " " . $this->get_city()->name : $this->get_city()->name . " uncategorized";
    }

    // ======================================================================================================================== \\
}