<?php

class SuperEightFestivalsFederationNewsletter extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public int $file_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array(
            "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            "`file_id`   INT(10) UNSIGNED NOT NULL",
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    /**
     * @param $search_id
     * @return SuperEightFestivalsFederationBylaw|null
     */
    public static function get_by_id($search_id)
    {
        return parent::get_by_id($search_id);
    }

    /**
     * @return SuperEightFestivalsFederationBylaw[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    protected function _createRelationship() {
        $file_relationship = new SuperEightFestivalsResourceRelationship();
        $file_relationship->federation_newsletter_id = $this->id;
        return $file_relationship;
    }

    // ======================================================================================================================== \\

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->get_file()->delete();
    }

    // ======================================================================================================================== \\

    /**
     * @return SuperEightFestivalsFile|null
     */
    public function get_file()
    {
        return SuperEightFestivalsFile::get_by_id($this->file_id);
    }

    // ======================================================================================================================== \\
}