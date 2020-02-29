<?php

class SuperEightFestivalsPage extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public string $title = "";
    public string $url = "";
    public string $content = "";

    public function __construct()
    {
        parent::__construct();
    }

    protected function beforeSave($args)
    {
        $this->title = trim($this->title);
        $this->url = trim($this->url);
        $this->content = trim($this->content);
    }

    public function getRecordUrl($action = 'show')
    {
        if ('show' == $action) {
            return public_url($this->url);
        }
        return array(
            'module' => 'super-eight-festivals',
            'controller' => 'pages',
            'action' => $action,
            'id' => $this->id,
        );
    }

    public function getResourceId()
    {
        return 'SuperEightFestivals_Page';
    }
}