<?php

class SuperEightFestivalsCountry extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public int $location_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`location_id`      INT(10) UNSIGNED NOT NULL",
            ),
            parent::get_db_columns()
        );
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_children();
    }

    function delete_children()
    {
        foreach ($this->get_cities() as $city) {
            $city->delete();
        }
    }

    public function to_dict()
    {
        return $this->get_location()->to_dict();
    }

    // ======================================================================================================================== \\

    /**
     * @return SuperEightFestivalsCountry[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    /**
     * @return SuperEightFestivalsLocation|null
     */
    public static function get_by_name($name)
    {
        $all = SuperEightFestivalsCountry::get_all();
        foreach ($all as $single) {
            $single->get_location();
        }
        $results = SuperEightFestivalsCountry::get_by_param('name', $name, 1);
        return count($results) > 0 ? $results[0] : null;
    }

    /**
     * @return SuperEightFestivalsCity[]|null
     */
    function get_cities()
    {
        return SuperEightFestivalsCity::get_by_param('country_id', $this->id);
    }

    /**
     * @return SuperEightFestivalsLocation|null
     */
    public function get_location()
    {
        return SuperEightFestivalsLocation::get_by_id($this->location_id);
    }

    // ======================================================================================================================== \\
}