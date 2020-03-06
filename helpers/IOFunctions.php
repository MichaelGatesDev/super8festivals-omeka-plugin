<?php

// ============================================================================================================================================================= \\

/**
 * @param $inputName
 * @return array Returns an array with the original name, temporary name, and extension of the temporary file.
 */
function get_temporary_file($inputName): array
{
    $tmpFileOriginalName = $_FILES['file']['name'];
    $tmpFileName = $_FILES[$inputName]['tmp_name'];
    $ext = pathinfo($tmpFileOriginalName, PATHINFO_EXTENSION);
    return array(
        $tmpFileOriginalName,
        $tmpFileName,
        $ext,
    );
}

/**
 * Moves a file from its current location to a new directory with a new name
 * @param $fromPath
 * @param $newFileName
 * @param $newFileDir
 */
function move_to_dir($fromPath, $newFileName, $newFileDir): void
{
    move_uploaded_file($fromPath, $newFileDir . "/" . $newFileName);
}

/**
 * Recursively removes directory and all of its contents
 * @param $dir
 */
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
                    rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                else
                    unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }
        rmdir($dir);
    }
}

function delete_file($filePath)
{
    if (is_dir($filePath) || !file_exists($filePath)) return;
    unlink($filePath);
}


// ============================================================================================================================================================= \\

function create_plugin_directories()
{
    mkdir(get_project_dir(), 0777, true);
    mkdir(get_countries_dir(), 0777, true);
}

function delete_plugin_directories()
{
    rrmdir(get_project_dir());
}

function get_relative_path($dir)
{
    return str_replace(get_root_dir(), "", $dir);
}

function get_root_dir()
{
    return $_SERVER['DOCUMENT_ROOT'];
}

function get_project_dir()
{
    return get_root_dir() . "/super-eight-festivals";
}

// ============================================================================================================================================================= \\

function get_countries_dir()
{
    return get_project_dir() . "/countries";
}

// ============================================================================================================================================================= \\

function create_country_dir($countryName)
{
    $countryDir = get_country_dir($countryName);
    mkdir($countryDir);
}

function delete_country_dir($countryName)
{
    rrmdir(get_country_dir($countryName));
}

function get_country_dir($countryName)
{
    return get_countries_dir() . "/" . replace_space_with_dash($countryName);
}

// ============================================================================================================================================================= \\

function create_city_dir($countryName, $cityName)
{
    $cityDir = get_city_dir($countryName, $cityName);
    mkdir($cityDir);
    create_film_catalogs_dir($countryName, $cityName);
    create_filmmakers_dir($countryName, $cityName);
    create_films_dir($countryName, $cityName);
    create_memorabilia_dir($countryName, $cityName);
    create_print_media_dir($countryName, $cityName);
    create_photos_dir($countryName, $cityName);
    create_posters_dir($countryName, $cityName);
}

function delete_city_dir($countryName, $cityName)
{
    rrmdir(get_city_dir($countryName, $cityName));
}

function get_city_dir($countryName, $cityName)
{
    return get_country_dir($countryName) . "/" . replace_space_with_dash($cityName);
}

// ============================================================================================================================================================= \\

function get_film_catalogs_dir($countryName, $cityName)
{
    return get_city_dir($countryName, $cityName) . "/film-catalogs";
}

function create_film_catalogs_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_film_catalogs_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

function delete_film_catalogs_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_film_catalogs_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

// ============================================================================================================================================================= \\

function get_filmmakers_dir($countryName, $cityName)
{
    return get_city_dir($countryName, $cityName) . "/filmmakers";
}

function create_filmmakers_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_filmmakers_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

function delete_filmmakers_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_filmmakers_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

// ============================================================================================================================================================= \\

function get_films_dir($countryName, $cityName)
{
    return get_city_dir($countryName, $cityName) . "/films";
}

function create_films_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_films_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

function delete_films_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_films_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

// ============================================================================================================================================================= \\

function get_memorabilia_dir($countryName, $cityName)
{
    return get_city_dir($countryName, $cityName) . "/memorabilia";
}

function create_memorabilia_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_memorabilia_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

function delete_memorabilia_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_memorabilia_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

// ============================================================================================================================================================= \\

function get_print_media_dir($countryName, $cityName)
{
    return get_city_dir($countryName, $cityName) . "/print-media";
}

function create_print_media_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_print_media_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

function delete_print_media_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_print_media_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

// ============================================================================================================================================================= \\

function get_photos_dir($countryName, $cityName)
{
    return get_city_dir($countryName, $cityName) . "/photos";
}

function create_photos_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_photos_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

function delete_photos_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_photos_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

// ============================================================================================================================================================= \\

function get_posters_dir($countryName, $cityName)
{
    return get_city_dir($countryName, $cityName) . "/posters";
}

function create_posters_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_posters_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}

function delete_posters_dir($countryName, $cityName)
{
    $filmCatalogsDir = get_posters_dir($countryName, $cityName);
    mkdir($filmCatalogsDir);
}
