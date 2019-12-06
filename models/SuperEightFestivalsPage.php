<?php

class SuperEightFestivalsPage extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $title;
    public $url;
    public $content;

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