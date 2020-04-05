<?php

class SuperEightFestivalsCityBanner extends SuperEightFestivalsImage
{
    // ======================================================================================================================== \\

    public $city_id = -1;
    public $active = false;

    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
        $this->contributor_id = 0;
    }

    protected function _validate()
    {
        parent::_validate();
        if ($this->country_id <= 0) {
            $this->addError('country_id', 'The country this banner belongs to must be specified.');
        }
        if ($this->city_id <= 0) {
            $this->addError('city_id', 'The city this banner belongs to must be specified.');
        }
    }

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        if ($this->active) {
            foreach (get_city_banners($this->city_id) as $banner) {
                if ($banner->id == $this->id) continue;
                $banner->active = false;
                $banner->save();
            }
        }
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_City_Banner';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "banner";
    }

    public function get_country(): ?SuperEightFestivalsCountry
    {
        return $this->get_city()->get_country();
    }

    public function get_city(): ?SuperEightFestivalsCity
    {
        return $this->getTable('SuperEightFestivalsCity')->find($this->city_id);
    }

    public function get_dir(): string
    {
        return $this->get_city()->get_dir();
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