<?php

class SuperEightFestivalsCityBanner extends Super8FestivalsRecord
{
    // ======================================================================================================================== \\

    public int $city_id = 0;
    public int $file_id = 0;

    // ======================================================================================================================== \\

    public function get_db_columns()
    {
        return array(
            "`id`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            "`city_id`   INT(10) UNSIGNED NOT NULL",
            "`file_id`   INT(10) UNSIGNED NOT NULL",
        );
    }

    public function get_table_pk()
    {
        return "id";
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->get_file()->delete();
    }

    /**
     * @param $search_id
     * @return SuperEightFestivalsCityBanner|null
     */
    public static function get_by_id($search_id)
    {
        return parent::get_by_id($search_id);
    }

    /**
     * @return SuperEightFestivalsCityBanner[]
     */
    public static function get_all()
    {
        return parent::get_all();
    }

    public function upload()
    {
        $file_relationship = new SuperEightFestivalsResourceRelationship();
        $file_relationship->city_banner_id = $this->id;
        if ($file_relationship->save()) {
            $file = new SuperEightFestivalsFile();
            $file->resource_relationship_id = $file_relationship->id;
            $file->upload_from_post("file", $this->get_internal_prefix());
            $this->file_id = $file->id;
            $this->save();
        }
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "city_banner";
    }

    /**
     * @return SuperEightFestivalsCity|null
     */
    public function get_city()
    {
        return SuperEightFestivalsCity::get_by_id($this->city_id);
    }

    /**
     * @return SuperEightFestivalsCountry|null
     */
    public function get_country()
    {
        return $this->get_city()->get_country();
    }

    /**
     * @return SuperEightFestivalsFile|null
     */
    public function get_file()
    {
        return SuperEightFestivalsFile::get_by_id($this->file_id);
    }


    // ======================================================================================================================== \\
}