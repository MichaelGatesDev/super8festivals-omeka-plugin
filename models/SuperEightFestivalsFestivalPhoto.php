<?php

class SuperEightFestivalsFestivalPhoto extends SuperEightFestivalsImage
{
    // ======================================================================================================================== \\

    /**
     * @var int
     */
    public $festival_id = 0;

    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->festival_id) || !is_numeric($this->festival_id)) {
            $this->addError('festival_id', 'You must select a valid festival!');
        }
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Photo';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "photo";
    }

    public function get_festival()
    {
        return get_festival_by_id($this->festival_id);
    }

    public function get_city()
    {
        return $this->get_festival()->get_city();
    }

    public function get_country()
    {
        return $this->get_festival()->get_country();
    }

    public function get_dir(): string
    {
        return $this->get_festival()->get_photos_dir();
    }

    // ======================================================================================================================== \\
}