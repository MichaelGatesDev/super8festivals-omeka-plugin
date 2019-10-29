<?php

class SuperEightFestivalsContributionType extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $name;

    public function getResourceId()
    {
        return 'SuperEightFestivals_ContributionType';
    }
}