<?php

class SuperEightFestivalsFestivalFilm extends SuperEightFestivalsVideo
{
    public int $festival_id = -1;
    public int $filmmaker_id = -1;

    public function __construct()
    {
        parent::__construct();
    }

    protected function _validate()
    {
    }

    function get_filmmaker()
    {
        return $this->get_filmmaker_by_id($this->filmmaker_id);
    }

    public function getRecordUrl($action = 'show')
    {
//        if ('show' == $action) {
//            return public_url($this->id);
//        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'films',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Film';
    }
}