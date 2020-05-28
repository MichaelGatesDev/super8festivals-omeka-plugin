<?php
const TablePrefix = "super_eight_festivals_";

function create_table($table_prefix, $table_name, $cols, $primary_key)
{
    $db = get_db();

    $queryStart = "CREATE TABLE IF NOT EXISTS `{$db->prefix}{$table_prefix}{$table_name}`(";
    $queryContent = "";
    foreach ($cols as $col) {
        $queryContent .= $col . ",";
    }
    $queryEnd = "PRIMARY KEY (`{$primary_key}`)) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;";
    $query = $queryStart . $queryContent . $queryEnd;

    $db->query($query);
}


function create_tables()
{
    foreach (glob(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "**" . DIRECTORY_SEPARATOR . '*.php') as $file) {
        $class = basename($file, '.php');
        if (class_exists($class)) {
            $reflect = new ReflectionClass($class);
            if (!$reflect->isAbstract() && $reflect->isSubclassOf(Super8FestivalsRecord::class)) {
                $instance = new $class;
                $instance->create_table();
                logger_log(LogLevel::Debug, "Created table: " . $class);
            }
        }
    }
}

function drop_table($table_prefix, $table_name)
{
    $db = get_db();
    $query = "DROP TABLE IF EXISTS `{$db->prefix}{$table_prefix}{$table_name}`;";
    $db->query($query);
}

function drop_tables()
{
    foreach (glob(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "**" . DIRECTORY_SEPARATOR . '*.php') as $file) {
        $class = basename($file, '.php');
        if (class_exists($class)) {
            $reflect = new ReflectionClass($class);
            if (!$reflect->isAbstract() && $reflect->isSubclassOf(Super8FestivalsRecord::class)) {
                $instance = new $class;
                $instance->drop_table();
                logger_log(LogLevel::Debug, "Dropped table: " . $class);
            }
        }
    }
}