<?php

trait S8FFestivalVideo
{
    // ======================================================================================================================== \\

    public $festival_id = 0;
    use S8FVideo;
    use S8FContributable;

    public static function get_db_columns()
    {
        return array_merge(
            array(
                "`festival_id`  INT(10) UNSIGNED NOT NULL",
            ),
            S8FVideo::get_db_columns(),
            S8FContributable::get_db_columns()
        );
    }

    // ======================================================================================================================== \\

    public function get_festival()
    {
        return get_festival_by_id($this->festival_id);
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