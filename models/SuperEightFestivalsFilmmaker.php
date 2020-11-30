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

    protected function beforeDelete()
    {
        parent::beforeDelete();
        if ($person = $this->get_person()) $person->delete();
        foreach ($this->get_films() as $film) $film->delete();
        foreach ($this->get_photos() as $photo) $photo->delete();
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_person()) $res = array_merge($res, ["person" => $this->get_person()->to_array()]);
        return $res;
    }

    public static function create($arr = [])
    {
        $filmmaker = new SuperEightFestivalsFilmmaker();
        $person = SuperEightFestivalsPerson::create($arr['person']);
        $filmmaker->person_id = $person->id;
        try {
            $filmmaker->save(true);
            return $filmmaker;
        } catch (Exception $e) {
            $person->delete();
            throw $e;
        }
    }

    public function update($arr, $save = true)
    {
        if (!SuperEightFestivalsPerson::get_by_id($person_id = $arr['person_id'])) throw new Exception("No person exists with id {$person_id}");

        if (isset($arr['person'])) {
            $this->get_person()->update($arr['person']);
        }

        parent::update($arr, $save);
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
     * @return SuperEightFestivalsPerson|null
     */
    public function get_person()
    {
        return SuperEightFestivalsPerson::get_by_id($this->person_id);
    }

    /**
     * @return SuperEightFestivalsFilmmakerFilm[]
     */
    public function get_films()
    {
        return SuperEightFestivalsFilmmakerFilm::get_by_param('filmmaker_id', $this->id);
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