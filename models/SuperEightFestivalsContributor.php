<?php

class SuperEightFestivalsContributor extends Super8FestivalsRecord
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

    public function to_array()
    {
        return array_merge(
            parent::to_array(),
            ["person" => $this->get_person()],
        );
    }

    /**
     * @param array $arr ["person" => ["first_name", ...]]
     * @return SuperEightFestivalsContributor|null
     * @throws Omeka_Record_Exception
     */
    public static function create($arr = [])
    {
        $contributor = new SuperEightFestivalsContributor();
        $person = SuperEightFestivalsPerson::create($arr['person']);
        $contributor->person_id = $person->id;
        try {
            $contributor->save(true);
            return $contributor;
        } catch (Exception $e) {
            $person->delete();
            return null;
        }
    }

    public function update($arr, $save = true)
    {
        if (!SuperEightFestivalsContributor::get_by_id($person_id = $arr['person_id'])) throw new Exception("No person exists with id {$person_id}");
        parent::update($arr, $save);
    }

    // ======================================================================================================================== \\

    /**
     * @return SuperEightFestivalsContributor[]
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

    // ======================================================================================================================== \\
}