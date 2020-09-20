<?php

trait S8FContributable
{
    // ======================================================================================================================== \\

    use S8FRecord;

    public $contributor_id = 0;

    public static function get_db_columns()
    {
        return array(
            "`contributor_id`      INT(10) UNSIGNED",
        );
    }

    // ======================================================================================================================== \\

    function get_contributor()
    {
        return SuperEightFestivalsContributor::get_by_id($this->contributor_id);
    }

    // ======================================================================================================================== \\
}