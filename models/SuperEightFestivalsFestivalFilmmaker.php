<?php

class SuperEightFestivalsFestivalFilmmaker extends SuperEightFestivalsPerson
{
    // ======================================================================================================================== \\

    /**
     * @var int
     */
    public $festival_id = -1;

    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    public function getRecordUrl($action = 'show')
    {
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

    // ======================================================================================================================== \\
}