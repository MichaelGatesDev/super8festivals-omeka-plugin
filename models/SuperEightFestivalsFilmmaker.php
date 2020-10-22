<?php

class SuperEightFestivalsFilmmaker extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    use S8FPerson;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array_merge(
            array(
                "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            ),
            S8FPerson::get_db_columns()
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    protected function _validate()
    {
        parent::_validate();
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_children();
    }

    public function delete_children()
    {
        foreach (SuperEightFestivalsFilmmakerPhoto::get_by_param('filmmaker_id', $this->id) as $record) $record->delete();
    }

    /**
     * @return SuperEightFestivalsFilmmaker[]
     */
    public static function get_all()
    {
        return parent::get_all();
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

    // ======================================================================================================================== \\
}