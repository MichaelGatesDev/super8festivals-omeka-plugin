<?php

class SuperEightFestivalsCityBanner extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public $city_id = 0;
    use S8FPreviewable;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
                "`city_id`   INT(10) UNSIGNED NOT NULL",
            ),
            S8FPreviewable::get_db_columns()
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_City_Banner';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "city_banner";
    }

    public function get_country()
    {
        return $this->get_city()->get_country();
    }

    public function get_city()
    {
        return SuperEightFestivalsCity::get_by_id($this->city_id);
    }

    public function get_dir(): ?string
    {
        if ($this->get_city() == null) return null;
        return $this->get_city()->get_dir();
    }

    // ======================================================================================================================== \\
}