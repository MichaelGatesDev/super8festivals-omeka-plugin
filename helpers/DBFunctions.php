<?php
const TablePrefix = "super_eight_festivals_";

function create_table($table_prefix, $table_name, $cols, $fks, $primary_key)
{
    $db = get_db();

    $queryStart = "CREATE TABLE IF NOT EXISTS `{$db->prefix}{$table_prefix}{$table_name}`(";
    $queryContent = "";
    foreach ($cols as $col) {
        $queryContent .= $col . ",";
    }
    foreach ($fks as $fk) {
        $fk = str_replace("{db_prefix}", $db->prefix, $fk);
        $fk = str_replace("{table_prefix}", TablePrefix, $fk);
        $queryContent .= $fk . ", ";
    }
    $queryEnd = "PRIMARY KEY (`{$primary_key}`)) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;";
    $query = $queryStart . $queryContent . $queryEnd;

    $db->query($query);
}

function drop_table($table_prefix, $table_name)
{
    $db = get_db();
    $query = "DROP TABLE IF EXISTS `{$db->prefix}{$table_prefix}{$table_name}`;";
    $db->query($query);
}

function add_column($table_prefix, $table_name, $col)
{
    $db = get_db();
    $db->query("ALTER TABLE `{$db->prefix}{$table_prefix}{$table_name}` ADD COLUMN $col;");
}

function remove_column($table_prefix, $table_name, $column_name)
{
    $db = get_db();
    $db->query("ALTER TABLE `{$db->prefix}{$table_prefix}{$table_name}` DROP COLUMN $column_name;");
}

function create_missing_columns($table_prefix, $table_name, $cols)
{
    $db = get_db();
    foreach ($cols as $col) {
        try {
            $db->query("ALTER TABLE `{$db->prefix}{$table_prefix}{$table_name}` ADD COLUMN $col;");
        } catch (Exception $e) {
            logger_log(LogLevel::Warning, "Could not create missing column: " . $e->getMessage());
        }
    }
}

function create_tables()
{
    SuperEightFestivalsPerson::create_table();
    SuperEightFestivalsLocation::create_table();

    SuperEightFestivalsContributor::create_table();

    SuperEightFestivalsEmbed::create_table();
    SuperEightFestivalsFile::create_table();
    SuperEightFestivalsVideo::create_table();

    SuperEightFestivalsTimeline::create_table();

    SuperEightFestivalsFederationBylaw::create_table();
    SuperEightFestivalsFederationMagazine::create_table();
    SuperEightFestivalsFederationNewsletter::create_table();
    SuperEightFestivalsFederationPhoto::create_table();

    SuperEightFestivalsFilmmaker::create_table();
    SuperEightFestivalsFilmmakerFilm::create_table();
    SuperEightFestivalsFilmmakerPhoto::create_table();

    SuperEightFestivalsCountry::create_table();
    SuperEightFestivalsCity::create_table();
    SuperEightFestivalsCityBanner::create_table();
    SuperEightFestivalsCityTimeline::create_table();
    SuperEightFestivalsFestival::create_table();
    SuperEightFestivalsFestivalFilm::create_table();
    SuperEightFestivalsFestivalFilmCatalog::create_table();
    SuperEightFestivalsFestivalPhoto::create_table();
    SuperEightFestivalsFestivalPoster::create_table();
    SuperEightFestivalsFestivalPrintMedia::create_table();

    SuperEightFestivalsNearbyFestival::create_table();
    SuperEightFestivalsNearbyFestivalPhoto::create_table();
    SuperEightFestivalsNearbyFestivalPrintMedia::create_table();

    SuperEightFestivalsStaff::create_table();
}

function drop_tables()
{
    SuperEightFestivalsStaff::drop_table();

    SuperEightFestivalsNearbyFestivalPrintMedia::drop_table();
    SuperEightFestivalsNearbyFestivalPhoto::drop_table();
    SuperEightFestivalsNearbyFestival::drop_table();

    SuperEightFestivalsFestivalPrintMedia::drop_table();
    SuperEightFestivalsFestivalPoster::drop_table();
    SuperEightFestivalsFestivalPhoto::drop_table();
    SuperEightFestivalsFestivalFilmCatalog::drop_table();
    SuperEightFestivalsFestivalFilm::drop_table();
    SuperEightFestivalsFestival::drop_table();
    SuperEightFestivalsCityTimeline::drop_table();
    SuperEightFestivalsCityBanner::drop_table();
    SuperEightFestivalsCity::drop_table();
    SuperEightFestivalsCountry::drop_table();

    SuperEightFestivalsFilmmakerPhoto::drop_table();
    SuperEightFestivalsFilmmakerFilm::drop_table();
    SuperEightFestivalsFilmmaker::drop_table();

    SuperEightFestivalsFederationPhoto::drop_table();
    SuperEightFestivalsFederationNewsletter::drop_table();
    SuperEightFestivalsFederationMagazine::drop_table();
    SuperEightFestivalsFederationBylaw::drop_table();

    SuperEightFestivalsTimeline::drop_table();

    SuperEightFestivalsFile::drop_table();
    SuperEightFestivalsEmbed::drop_table();
    SuperEightFestivalsVideo::drop_table();

    SuperEightFestivalsContributor::drop_table();

    SuperEightFestivalsLocation::drop_table();
    SuperEightFestivalsPerson::drop_table();
}

function create_all_missing_columns()
{
    foreach (glob(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "**" . DIRECTORY_SEPARATOR . '*.php') as $file) {
        $class = basename($file, '.php');
        if (class_exists($class)) {
            try {
                $reflect = new ReflectionClass($class);
                if (!$reflect->isAbstract() && $reflect->isSubclassOf(Super8FestivalsRecord::class)) {
                    $instance = new $class;
                    $instance->create_missing_columns();
                    logger_log(LogLevel::Debug, "Created missing columns for table: " . $class);
                }
            } catch (ReflectionException $e) {
                logger_log(LogLevel::Error, $e->getMessage());
            }
        }
    }
}
