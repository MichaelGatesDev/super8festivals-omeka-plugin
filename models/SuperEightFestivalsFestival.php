<?php

class SuperEightFestivalsFestival extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public int $city_id = -1;
    public int $year = -1;
    public string $title = "";
    public string $description = "";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_city()
    {
        return get_city_by_id($this->city_id);
    }

    public function get_country()
    {
        return $this->get_city()->getCountry();
    }

    protected function _validate()
    {
        if (empty($this->city_id) || !is_numeric($this->city_id)) {
            $this->addError('city_id', 'The city in which the festival was held must be specified.');
        }
        if (empty($this->year) || !is_numeric($this->year)) {
            $this->addError('year', 'The year in which the festival was held must be specified.');
        }
    }

    public function getRecordUrl($action = 'show')
    {
//        if ('show' == $action) {
//            return public_url($this->name);
//        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'festivals',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival';
    }

    public function getDisplayName()
    {
        return "$this->title ($this->year)";
    }
}