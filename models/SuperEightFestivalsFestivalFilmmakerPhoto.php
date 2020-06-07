<?php

class SuperEightFestivalsFestivalFilmmakerPhoto extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFestivalFilmmakerImage;

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
            S8FFestivalFilmmakerImage::get_db_columns()
        );
    }

    public function get_db_pk()
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
                logger_log(LogLevel::Info, "Adding photo for festival filmmaker {$this->get_filmmaker()->get_display_name()} ({$this->id})");
            } else {
                logger_log(LogLevel::Info, "Updating photo for festival filmmaker {$this->get_filmmaker()->get_display_name()} ({$this->id})");
            }
        }
    }

    protected function afterSave($args)
    {
        parent::beforeSave($args);
        if (array_key_exists('record', $args)) {
            $record = $args['record'];
        }
        if (array_key_exists('insert', $args)) {
            $insert = $args['insert'];
            if ($insert) {
                logger_log(LogLevel::Info, "Added photo for festival filmmaker {$this->get_filmmaker()->get_display_name()} ({$this->id})");
            } else {
                logger_log(LogLevel::Info, "Updated photo for festival filmmaker {$this->get_filmmaker()->get_display_name()} ({$this->id})");
            }
        }

        $this->create_files();
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted photo for festival filmmaker {$this->id}");
    }

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->filmmaker_id) || !is_numeric($this->filmmaker_id)) {
            $this->addError('festival_id', 'You must select a valid festival!');
        }
    }


    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Filmmaker_Photo';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "festival_filmmaker_photo";
    }

    public function get_dir(): ?string
    {
        if ($this->get_filmmaker() == null) return null;
        return $this->get_filmmaker()->get_dir() . "/photos/";
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