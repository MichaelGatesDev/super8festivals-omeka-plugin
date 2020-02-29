<?php

class SuperEightFestivalsContributor extends SuperEightFestivalsPerson
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRecordUrl($action = 'show')
    {
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'contributors',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Contributor';
    }
}