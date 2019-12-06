<?php

class SuperEightFestivalsCity extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $country_id;
    public $name;
    public $latitude;
    public $longitude;

    public function getCountry()
    {
        return $this->getTable('SuperEightFestivalsCountry')->find($this->country_id);
    }

    protected function _validate()
    {
        if (empty($this->country_id) || !is_numeric($this->country_id)) {
            $this->addError('country_id', 'The country that the city exists in must be specified.');
        }
        if (empty($this->name)) {
            $this->addError('name', 'The city must be given a name.');
        }
        if (!is_float(floatval($this->latitude))) {
            $this->addError('latitude', 'The latitude must be a floating point value.');
        }
        if (!is_float(floatval($this->longitude))) {
            $this->addError('longitude', 'The longitude must be a floating point value.');
        }
    }

    protected function beforeSave($args)
    {
        $this->name = trim($this->name);
    }

    protected function afterSave($args)
    {
    }


    public function getRecordUrl($action = 'show')
    {
        if ('show' == $action) {
            return public_url($this->name);
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