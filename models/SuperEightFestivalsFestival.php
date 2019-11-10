<?php

class SuperEightFestivalsFestival extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $country_id;
    public $city_id;
    public $name;
    public $year;

    /**
     * Validate the form data.
     */
    protected function _validate()
    {
        if (empty($this->name)) {
            $this->addError('name', 'The country must be given a name.');
        }
        if (!is_numeric($this->year) || strlen((string)$this->year) != 4) {
            $this->addError('year', 'The year must be a valid 4-digit year (e.g. 1974).');
        }
    }

    public function getRecordUrl($action = 'show')
    {
        if ($action == 'show') {
            return public_url($this->name);
        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'index',
            'action' => $action,
            'id' => $this->id
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival';
    }
}