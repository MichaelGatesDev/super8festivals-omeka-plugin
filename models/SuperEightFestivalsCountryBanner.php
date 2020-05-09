<?php

class SuperEightFestivalsCountryBanner extends SuperEightFestivalsImage
{
    // ======================================================================================================================== \\

    /**
     * @var int
     */
    public $country_id = 0;
    /**
     * @var bool
     */
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
        if (empty($this->country_id) || !is_numeric($this->country_id)) {
            $this->addError('country_id', 'The country that the city exists in must be specified.');
        }
    }

    protected function beforeSave($args)
    {
        parent::beforeSave($args);
        if ($this->active) {
            foreach (get_country_banners($this->country_id) as $banner) {
                if ($banner->id == $this->id) continue;
                $banner->active = false;
                $banner->save();
            }
        }
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Country_Banner';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "banner";
    }

    public function get_country()
    {
        return $this->getTable('SuperEightFestivalsCountry')->find($this->country_id);
    }

    public function get_dir(): string
    {
        return $this->get_country()->get_dir();
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