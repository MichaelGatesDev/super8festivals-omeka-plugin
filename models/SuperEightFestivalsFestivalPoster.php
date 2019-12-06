<?php

class SuperEightFestivalsFestivalPoster extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $city_id;
    public $title;
    public $description;
    public $path;
    public $thumbnail;

    public function getCity()
    {
        return get_city_by_id($this->city_id);
    }

    public function getCountry()
    {
        return $this->getCity()->getCountry();
    }

    protected function _validate()
    {
    }

    public function getRecordUrl($action = 'show')
    {
        if ('show' == $action) {
            return public_url($this->id);
        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'posters',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Poster';
    }
}