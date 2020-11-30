<?php

class SuperEightFestivalsFestivalFilm extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public int $festival_id = 0;
    public int $filmmaker_film_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`festival_id`          INT(10) UNSIGNED NOT NULL",
                "`filmmaker_film_id`    INT(10) UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    public static function create($arr = [])
    {
    }

    public function update($arr, $save = true)
    {
        parent::update($arr, $save);
    }

    // ======================================================================================================================== \\

    /**
     * @return SuperEightFestivalsFestivalFilm[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    /**
     * @return SuperEightFestivalsFestival|null
     */
    public function get_festival()
    {
        return SuperEightFestivalsFestival::get_by_id($this->festival_id);
    }

    /**
     * @return SuperEightFestivalsFilmmakerFilm
     */
    function get_film()
    {
        return SuperEightFestivalsFilmmakerFilm::get_by_id($this->filmmaker_film_id);
    }

    // ======================================================================================================================== \\
}