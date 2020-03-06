<?php

class SuperEightFestivalsFestivalFilmCatalog extends SuperEightFestivalsDocument
{
    public int $festival_id = -1;

    public function __construct()
    {
        parent::__construct();
    }

    protected function _validate()
    {
    }

    public function get_city()
    {
        return $this->getTable('SuperEightFestivalsCity')->find(get_festival_by_id($this->festival_id)->get_city()->id);
    }

    public function get_country()
    {
        return $this->getTable('SuperEightFestivalsCountry')->find(get_festival_by_id($this->festival_id)->get_country()->id);
    }

    public function getRecordUrl($action = 'show')
    {
//        if ('show' == $action) {
//            return public_url($this->name);
//        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'film-catalogs',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Film_Catalog';
    }
}