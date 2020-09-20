<?php

trait S8FFestivalImage
{
    // ======================================================================================================================== \\

    public $festival_id = 0;
    use S8FImage;
    use S8FContributable;

    public static function get_db_columns()
    {
        return array_merge(
            array(
                "`festival_id`  INT(10) UNSIGNED NOT NULL",
            ),
            S8FImage::get_db_columns(),
            S8FContributable::get_db_columns()
        );
    }

    // ======================================================================================================================== \\

    public function get_festival()
    {
        return SuperEightFestivalsFestival::get_by_id($this->festival_id);
    }

    public function get_city()
    {
        return $this->get_festival()->get_city();
    }

    public function get_country()
    {
        return $this->get_festival()->get_country();
    }

    // ======================================================================================================================== \\
}