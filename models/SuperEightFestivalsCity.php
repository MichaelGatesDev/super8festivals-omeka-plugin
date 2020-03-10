<?php

class SuperEightFestivalsCity extends SuperEightFestivalsLocation
{
    // ======================================================================================================================== \\

    /**
     * @var int
     */
    public $country_id = -1;

    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    protected function _validate()
    {
        parent::_validate();
        if (empty($this->country_id) || !is_numeric($this->country_id)) {
            $this->addError('country_id', 'The country that the city exists in must be specified.');
        }
        if (!is_float(floatval($this->latitude))) {
            $this->addError('latitude', 'The latitude must be a floating point value.');
        }
        if (!is_float(floatval($this->longitude))) {
            $this->addError('longitude', 'The longitude must be a floating point value.');
        }
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

    public function getRecordUrl($action = 'show')
    {
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'cities',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_City';
    }

    // ======================================================================================================================== \\

    public function get_country()
    {
        return $this->getTable('SuperEightFestivalsCountry')->find($this->country_id);
    }

    function get_dir()
    {
        return $this->get_country()->get_dir() . "/" . $this->name;
    }

    function get_film_catalogs_dir()
    {
        return $this->get_dir() . "/film-catalogs";
    }

    function get_filmmakers_dir()
    {
        return $this->get_dir() . "/filmmakers";
    }

    function get_films_dir()
    {
        return $this->get_dir() . "/films";
    }

    function get_memorabilia_dir()
    {
        return $this->get_dir() . "/memorabilia";
    }

    function get_photos_dir()
    {
        return $this->get_dir() . "/photos";
    }

    function get_posters_dir()
    {
        return $this->get_dir() . "/posters";
    }

    function get_print_media_dir()
    {
        return $this->get_dir() . "/print-media";
    }


    private function create_files()
    {
        if (!file_exists($this->get_dir())) {
            mkdir($this->get_dir());
        }

        if (!file_exists($this->get_film_catalogs_dir())) {
            mkdir($this->get_film_catalogs_dir());
        }
        if (!file_exists($this->get_filmmakers_dir())) {
            mkdir($this->get_filmmakers_dir());
        }
        if (!file_exists($this->get_films_dir())) {
            mkdir($this->get_films_dir());
        }
        if (!file_exists($this->get_memorabilia_dir())) {
            mkdir($this->get_memorabilia_dir());
        }
        if (!file_exists($this->get_photos_dir())) {
            mkdir($this->get_photos_dir());
        }
        if (!file_exists($this->get_posters_dir())) {
            mkdir($this->get_posters_dir());
        }
        if (!file_exists($this->get_print_media_dir())) {
            mkdir($this->get_print_media_dir());
        }
    }

    public function delete_files()
    {
        if (file_exists($this->get_dir())) {
            rrmdir($this->get_dir());
        }

        if (!file_exists($this->get_film_catalogs_dir())) {
            rrmdir($this->get_film_catalogs_dir());
        }
        if (!file_exists($this->get_filmmakers_dir())) {
            rrmdir($this->get_filmmakers_dir());
        }
        if (!file_exists($this->get_films_dir())) {
            rrmdir($this->get_films_dir());
        }
        if (!file_exists($this->get_memorabilia_dir())) {
            rrmdir($this->get_memorabilia_dir());
        }
        if (!file_exists($this->get_photos_dir())) {
            rrmdir($this->get_photos_dir());
        }
        if (!file_exists($this->get_posters_dir())) {
            rrmdir($this->get_posters_dir());
        }
        if (!file_exists($this->get_print_media_dir())) {
            rrmdir($this->get_print_media_dir());
        }
    }

    // ======================================================================================================================== \\
}