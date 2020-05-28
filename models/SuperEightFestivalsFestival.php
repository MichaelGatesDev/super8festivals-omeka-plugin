<?php

class SuperEightFestivalsFestival extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FMetadata;

    public $city_id = 0;
    public $year = 0;

    // ======================================================================================================================== \\

    public function get_clazz()
    {
        return self::class;
    }

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

    public function get_db_pk()
    {
        return "id";
    }

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Adding festival: {$this->get_title()} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updating festival: {$this->get_title()} ({$this->id})");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Added festival: {$this->get_title()} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updated festival: {$this->get_title()} ({$this->id})");
        }

        $this->create_files();
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        delete_festival_records($this->id);
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted festival: {$this->get_title()} ({$this->id})");
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival';
    }

    // ======================================================================================================================== \\

    public function get_city()
    {
        return get_city_by_id($this->city_id);
    }

    public function get_country()
    {
        return $this->get_city()->get_country() ?? null;
    }

    public function get_title()
    {
        return $this->year != 0 ? $this->year . " " . $this->get_city()->name : $this->get_city()->name . " default festival";
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