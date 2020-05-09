<?php
const DefaultImageColumns = array(
    "`id`                  INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
    "`contributor_id`      INT(10) UNSIGNED",
    "`title`               VARCHAR(255)",
    "`description`         TEXT(65535)",
    "`thumbnail_file_name` TEXT(65535)",
    "`file_name`           TEXT(65535)",
);

const DefaultVideoColumns = array(
    "`id`                  INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
    "`contributor_id`      INT(10) UNSIGNED",
    "`filmmaker_id`        INT(10) UNSIGNED",
    "`title`               VARCHAR(255)",
    "`description`         TEXT(65535)",
    "`thumbnail_file_name` TEXT(65535)",
    "`embed`               TEXT(65535)",
);

const DefaultDocumentColumns = array(
    "`id`                  INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
    "`contributor_id`      INT(10) UNSIGNED",
    "`title`               VARCHAR(255)",
    "`description`         TEXT(65535)",
    "`thumbnail_file_name` TEXT(65535)",
    "`file_name`           TEXT(65535)",
);

const DefaultLocationColumns = array(
    "`id`           INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
    "`name`         VARCHAR(255)     NOT NULL",
    "`latitude`     FLOAT(8, 5)",
    "`longitude`    FLOAT(8, 5)",
);

const DefaultPersonColumns = array(
    "`id`                   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
    "`first_name`           VARCHAR(255)",
    "`last_name`            VARCHAR(255)",
    "`organization_name`    VARCHAR(255)",
    "`email`                VARCHAR(255) NOT NULL",
);


const TablePrefix = "super_eight_festivals_";

interface TableType
{
    const Image = 0;
    const Video = 1;
    const Document = 2;
    const Location = 3;
    const Person = 4;
}


function create_table_of_type($table_prefix, $table_name, $table_type, $extra_cols = array())
{
    $cols = array();
    switch ($table_type) {
        case TableType::Image:
            $cols = DefaultImageColumns;
            break;
        case TableType::Video:
            $cols = DefaultVideoColumns;
            break;
        case TableType::Document:
            $cols = DefaultDocumentColumns;
            break;
        case TableType::Location:
            $cols = DefaultLocationColumns;
            break;
        case TableType::Person:
            $cols = DefaultPersonColumns;
            break;
    }

    array_push($cols, ...$extra_cols);

    create_table(
        $table_prefix,
        $table_name,
        $cols,
        "id"
    );
}

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
    /*=====================================================================
     *                          ### IMAGES ###
     ======================================================================*/
    create_table_of_type(
        TablePrefix,
        "federation_photos",
        TableType::Image
    );
    create_table_of_type(
        TablePrefix,
        "country_banners",
        TableType::Image,
        array(
            "`country_id`   INT(10) UNSIGNED NOT NULL",
            "`active`       BOOL",
        )
    );
    create_table_of_type(
        TablePrefix,
        "city_banners",
        TableType::Image,
        array(
            "`city_id`  INT(10) UNSIGNED NOT NULL",
            "`active`   BOOL",
        )
    );
    create_table_of_type(
        TablePrefix,
        "festival_photos",
        TableType::Image,
        array(
            "`festival_id`  INT(10) UNSIGNED NOT NULL",
        )
    );
    create_table_of_type(
        TablePrefix,
        "festival_posters",
        TableType::Image,
        array(
            "`festival_id`  INT(10) UNSIGNED NOT NULL",
        )
    );
    /*=====================================================================
     *                          ### VIDEOS ###
     ======================================================================*/
    create_table_of_type(
        TablePrefix,
        "festival_films",
        TableType::Video,
        array(
            "`festival_id`  INT(10) UNSIGNED NOT NULL",
        )
    );
    /*=====================================================================
     *                          ### DOCUMENTS ###
     ======================================================================*/
    create_table_of_type(
        TablePrefix,
        "federation_documents",
        TableType::Document
    );
    create_table_of_type(
        TablePrefix,
        "festival_film_catalogs",
        TableType::Document,
        array(
            "`festival_id`  INT(10) UNSIGNED NOT NULL",
        )
    );
    create_table_of_type(
        TablePrefix,
        "festival_memorabilias",
        TableType::Document,
        array(
            "`festival_id`  INT(10) UNSIGNED NOT NULL",
        )
    );
    create_table_of_type(
        TablePrefix,
        "festival_print_medias",
        TableType::Document,
        array(
            "`festival_id`  INT(10) UNSIGNED NOT NULL",
        )
    );
    /*=====================================================================
     *                          ### LOCATIONS ###
     ======================================================================*/
    create_table_of_type(
        TablePrefix,
        "countries",
        TableType::Location
    );
    create_table_of_type(
        TablePrefix,
        "cities",
        TableType::Location,
        array(
            "`country_id`   INT(10) UNSIGNED",
        )
    );
    /*=====================================================================
     *                          ### PEOPLE ###
     ======================================================================*/
    create_table_of_type(
        TablePrefix,
        "festival_filmmakers",
        TableType::Person,
        array(
            "`festival_id`  INT(10) UNSIGNED NOT NULL",

        )
    );
    create_table_of_type(
        TablePrefix,
        "contributors",
        TableType::Person
    );
    /*=====================================================================
     *                          ### OTHER ###
     ======================================================================*/
    create_table(
        TablePrefix,
        "festivals",
        array(
            "`id`           INT(10) UNSIGNED NOT NULL AUTO_INCREMENT",
            "`city_id`      INT(10) UNSIGNED NOT NULL",
            "`year`         INT(4)           NOT NULL",
            "`title`        VARCHAR(255)",
            "`description`  TEXT(65535)",

        ),
        "id"
    );

}

function drop_tables()
{
    /*=====================================================================
     *                          ### IMAGES ###
     ======================================================================*/
    drop_table(TablePrefix, "federation_photos");
    drop_table(TablePrefix, "country_banners");
    drop_table(TablePrefix, "city_banners");
    drop_table(TablePrefix, "festival_photos");
    drop_table(TablePrefix, "festival_posters");
    /*=====================================================================
     *                          ### VIDEOS ###
     ======================================================================*/
    drop_table(TablePrefix, "festival_films");
    /*=====================================================================
     *                          ### DOCUMENTS ###
     ======================================================================*/
    drop_table(TablePrefix, "federation_documents");
    drop_table(TablePrefix, "festival_film_catalogs");
    drop_table(TablePrefix, "festival_memorabilias");
    drop_table(TablePrefix, "festival_print_medias");
    /*=====================================================================
     *                          ### LOCATIONS ###
     ======================================================================*/
    drop_table(TablePrefix, "countries");
    drop_table(TablePrefix, "cities");
    /*=====================================================================
     *                          ### PEOPLE ###
     ======================================================================*/
    drop_table(TablePrefix, "festival_filmmakers");
    drop_table(TablePrefix, "contributors");
    /*=====================================================================
     *                          ### OTHER ###
     ======================================================================*/
    drop_table(TablePrefix, "festivals");
    drop_table(TablePrefix, "pages");
}

function drop_table($table_prefix, $table_name)
{
    $db = get_db();
    $query = "DROP TABLE IF EXISTS `{$db->prefix}{$table_prefix}{$table_name}`;";
    $db->query($query);
}