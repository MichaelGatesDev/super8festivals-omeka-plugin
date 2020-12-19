<?php


abstract class S8FDatabaseMigration
{
    /**
     * @param $path
     * @return array|false
     */
    function get_csv_lines($path)
    {
        return file($path, FILE_IGNORE_NEW_LINES);
    }

    abstract function run_migrations();
}