<?php

class SuperEightFestivalsCountryBanner extends SuperEightFestivalsImage
{
    public $country_id;

    public function getRecordUrl($action = 'show')
    {
        if ('show' == $action) {
            return public_url($this->title);
        }
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