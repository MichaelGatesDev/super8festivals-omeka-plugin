<?php

class SuperEightFestivalsStaff extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public ?int $person_id = null;
    public ?int $file_id = null;
    public string $role = "";

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`person_id`    INT UNSIGNED NOT NULL",
                "`file_id`      INT UNSIGNED NOT NULL",
                "`role`         VARCHAR(255)",
            ),
            parent::get_db_columns()
        );
    }

    public function get_db_foreign_keys()
    {
        return array_merge(
            array(
                "FOREIGN KEY (`person_id`) REFERENCES {db_prefix}{table_prefix}people(`id`) ON DELETE CASCADE",
                "FOREIGN KEY (`file_id`) REFERENCES {db_prefix}{table_prefix}files(`id`) ON DELETE CASCADE",
            ),
            parent::get_db_foreign_keys()
        );
    }

    protected function beforeDelete()
    {
        parent::beforeDelete();
        if ($person = $this->get_person()) $person->beforeDelete();
        if ($file = $this->get_file()) $file->beforeDelete();
    }

    public function to_array()
    {
        $res = parent::to_array();
        if ($this->get_person()) $res = array_merge($res, ["person" => $this->get_person()->to_array()]);
        if ($this->get_file()) $res = array_merge($res, ["file" => $this->get_file()->to_array()]);
        return $res;
    }

    public static function create($arr = [])
    {
        $staff = new SuperEightFestivalsStaff();
        $staff->role = $arr['role'];
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
     * @return SuperEightFestivalsStaff[]
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
     * @return SuperEightFestivalsFile|null
     */
    public function get_file()
    {
        return SuperEightFestivalsFile::get_by_id($this->file_id);
    }

    // ======================================================================================================================== \\
}