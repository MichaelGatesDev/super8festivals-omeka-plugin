<?php

class SuperEightFestivalsContributor extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    // ======================================================================================================================== \\

    use S8FPerson;

    // ======================================================================================================================== \\

    public function getResourceId()
    {
        return 'SuperEightFestivals_Contributor';
    }

    // ======================================================================================================================== \\
}