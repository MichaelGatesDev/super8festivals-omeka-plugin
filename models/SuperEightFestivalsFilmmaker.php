<?php

class SuperEightFestivalsFilmmaker extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFilmmaker;

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
            ),
            S8FFilmmaker::get_db_columns()
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    protected function beforeSave($args)
    {
        parent::beforeSave($args);

        if (array_key_exists('record', $args)) {
            $record = $args['record'];
        }
        if (array_key_exists('insert', $args)) {
            $insert = $args['insert'];
            if ($insert) {
                logger_log(LogLevel::Info, "Adding filmmaker for {$this->get_city()->name} ({$this->id})");
            } else {
                logger_log(LogLevel::Info, "Updating filmmaker for {$this->get_city()->name} ({$this->id})");
            }
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);

        if (array_key_exists('record', $args)) {
            $record = $args['record'];
        }
        if (array_key_exists('insert', $args)) {
            $insert = $args['insert'];
            if ($insert) {
                logger_log(LogLevel::Info, "Added filmmaker for {$this->get_city()->name} ({$this->id})");
            } else {
                logger_log(LogLevel::Info, "Updated filmmaker for {$this->get_city()->name} ({$this->id})");
            }
        }

        $this->create_files();
    }

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->city_id) || !is_numeric($this->city_id)) {
            $this->addError('city_id', 'You must select a valid city!');
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_children();
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted filmmaker for city {$this->id}");
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Filmmaker';
    }

    function delete_children()
    {
    }

    // ======================================================================================================================== \\

    public function get_films()
    {
        return SuperEightFestivalsFestivalFilm::get_by_param('filmmaker_id', $this->id);
    }

    public function get_photos()
    {
        return SuperEightFestivalsFilmmakerPhoto::get_by_param('filmmaker_id', $this->id);
    }

    public function get_dir(): ?string
    {
        if ($this->get_city() == null) return null;
        return $this->get_city()->get_filmmakers_dir() . "/" . $this->id;
    }

    private function create_files()
    {
        if (!file_exists($this->get_dir())) {
            mkdir($this->get_dir(), 0777, true);
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