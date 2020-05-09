<?php

abstract class SuperEightFestivalsVideo extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    /**
     * @var int
     */
    public $contributor_id = 0;
    /**
     * @var string
     */
    public $title = "";
    /**
     * @var string
     */
    public $description = "";
    /**
     * @var string
     */
    public $thumbnail_file_name = "";
    /**
     * @var string
     */
    public $embed = "";

    // ======================================================================================================================== \\

    public function __construct()
    {
        parent::__construct();
    }

    protected function beforeSave($args)
    {
        $this->title = trim($this->title);
        $this->description = trim($this->description);
    }

    // ======================================================================================================================== \\

    function get_contributor()
    {
        return get_contributor_by_id($this->contributor_id);
    }

    // ======================================================================================================================== \\
}