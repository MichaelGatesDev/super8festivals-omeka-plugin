<?php

class SuperEightFestivalsCity extends SuperEightFestivalsLocation
{
    public int $country_id = -1;

    public function __construct()
    {
        parent::__construct();
    }

    public function getCountry()
    {
        return $this->getTable('SuperEightFestivalsCountry')->find($this->country_id);
    }

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->country_id) || !is_numeric($this->country_id)) {
            $this->addError('country_id', 'The country that the city exists in must be specified.');
        }
        if (!is_float(floatval($this->latitude))) {
            $this->addError('latitude', 'The latitude must be a floating point value.');
        }
        if (!is_float(floatval($this->longitude))) {
            $this->addError('longitude', 'The longitude must be a floating point value.');
        }
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        create_city_dir($this->getCountry()->name, $this->name);
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        delete_city_dir($this->getCountry()->name, $this->name);
    }


    public function getRecordUrl($action = 'show')
    {
        if ('show' == $action) {
            return public_url($this->getCountry()->name . "#" . $this->name);
        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'cities',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_City';
    }
}