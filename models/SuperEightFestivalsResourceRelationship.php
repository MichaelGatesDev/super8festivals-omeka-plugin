<?php


class SuperEightFestivalsResourceRelationship extends Super8FestivalsRecord
{
    public int $city_banner_id = 0;

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`                   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
                "`city_banner_id`       INT(10) UNSIGNED NOT NULL UNIQUE",
            ),
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    public static function get_by_id($search_id): ?SuperEightFestivalsResourceRelationship
    {
        return parent::get_by_id($search_id);
    }

    public function get()
    {
        if ($this->city_banner_id) {
            return SuperEightFestivalsCityBanner::get_by_id($this->city_banner_id);
        }
        return null;
    }
}