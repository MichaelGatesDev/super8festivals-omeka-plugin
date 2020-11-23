<?php

class SuperEightFestivalsFilmmaker extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public int $person_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`person_id`   INT(10) UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    // ======================================================================================================================== \\

    /**
     * @return SuperEightFestivalsFilmmaker[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    /**
     * @return SuperEightFestivalsFestivalFilm[]
     */
    public function get_films()
    {
        return SuperEightFestivalsFestivalFilm::get_by_param('filmmaker_id', $this->id);
    }

    /**
     * @return SuperEightFestivalsFilmmakerPhoto[]
     */
    public function get_photos()
    {
        return SuperEightFestivalsFilmmakerPhoto::get_by_param('filmmaker_id', $this->id);
    }

    // ======================================================================================================================== \\
}