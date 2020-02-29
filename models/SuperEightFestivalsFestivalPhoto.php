<?php

class SuperEightFestivalsFestivalPhoto extends SuperEightFestivalsImage
{
    public int $festival_id = -1;

    public function __construct()
    {
        parent::__construct();
    }

    protected function _validate()
    {
    }

    public function getRecordUrl($action = 'show')
    {
        if ('show' == $action) {
            return public_url($this->id);
        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'photos',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Photo';
    }
}