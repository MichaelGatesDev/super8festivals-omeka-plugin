<?php

trait S8FPerson
{
    // ======================================================================================================================== \\

    public $first_name = "";
    public $last_name = "";
    public $organization_name = "";
    public $email = "";

    // ======================================================================================================================== \\

    public function get_display_name()
    {
        if ($this->first_name != "") return $this->first_name . " " . $this->last_name;
        if ($this->organization_name != "") return $this->organization_name;
        return $this->email;
    }

    // ======================================================================================================================== \\
}