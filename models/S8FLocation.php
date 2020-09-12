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

    // ======================================================================================================================== \\
}