<?php

class SuperEightFestivalsCountry extends SuperEightFestivalsLocation
{
    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    public function getRecordUrl($action = 'show')
    {
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'countries',
            'action' => $action,
            'id' => $this->id,
        );
    }

    protected function afterSave($args)
    {
        parent::afterSave($args);
        $this->create_files();
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->delete_files();
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Country';
    }

    // ======================================================================================================================== \\

    function get_dir()
    {
        return get_countries_dir() . "/" . $this->name;
    }

    private function create_files()
    {
        if (!file_exists($this->get_dir())) {
            mkdir($this->get_dir());
        }
    }

    public function delete_files()
    {
        if (file_exists($this->get_dir())) {
            rrmdir($this->get_dir());
        }
    }

    // ======================================================================================================================== \\
}