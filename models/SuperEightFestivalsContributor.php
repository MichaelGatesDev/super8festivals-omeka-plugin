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

    protected function beforeDelete()
    {
        parent::beforeDelete();
        if ($person = $this->get_person()) $person->delete();
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_person()) $res = array_merge($res, ["person" => $this->get_person()->to_array()]);
        return $res;
    }

    public static function create($arr = [])
    {
        $staff = new SuperEightFestivalsContributor();
        $person = SuperEightFestivalsPerson::create($arr['person']);
        $staff->person_id = $person->id;
        try {
            $staff->save(true);
            return $staff;
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