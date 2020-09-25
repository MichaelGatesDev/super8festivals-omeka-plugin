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
        if (SuperEightFestivalsCountry::get_by_param('name', $this->name)) {
            throw new Error("A country with that name already exists!");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $this->create_files();
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_children();
        $this->delete_files();
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Country';
    }

    function delete_children()
    {
        foreach ($this->get_cities() as $city) {
            $city->delete();
        }
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

    function get_dir()
    {
        return get_countries_dir() . "/" . $this->name;
    }

    private function create_files()
    {
        if (!file_exists($this->get_dir())) {
            mkdir($this->get_dir());
        }
    }

    public function delete_files()
    {
        if (file_exists($this->get_dir())) {
            rrmdir($this->get_dir());
        }
    }

    // ======================================================================================================================== \\
}