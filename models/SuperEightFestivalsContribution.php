<?php

class SuperEightFestivalsContribution extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $type;
    public $contributor_id;

    public function getResourceId()
    {
        return 'SuperEightFestivals_Contribution';
    }
}