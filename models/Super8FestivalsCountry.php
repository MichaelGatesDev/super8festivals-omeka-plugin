<?php

class Super8FestivalsCountry extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $name = "";
    public $latitude = -1.00;
    public $longitude = -1.00;


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
        if (empty($this->name) || !is_string($this->name)) {
            $this->addError('super8festivals-country-name', 'The page must be given a name.');
        }

        if (!is_numeric($this->latitude)) {
            $this->addError('super8festivals-country-latitude', 'The latitude must be a floating point value');
        }
        if (!is_numeric($this->longitude)) {
            $this->addError('super8festivals-country-longitude', 'The longitude must be a floating point value');
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
        if ('show' == $action) {
            return public_url($this->slug);
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
        return 'Super8Festivals_Country';
    }
}