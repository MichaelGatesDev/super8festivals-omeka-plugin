<?php

class SuperEightFestivalsFestivalMemorabilia extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFestivalDocument;

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
            S8FFestivalDocument::get_db_columns()
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
            logger_log(LogLevel::Info, "Adding festival memorabilia for {$this->get_festival()->get_title()} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updating festival memorabilia for {$this->get_festival()->get_title()} ({$this->id})");
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $record = $args['record'];
        $insert = $args['insert'];

        if ($insert) {
            logger_log(LogLevel::Info, "Added festival memorabilia for {$this->get_festival()->get_title()} ({$this->id})");
        } else {
            logger_log(LogLevel::Info, "Updated festival memorabilia for {$this->get_festival()->get_title()} ({$this->id})");
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
        logger_log(LogLevel::Info, "Deleted festival memorabilia for festival {$this->id}");
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
        return 'SuperEightFestivals_Festival_Memorabilia';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "festival_memorabilia";
    }

    public function get_dir(): ?string
    {
        if ($this->get_festival() == null) return null;
        return $this->get_festival()->get_memorabilia_dir();
    }

    // ======================================================================================================================== \\
}