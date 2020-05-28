<?php

trait S8FVideo
{
    // ======================================================================================================================== \\

    use S8FRecord;

    public $embed = "";
    use S8FMetadata;

    public static function get_db_columns()
    {
        return array_merge(
            array(
                "`embed`               TEXT(65535)",
            ),
            S8FMetadata::get_db_columns(),
            S8FPreviewable::get_db_columns()
        );
    }

    // ======================================================================================================================== \\

}