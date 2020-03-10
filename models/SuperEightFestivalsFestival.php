<?php

class SuperEightFestivalsFestival extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    /**
     * @var int
     */
    public $city_id = -1;
    /**
     * @var int
     */
    public $year = -1;
    /**
     * @var string
     */
    public $title = "";
    /**
     * @var string
     */
    public $description = "";

    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    protected function _validate()
    {
        if (empty($this->city_id) || !is_numeric($this->city_id)) {
            $this->addError('city_id', 'The city in which the festival was held must be specified.');
        }
        if (empty($this->year) || !is_numeric($this->year)) {
            $this->addError('year', 'The year in which the festival was held must be specified.');
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
            'controller' => 'festivals',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Festival';
    }

    // ======================================================================================================================== \\

    public function get_city()
    {
        return get_city_by_id($this->city_id);
    }

    public function get_country()
    {
        return $this->get_city()->get_country();
    }

    function get_dir()
    {
        return $this->get_city()->get_festivals_dir() . "/" . $this->id;
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