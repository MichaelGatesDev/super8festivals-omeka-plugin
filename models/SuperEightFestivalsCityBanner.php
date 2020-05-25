<?php

class SuperEightFestivalsCityBanner extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    use S8FPreviewable;

    public $city_id = 0;

    // ======================================================================================================================== \\

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->city_id) || !is_numeric($this->city_id)) {
            $this->addError('country_id', 'The country that the city exists in must be specified.');
        }
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_City_Banner';
    }

    // ======================================================================================================================== \\

    public function get_internal_prefix(): string
    {
        return "city_banner";
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

    // ======================================================================================================================== \\
}