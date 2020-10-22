<?php

class SuperEightFestivalsCountry extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FLocation;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            ),
            S8FLocation::get_db_columns()
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    protected function _validate()
    {
        parent::_validate();
        $this->__validate();
        if (($found = SuperEightFestivalsCountry::get_by_param('name', $this->name)) && count($found) > 0 && $found[0]->id !== $this->id ) {
            throw new Error("A country with that name already exists!");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
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

    /**
     * @return SuperEightFestivalsCountry[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    // ======================================================================================================================== \\

    public static function get_by_name($name): ?SuperEightFestivalsCountry
    {
        $results = SuperEightFestivalsCountry::get_by_param('name', $name, 1);
        return count($results) > 0 ? $results[0] : null;
    }

    function get_cities()
    {
        return SuperEightFestivalsCity::get_by_param('country_id', $this->id);
    }

    // ======================================================================================================================== \\
}