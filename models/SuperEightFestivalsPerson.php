<?php


class SuperEightFestivalsPerson extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public string $first_name = "";
    public string $last_name = "";
    public string $email = "";
    public string $organization_name = "";

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`first_name`                   VARCHAR(255)",
                "`last_name`                    VARCHAR(255)",
                "`email`                        VARCHAR(255)",
                "`organization_name`            VARCHAR(255)",
            ),
            parent::get_db_columns()
        );
    }

    /**
     * @return SuperEightFestivalsPerson[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    public static function create($arr = [])
    {
        $person = new SuperEightFestivalsPerson();
        $person->update($arr);
        return $person;
    }

    // ======================================================================================================================== \\

    public function get_name($includeEmail = false)
    {
        $name = "";
        if ($this->first_name != "") {
            $name .= $this->first_name;
            if ($this->last_name != "")
                $name .= " " . $this->last_name;
        } else {
            if ($this->organization_name != "")
                $name .= $this->organization_name;
        }

        if ($includeEmail && $this->email != "") {
            if ($name == "") {
                $name = $this->email;
            } else {
                $name .= " (" . $this->email . ")";
            }
        }

        return $name;
    }

    // ======================================================================================================================== \\
}