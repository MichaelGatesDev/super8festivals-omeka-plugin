<?php

class SuperEightFestivalsFestivalMemorabilia extends SuperEightFestivalsDocument
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

    protected function _validate()
    {
        parent::_validate();
        if ($this->festival_id <= 0) {
            $this->addError('festival_id', 'You must select a valid festival!');
        }
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival_Memorabilia';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "memorabilia";
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
        return $this->get_festival()->get_memorabilia_dir();
    }

    public function get_path(): string
    {
        return $this->get_dir() . "/" . $this->file_name;
    }

    public function get_thumbnail_path(): string
    {
        return $this->get_dir() . "/" . $this->thumbnail_file_name;
    }


    // ======================================================================================================================== \\
}