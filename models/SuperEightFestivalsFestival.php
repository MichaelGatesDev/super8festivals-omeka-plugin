<?php

class SuperEightFestivalsFestival extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FMetadata;

    public $city_id = 0;
    public $year = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
                "`city_id`      INT(10) UNSIGNED NOT NULL",
                "`year`         INT(4)           NOT NULL",
            ),
            S8FMetadata::get_db_columns()
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    protected function _validate()
    {
        if (!is_numeric($this->year) || ($this->year != 0 && strlen($this->year) != 4)) {
            $this->addError("year", "The year may only be a 4-digit numeric year (e.g. 1974)");
            return false;
        }
        return true;
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
        return 'SuperEightFestivals_Festival';
    }

    public function delete_children()
    {
        foreach (SuperEightFestivalsFestivalFilm::get_by_param('festival_id', $this->id) as $record) $record->delete();
        foreach (SuperEightFestivalsFestivalFilmCatalog::get_by_param('festival_id', $this->id) as $record) $record->delete();
        foreach (SuperEightFestivalsFestivalMemorabilia::get_by_param('festival_id', $this->id) as $record) $record->delete();
        foreach (SuperEightFestivalsFestivalPhoto::get_by_param('festival_id', $this->id) as $record) $record->delete();
        foreach (SuperEightFestivalsFestivalPoster::get_by_param('festival_id', $this->id) as $record) $record->delete();
        foreach (SuperEightFestivalsFestivalPrintMedia::get_by_param('festival_id', $this->id) as $record) $record->delete();
    }

    // ======================================================================================================================== \\

    public function get_city()
    {
        return SuperEightFestivalsCity::get_by_id($this->city_id);
    }

    public function get_country()
    {
        return $this->get_city()->get_country() ?? null;
    }

    public function get_posters()
    {
        return SuperEightFestivalsFestivalPoster::get_by_param('festival_id', $this->id);
    }

    public function get_photos()
    {
        return SuperEightFestivalsFestivalPhoto::get_by_param('festival_id', $this->id);
    }

    public function get_print_media()
    {
        return SuperEightFestivalsFestivalPrintMedia::get_by_param('festival_id', $this->id);
    }

    public function get_memorabilia()
    {
        return SuperEightFestivalsFestivalMemorabilia::get_by_param('festival_id', $this->id);
    }

    public function get_films()
    {
        return SuperEightFestivalsFestivalFilm::get_by_param('festival_id', $this->id);
    }

    public function get_film_catalogs()
    {
        return SuperEightFestivalsFestivalFilmCatalog::get_by_param('festival_id', $this->id);
    }

    public function get_title()
    {
        return $this->year != 0 ? $this->year . " " . $this->get_city()->name : $this->get_city()->name . " uncategorized";
    }

    public function get_dir(): ?string
    {
        if ($this->get_city() == null) return null;
        return $this->get_city()->get_festivals_dir() . "/" . $this->id;
    }

    function get_film_catalogs_dir(): ?string
    {
        if ($this->get_dir() == null) return null;
        return $this->get_dir() . "/film-catalogs";
    }

    function get_filmmakers_dir(): ?string
    {
        if ($this->get_dir() == null) return null;
        return $this->get_dir() . "/filmmakers";
    }

    function get_films_dir(): ?string
    {
        if ($this->get_dir() == null) return null;
        return $this->get_dir() . "/films";
    }

    function get_memorabilia_dir(): ?string
    {
        if ($this->get_dir() == null) return null;
        return $this->get_dir() . "/memorabilia";
    }

    function get_photos_dir(): ?string
    {
        if ($this->get_dir() == null) return null;
        return $this->get_dir() . "/photos";
    }

    function get_posters_dir(): ?string
    {
        if ($this->get_dir() == null) return null;
        return $this->get_dir() . "/posters";
    }

    function get_print_media_dir(): ?string
    {
        if ($this->get_dir() == null) return null;
        return $this->get_dir() . "/print-media";
    }

    private function create_files()
    {
        if ($this->get_dir() == null) {
            logger_log(LogLevel::Error, "Root directory is null for festival: {$this->get_title()} ({$this->id})");
            return;
        }

        $this->safe_mkdir($this->get_dir(), "root");
        $this->safe_mkdir($this->get_film_catalogs_dir(), "film catalogs");
        $this->safe_mkdir($this->get_filmmakers_dir(), "filmmakers");
        $this->safe_mkdir($this->get_films_dir(), "films");
        $this->safe_mkdir($this->get_memorabilia_dir(), "memorabilia");
        $this->safe_mkdir($this->get_photos_dir(), "photos");
        $this->safe_mkdir($this->get_posters_dir(), "posters");
        $this->safe_mkdir($this->get_print_media_dir(), "print media");
    }

    function safe_mkdir($path, $name_for_log)
    {
        if (!file_exists($path)) {
            logger_log(LogLevel::Info, "Creating {$name_for_log} directory for festival {$this->id}...");
            if (@mkdir($path, 0777, true)) {
                logger_log(LogLevel::Info, "Created {$name_for_log} directory festival {$this->id}!");
            } else {
                $error = error_get_last();
                logger_log(LogLevel::Error, "Failed to create {$name_for_log} directory for festival {$this->id}! Reason: " . json_encode($error));
            }
        }
    }

    public function delete_files()
    {
        if (file_exists($this->get_dir())) {
            rrmdir($this->get_dir());
        }

        if (!file_exists($this->get_film_catalogs_dir())) {
            rrmdir($this->get_film_catalogs_dir());
        }
        if (!file_exists($this->get_filmmakers_dir())) {
            rrmdir($this->get_filmmakers_dir());
        }
        if (!file_exists($this->get_films_dir())) {
            rrmdir($this->get_films_dir());
        }
        if (!file_exists($this->get_memorabilia_dir())) {
            rrmdir($this->get_memorabilia_dir());
        }
        if (!file_exists($this->get_photos_dir())) {
            rrmdir($this->get_photos_dir());
        }
        if (!file_exists($this->get_posters_dir())) {
            rrmdir($this->get_posters_dir());
        }
        if (!file_exists($this->get_print_media_dir())) {
            rrmdir($this->get_print_media_dir());
        }
    }

    // ======================================================================================================================== \\
}