<?php


class _0001_add_filmmaker_bio extends S8FDatabaseMigration
{
    function apply()
    {
        add_column(
            TablePrefix,
            Inflector::tableize(str_replace("SuperEightFestivals", "", SuperEightFestivalsFilmmaker::class)),
            "`bio` TEXT(65535)",
        );
    }

    function undo()
    {
        remove_column(
            TablePrefix,
            Inflector::tableize(str_replace("SuperEightFestivals", "", SuperEightFestivalsFilmmaker::class)),
            "bio",
        );
    }
}
