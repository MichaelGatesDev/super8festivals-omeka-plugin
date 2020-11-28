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

    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            ["location" => $this->get_location()],
        );
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
     * @param $name string name of the country
     * @return SuperEightFestivalsCountry|null
     */
    public static function get_by_name(string $name)
    {
        $all = SuperEightFestivalsCountry::get_all();
        foreach ($all as $single) {
            $single->get_location();
            if ($single->get_location()->name === $name) return $single;
        }
        return null;
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