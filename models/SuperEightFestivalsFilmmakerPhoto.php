<?php

class SuperEightFestivalsFilmmakerPhoto extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFilmmakerImage;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            ),
            S8FFilmmakerImage::get_db_columns()
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->filmmaker_id) || !is_numeric($this->filmmaker_id)) {
            $this->addError('filmmaker_id', 'You must select a valid city!');
        }
    }

    protected function afterSave($args)
    {
        parent::beforeSave($args);
    }

    protected function afterDelete()
    {
        parent::afterDelete();
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "festival_filmmaker_photo";
    }

    // ======================================================================================================================== \\
}