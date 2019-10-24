<?php

class SuperEightFestivalsCity extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $country_id;
    public $name;
    public $latitude;
    public $longitude;


    protected function _initializeMixins()
    {
        $this->_mixins[] = new Mixin_Search($this);
        $this->_mixins[] = new Mixin_Timestamp($this, 'inserted', 'updated');
    }

    /**
     * Validate the form data.
     */
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

    /**
     * Prepare special variables before saving the form.
     */
    protected function beforeSave($args)
    {
        $this->name = trim($this->name);
    }

    protected function afterSave($args)
    {
        $this->setSearchTextTitle($this->name);
        $this->addSearchText($this->name);
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
        return 'SuperEightFestivals_City';
    }
}