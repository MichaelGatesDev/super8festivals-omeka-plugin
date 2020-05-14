<?php

class SuperEightFestivalsFederationPhoto extends SuperEightFestivalsImage
{
    // ======================================================================================================================== \\

    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    protected function _validate()
    {
    }

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
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
        return 'SuperEightFestivals_Federation_Photo';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "photo";
    }

    public function get_dir(): string
    {
        return get_federation_dir() . "/photos";
    }

    private function create_files()
    {
        if (!file_exists($this->get_dir())) {
            mkdir($this->get_dir());
        }
    }

    // ======================================================================================================================== \\
}