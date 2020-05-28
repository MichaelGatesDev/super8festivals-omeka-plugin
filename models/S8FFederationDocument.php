<?php

trait S8FFederationDocument
{
    // ======================================================================================================================== \\

    use S8FRecord;
    use S8FDocument;
    use S8FContributable;

    public static function get_db_columns()
    {
        return array_merge(
            S8FDocument::get_db_columns(),
            S8FContributable::get_db_columns()
        );
    }

    // ======================================================================================================================== \\
}