<?php

trait S8FPerson
{
    // ======================================================================================================================== \\

    use S8FRecord;

    public $first_name = "";
    public $last_name = "";
    public $organization_name = "";
    public $email = "";

    public static function get_db_columns()
    {
        return array(
            "`first_name`           VARCHAR(255)",
            "`last_name`            VARCHAR(255)",
            "`organization_name`    VARCHAR(255)",
            "`email`                VARCHAR(255) NOT NULL",
        );
    }

    // ======================================================================================================================== \\

    public function get_full_name()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function get_display_name()
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

        if ($this->email != "")
            if ($name == "") $name = $this->email;
            else $name .= " (" . $this->email . ")";

        return $name;
    }

    // ======================================================================================================================== \\
}