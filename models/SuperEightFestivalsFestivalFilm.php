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
        $film = new SuperEightFestivalsFestivalFilm();
        $film->festival_id = $arr['festival_id'];
        $film->filmmaker_film_id = $arr['filmmaker_film_id'];
        try {
            $film->save();
            return $film;
        } catch (Exception $e) {
            return null;
        }
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_festival()) $res = array_merge($res, ["festival" => $this->get_festival()->to_array()]);
        if ($this->get_filmmaker_film()) $res = array_merge($res, ["filmmaker_film" => $this->get_filmmaker_film()->to_array()]);
        return $res;
    }

    public function update($arr, $save = true)
    {
        $cname = get_called_class();
        if (isset($arr['festival'])) {
            $festival = $this->get_festival();
            if (!$festival) throw new Exception("{$cname} is not associated with a SuperEightFestivalsFestival");
            $festival->update($arr['festival']);
        }
        if (isset($arr['filmmaker_film'])) {
            $filmmaker_film = $this->get_filmmaker_film();
            if (!$filmmaker_film) throw new Exception("{$cname} is not associated with a SuperEightFestivalsFilmmakerFilm");
            $filmmaker_film->update($arr['filmmaker_film']);
        }

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
    function get_filmmaker_film()
    {
        return SuperEightFestivalsFilmmakerFilm::get_by_id($this->filmmaker_film_id);
    }

    // ======================================================================================================================== \\
}