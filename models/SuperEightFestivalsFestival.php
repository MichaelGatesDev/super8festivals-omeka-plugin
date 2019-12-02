<?php

class SuperEightFestivalsFestival extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $city_id;
    public $year;

    protected function _validate()
    {
        if (!is_numeric($this->year) || strlen((string)$this->year) != 4) {
            $this->addError('year', 'The year must be a valid 4-digit year (e.g. 1974).');
        }
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival';
    }
}