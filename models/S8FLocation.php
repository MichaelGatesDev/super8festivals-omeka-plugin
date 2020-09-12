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
        if (empty($this->name)) {
            $this->addError('name', "Name can not be blank.");
        }
        if (!is_numeric($this->latitude)) {
            $this->addError(null, "Latitude may only be numeric.");
        }
        if (!is_numeric($this->longitude)) {
            $this->addError(null, "Longitude may only be numeric.");
        }
    }

    // ======================================================================================================================== \\
}