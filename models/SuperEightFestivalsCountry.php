<?php

class SuperEightFestivalsCountry extends SuperEightFestivalsLocation
{
    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    public function getRecordUrl($action = 'show')
    {
        if ('show' == $action) {
            return public_url("countries/" . $this->name);
        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'countries',
            'action' => $action,
            'id' => $this->id,
        );
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        create_country_dir($this->name);
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        delete_country_dir($this->name);
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Country';
    }

    // ======================================================================================================================== \\
}