<?php

require_once __DIR__ . "/../migrations/S8FDatabaseMigration.php";

$migration_dirs = array_filter(glob(__DIR__ . "/../migrations/*"), 'is_dir');
foreach($migration_dirs as $migration_dir) {
    $dir_name = basename($migration_dir);
    require_once ($migration_dir . "/" . $dir_name . ".php");
}