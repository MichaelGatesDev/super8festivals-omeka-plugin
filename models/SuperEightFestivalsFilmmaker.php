<?php

class SuperEightFestivalsFilmmaker extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FFilmmaker;

    // ======================================================================================================================== \\

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

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->city_id) || !is_numeric($this->city_id)) {
            $this->addError('city_id', 'You must select a valid city!');
        }
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