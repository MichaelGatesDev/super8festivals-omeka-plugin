<?php

trait S8FLocation
{
    // ======================================================================================================================== \\

    public $name = "";
    public $latitude = 0;
    public $longitude = 0;

    public static function get_db_columns()
    {
        return array(
            "`name`         VARCHAR(255)     NOT NULL",
            "`latitude`     FLOAT(8, 4)",
            "`longitude`    FLOAT(8, 4)",
        );
    }

    protected function __validate()
    {
        if (empty(trim($this->name))) {
            $this->addError('name', "Name can not be blank.");
            return false;
        }
        $this->name = alpha_only($this->name);

        if (!is_numeric($this->latitude)) {
            $this->addError(null, "Latitude may only be numeric.");
            return false;
        }
        $this->latitude = intval($this->latitude * 1e4) / 1e4; // truncate float to the 4th decimal point. Taken from https://stackoverflow.com/a/40418116/1925638

        if (!is_numeric($this->longitude)) {
            $this->addError(null, "Longitude may only be numeric.");
            return false;
        }
        $this->longitude = intval($this->longitude * 1e4) / 1e4;

        return true;
    }

    // ======================================================================================================================== \\
}