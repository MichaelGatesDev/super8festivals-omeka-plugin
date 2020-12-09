<?php

class SuperEightFestivalsFilmmakerFilm extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public int $filmmaker_id = 0;
    public int $embed_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`filmmaker_id`     INT(10) UNSIGNED NOT NULL",
                "`embed_id`         INT(10) UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        if ($embed = $this->get_embed()) $embed->delete();
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_filmmaker()) $res = array_merge($res, ["filmmaker" => $this->get_filmmaker()->to_array()]);
        if ($this->get_embed()) $res = array_merge($res, ["embed" => $this->get_embed()->to_array()]);
        return $res;
    }

    public static function create($arr = [])
    {
        $film = new SuperEightFestivalsFilmmakerFilm();
        $embed = SuperEightFestivalsEmbed::create($arr['embed']);
        $film->embed_id = $embed->id;
        $film->update($arr, false);
        try {
            $film->save(true);
            return $film;
        } catch (Exception $e) {
            $embed->delete();
            throw $e;
        }
    }

    public function update($arr, $save = true)
    {
        $cname = get_called_class();
        if (isset($arr['embed'])) {
            $loc = $this->get_embed();
            if (!$loc) throw new Exception("{$cname} is not associated with a SuperEightFestivalsEmbed");
            $loc->update($arr['embed']);
        }

        parent::update($arr, $save);
    }

    // ======================================================================================================================== \\

    /**
     * @param $search_id
     * @return SuperEightFestivalsFilmmakerFilm|null
     */
    public static function get_by_id($search_id)
    {
        return parent::get_by_id($search_id);
    }

    /**
     * @return SuperEightFestivalsFilmmakerFilm[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    /**
     * @return SuperEightFestivalsFilmmaker|null
     */
    public function get_filmmaker()
    {
        return SuperEightFestivalsFilmmaker::get_by_id($this->filmmaker_id);
    }

    /**
     * @return SuperEightFestivalsEmbed|null
     */
    public function get_embed()
    {
        return SuperEightFestivalsEmbed::get_by_id($this->embed_id);
    }

    // ======================================================================================================================== \\
}