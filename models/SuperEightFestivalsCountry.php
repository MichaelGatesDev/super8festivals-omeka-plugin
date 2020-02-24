<?php

class SuperEightFestivalsCountry extends SuperEightFestivalsLocation
{
    protected function _validate()
    {
        parent::_validate();
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

    public function getResourceId()
    {
        return 'SuperEightFestivals_Country';
    }
}