<?php

class SuperEightFestivalsContributor extends Super8FestivalsRecord
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

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_person()) $res = array_merge($res, ["person" => $this->get_person()->to_array()]);
        if(!$this->get_person()->is_email_visible) {
            $res['person']['email'] = null;
        }
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