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

    public function get_display_name()
    {
        if ($this->first_name != "") return $this->first_name . " " . $this->last_name;
        if ($this->organization_name != "") return $this->organization_name;
        return $this->email;
    }

    // ======================================================================================================================== \\
}