<?php

class SuperEightFestivalsCity extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public $country_id = 0;
    public $description = "";
    use S8FLocation;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`           INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
                "`country_id`   INT(10) UNSIGNED NOT NULL",
                "`description`  TEXT(65535)",
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
        if (SuperEightFestivalsCity::get_by_params(array('country_id' => $this->country_id, 'name' => $this->name))) {
            throw new Error("Country already contains a city with that name!");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        if (array_key_exists("insert", $args)) {
            $insert = $args['insert'];
            if ($insert) {
                $festival = new SuperEightFestivalsFestival();
                $festival->city_id = $this->id;
                $festival->save();
            }
        }

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
        return 'SuperEightFestivals_City';
    }

    function delete_children()
    {
        // banner
        $banner = SuperEightFestivalsCityBanner::get_by_params(array('city_id' => $this->id));
        if ($banner != null) $banner->delete();

        // festivals
        $festivals = SuperEightFestivalsFestival::get_by_params(array('city_id' => $this->id));
        foreach ($festivals as $festival) {
            $festival->delete();
        }

        // filmmakers
        $filmmakers = SuperEightFestivalsFilmmaker::get_by_params(array('city_id' => $this->id));
        foreach ($filmmakers as $filmmaker) {
            $filmmaker->delete();
        }
    }

    // ======================================================================================================================== \\

    public static function get_by_name($name): ?SuperEightFestivalsCity
    {
        $results = SuperEightFestivalsCity::get_by_param('name', $name, 1);
        return count($results) > 0 ? $results[0] : null;
    }

    function get_festivals()
    {
        return SuperEightFestivalsFestival::get_by_param('city_id', $this->id);
    }

    public static function get_all_by_name($name): array
    {
        return SuperEightFestivalsCity::get_by_param('name', $name);
    }

    public function get_country()
    {
        return SuperEightFestivalsCountry::get_by_id($this->country_id);
    }

    public function get_banner()
    {
        return SuperEightFestivalsCityBanner::get_by_param('city_id', $this->id, 1)[0];
    }

    public function get_filmmakers()
    {
        return SuperEightFestivalsFilmmaker::get_by_param('city_id', $this->id);
    }

    public function get_dir(): ?string
    {
        if ($this->get_country() == null) return null;
        return $this->get_country()->get_dir() . "/" . $this->name;
    }

    function get_festivals_dir(): ?string
    {
        if ($this->get_dir() == null) return null;
        return $this->get_dir() . "/festivals";
    }

    function get_filmmakers_dir(): ?string
    {
        if ($this->get_dir() == null) return null;
        return $this->get_dir() . "/filmmakers";
    }


    private function create_files()
    {
        if ($this->get_dir() == null) {
            logger_log(LogLevel::Error, "Root directory is null for city: {$this->name} ({$this->id})");
            return;
        }

        if ($this->get_dir() != null) {
            if (!file_exists($this->get_dir())) {
                mkdir($this->get_dir());
            }
        }
        if ($this->get_festivals_dir() != null) {
            if (!file_exists($this->get_festivals_dir())) {
                mkdir($this->get_festivals_dir());
            }
        }
    }

    public function delete_files()
    {
        if ($this->get_dir() != null) {
            if (file_exists($this->get_dir())) {
                rrmdir($this->get_dir());
            }
        }
    }

    // ======================================================================================================================== \\
}