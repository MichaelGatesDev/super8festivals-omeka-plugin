<?php

class SuperEightFestivalsFestivalFilmmaker extends SuperEightFestivalsPerson
{
    public $festival_id;

    protected function _validate()
    {
    }

    public function getRecordUrl($action = 'show')
    {
//        if ('show' == $action) {
//            return public_url($this->name);
//        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'filmmakers',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Filmmaker';
    }
}