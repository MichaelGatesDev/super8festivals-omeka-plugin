<?php

class SuperEightFestivalsCountry extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $name;
    public $coords_north;
    public $coords_east;
    public $coords_south;
    public $coords_west;


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
        if (empty($this->name)) {
            $this->addError('name', 'The country must be given a name.');
        }
        if (!is_float(floatval($this->coords_north))) {
            $this->addError('coords_north', 'The coordinate must be a floating point value');
        }
        if (!is_float(floatval($this->coords_east))) {
            $this->addError('coords_east', 'The coordinate must be a floating point value');
        }
        if (!is_float(floatval($this->coords_south))) {
            $this->addError('coords_south', 'The coordinate must be a floating point value');
        }
        if (!is_float(floatval($this->coords_west))) {
            $this->addError('coords_west', 'The coordinate must be a floating point value');
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
        return 'SuperEightFestivals_Country';
    }
}