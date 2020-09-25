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
        $this->create_files();
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Filmmaker_Photo';
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