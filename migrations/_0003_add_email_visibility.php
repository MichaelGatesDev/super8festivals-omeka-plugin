<?php


class _0003_add_email_visibility extends S8FDatabaseMigration
{
    function apply()
    {
        add_column(
            TablePrefix,
            Inflector::tableize(str_replace("SuperEightFestivals", "", SuperEightFestivalsPerson::class)),
            "`is_email_visible` BOOL NOT NULL DEFAULT 0",
        );
    }

    function undo()
    {
        remove_column(
            TablePrefix,
            Inflector::tableize(str_replace("SuperEightFestivals", "", SuperEightFestivalsPerson::class)),
            "is_email_visible",
        );
    }
}
