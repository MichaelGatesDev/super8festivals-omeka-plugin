<?php

class SuperEightFestivalsFestivalFilm extends SuperEightFestivalsVideo
{
    // ======================================================================================================================== \\

    /**
     * @var int
     */
    public $festival_id = -1;
    /**
     * @var int
     */
    public $filmmaker_id = -1;

    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    protected function _validate()
    {
    }

    public function getRecordUrl($action = 'show')
    {
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

    // ======================================================================================================================== \\

    function get_filmmaker()
    {
        return $this->get_filmmaker_by_id($this->filmmaker_id);
    }

    // ======================================================================================================================== \\
}