<?php

class SuperEightFestivalsFestivalFilmmaker extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFestivalPerson;

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
            S8FFestivalPerson::get_db_columns()
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
            logger_log(LogLevel::Info, "Adding festival filmmaker for {$this->get_festival()->get_title()} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updating festival filmmaker for {$this->get_festival()->get_title()} ({$this->id})");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Added festival filmmaker for {$this->get_festival()->get_title()} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updated festival filmmaker for {$this->get_festival()->get_title()} ({$this->id})");
        }

        $this->create_files();
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted festival filmmaker for festival {$this->id}");
    }

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->festival_id) || !is_numeric($this->festival_id)) {
            $this->addError('festival_id', 'You must select a valid festival!');
        }
    }


    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Filmmaker';
    }

    // ======================================================================================================================== \\

    public function get_festival()
    {
        return get_festival_by_id($this->festival_id);
    }

    public function get_city()
    {
        return $this->get_festival()->get_city();
    }

    public function get_country()
    {
        return $this->get_festival()->get_country();
    }

    public function get_dir(): ?string
    {
        if ($this->get_festival() == null) return null;
        return $this->get_festival()->get_filmmakers_dir() . "/" . $this->id;
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