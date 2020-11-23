<?php


class SuperEightFestivalsLocation extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public float $latitude = 0;
    public float $longitude = 0;
    public string $name = "";
    public string $description = "";

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`latitude`                     FLOAT(8, 4)",
                "`longitude`                    FLOAT(8, 4)",
                "`name`                         VARCHAR(255)",
                "`description`                  TEXT(65535)",
            ),
            parent::get_db_columns()
        );
    }

    protected function __validate()
    {
        $this->name = alpha_only($this->name);
        if (empty(trim($this->name))) {
            $this->addError(null, "Name can not be blank.");
            return false;
        }
        $this->name = strtolower($this->name);

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

    /**
     * @return SuperEightFestivalsLocation[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    // ======================================================================================================================== \\
}