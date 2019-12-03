<?php

class SuperEightFestivalsCity extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $country_id;
    public $name;
    public $latitude;
    public $longitude;

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
        return "/countries/" . get_country_by_id($this->country_id)->name . "#" . $this->name;
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_City';
    }
}