<?php

trait S8FImage
{
    // ======================================================================================================================== \\

    use S8FRecord;
    use S8FMetadata;
    use S8FPreviewable;

    public static function get_db_columns()
    {
        return array_merge(
            S8FMetadata::get_db_columns(),
            S8FPreviewable::get_db_columns()
        );
    }

    // ======================================================================================================================== \\
}