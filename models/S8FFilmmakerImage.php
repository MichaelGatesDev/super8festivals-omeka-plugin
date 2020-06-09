<?php

trait S8FFilmmakerImage
{
    // ======================================================================================================================== \\

    public $filmmaker_id = 0;
    use S8FImage;
    use S8FContributable;

    public static function get_db_columns()
    {
        return array_merge(
            array(
                "`filmmaker_id`  INT(10) UNSIGNED NOT NULL",
            ),
            S8FImage::get_db_columns(),
            S8FContributable::get_db_columns()
        );
    }

    // ======================================================================================================================== \\

    public function get_filmmaker()
    {
        return get_filmmaker_by_id($this->filmmaker_id);
    }

    public function get_city()
    {
        return $this->get_filmmaker()->get_city();
    }

    public function get_country()
    {
        return $this->get_city()->get_country();
    }

    // ======================================================================================================================== \\
}