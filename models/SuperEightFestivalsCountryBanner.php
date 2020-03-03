<?php

class SuperEightFestivalsCountryBanner extends SuperEightFestivalsImage
{
    public int $country_id = -1;

    public function __construct()
    {
        parent::__construct();
        $this->contributor_id = 0;
    }

    public function get_country()
    {
        return $this->getTable('SuperEightFestivalsCountry')->find($this->country_id);
    }

    public function get_path()
    {
        return get_country_dir($this->get_country()->name) . "/" . $this->file_name;
    }

    public function get_thumbnail_path()
    {
        return get_country_dir($this->get_country()->name) . "/" . $this->thumbnail_file_name;
    }

    public function has_thumbnail()
    {
        return file_exists($this->get_thumbnail_path()) && !is_dir($this->get_thumbnail_path());
    }

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->country_id) || !is_numeric($this->country_id)) {
            $this->addError('country_id', 'The country that the city exists in must be specified.');
        }
    }


    protected function beforeSave($args)
    {
        parent::afterSave($args);
        $this->create_thumbnail();
    }

    function create_thumbnail()
    {
        if (!$this->has_thumbnail()) {
            $name = str_replace("banner_", "banner_thumb_", $this->file_name);
            $result = create_thumbnail($this->get_path(), get_country_dir($this->get_country()->name) . "/" . $name, 300);
            if ($result) {
                $this->thumbnail_file_name = $name;
                $this->save();
            } else {
                error_log("Failed to create thumbnail");
            }
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        delete_file($this->get_thumbnail_path());
        delete_file($this->get_path());
    }

    public function getRecordUrl($action = 'show')
    {
        //TODO implement getRecordUrl
//        if ('show' == $action) {
//            return public_url($this->id);
//        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'banners',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Country_Banner';
    }
}