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

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->country_id) || !is_numeric($this->country_id)) {
            $this->addError('country_id', 'The country that the city exists in must be specified.');
        }
    }


    protected function afterDelete()
    {
        parent::afterDelete();
        delete_file(get_country_dir($this->get_country()->name) . "/" . $this->thumbnail_path_file);
        delete_file(get_country_dir($this->get_country()->name) . "/" . $this->path_file);
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