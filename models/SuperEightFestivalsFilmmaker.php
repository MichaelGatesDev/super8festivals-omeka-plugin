<?php

class SuperEightFestivalsFilmmaker extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public ?int $person_id = null;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`person_id`   INT UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    public function get_db_foreign_keys()
    {
        return array_merge(
            array(
                "FOREIGN KEY (`person_id`) REFERENCES {db_prefix}{table_prefix}people(`id`) ON DELETE CASCADE",
            ),
            parent::get_db_foreign_keys()
        );
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        if ($person = $this->get_person()) $person->delete();
        foreach ($this->get_films() as $film) $film->beforeDelete();
        foreach ($this->get_photos() as $photo) $photo->beforeDelete();
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
        $cname = get_called_class();
        if (isset($arr['person'])) {
            $loc = $this->get_person();
            if (!$loc) throw new Exception("{$cname} is not associated with a SuperEightFestivalsPerson");
            $loc->update($arr['person']);
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