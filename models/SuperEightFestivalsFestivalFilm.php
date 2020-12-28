<?php

class SuperEightFestivalsFestivalFilm extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public ?int $festival_id = null;
    public ?int $filmmaker_film_id = null;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`festival_id`          INT UNSIGNED NOT NULL",
                "`filmmaker_film_id`    INT UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    public function get_db_foreign_keys()
    {
        return array_merge(
            array(
                "FOREIGN KEY (`festival_id`) REFERENCES {db_prefix}{table_prefix}festivals(`id`) ON DELETE CASCADE",
                "FOREIGN KEY (`filmmaker_film_id`) REFERENCES {db_prefix}{table_prefix}filmmaker_films(`id`) ON DELETE CASCADE",
            ),
            parent::get_db_foreign_keys()
        );
    }

    public static function create($arr = [])
    {
        $film = new SuperEightFestivalsFestivalFilm();
        $film->update($arr);
        return $film;
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_festival()) $res = array_merge($res, ["festival" => $this->get_festival()->to_array()]);
        if ($this->get_filmmaker_film()) $res = array_merge($res, ["filmmaker_film" => $this->get_filmmaker_film()->to_array()]);
        return $res;
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
    function get_filmmaker_film()
    {
        return SuperEightFestivalsFilmmakerFilm::get_by_id($this->filmmaker_film_id);
    }

    // ======================================================================================================================== \\
}