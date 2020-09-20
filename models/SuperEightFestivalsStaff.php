<?php

class SuperEightFestivalsStaff extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FPerson;
    use S8FPreviewable;

    public $role = "";

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
                "`role`      TEXT(65535)",
            ),
            S8FPerson::get_db_columns(),
            S8FPreviewable::get_db_columns()
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
                logger_log(LogLevel::Info, "Adding staff");
            } else {
                logger_log(LogLevel::Info, "Updating staff");
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
                logger_log(LogLevel::Info, "Added staff");
            } else {
                logger_log(LogLevel::Info, "Updated staff");
            }
        }

        $this->create_files();
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted staff");
    }

    protected function _validate()
    {
        parent::_validate();
    }


    public function getResourceId()
    {
        return 'SuperEightFestivals_Staff';
    }

    // ======================================================================================================================== \\

    public function get_dir(): ?string
    {
        return get_staff_dir();
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