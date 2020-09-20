<?php

// ============================================================================================================================================================= \\

function is_localhost()
{
    return (in_array($_SERVER['REMOTE_ADDR'], array(
        "127.0.0.1",
        "::1"
    )));
}

function base_url($atRoot = FALSE, $atCore = FALSE, $parse = FALSE)
{
    if (isset($_SERVER['HTTP_HOST'])) {
        $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
        $hostname = $_SERVER['HTTP_HOST'];
        $dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
        $core = $core[0];

        $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
        $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
        $base_url = sprintf($tmplt, $http, $hostname, $end);
    } else $base_url = 'http://localhost/';

    if ($parse) {
        $base_url = parse_url($base_url);
        if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
    }

    return substr($base_url, 0, strlen($base_url) - 1);
}

function alpha_only($string) {
    $string = str_replace(' ', ' ', $string);
    $string = preg_replace('/[^A-Za-z\-]/', ' ', $string);
    return $string;
}

// ============================================================================================================================================================= \\

function get_parent_country_options(): array
{
    $results = array();
    $results[0] = "Select...";
    $potentialParents = get_db()->getTable('SuperEightFestivalsCountry')->findAll();
    foreach ($potentialParents as $potentialParent) {
        $results[$potentialParent->id] = $potentialParent->name;
    }
    return $results;
}

function get_parent_city_options(): array
{
    $results = array();
    $results[0] = "Select...";
    $potentialParents = get_db()->getTable('SuperEightFestivalsCity')->findAll();
    foreach ($potentialParents as $potentialParent) {
        $results[$potentialParent->id] = $potentialParent->name;
    }
    return $results;
}


function get_all_cities_by_name_ambiguous($cityName, $partial = false): array
{
    if ($partial) {
        $partialResults = array();
        $allCities = SuperEightFestivalsCity::get_all();
        $split = explode(" ", $cityName);
        foreach ($split as $word) {
            foreach ($allCities as $city) {
                if (strpos($city->name, $word) !== false) {
                    array_push($partialResults, $city);
                }
            }
        }
        return $partialResults;
    }
    return get_db()->getTable('SuperEightFestivalsCity')->findBy(array('name' => $cityName), -1);
}

function get_parent_festival_options(): array
{
    $results = array();
    $results[0] = "Select...";
    $festivals = SuperEightFestivalsFestival::get_all();
    foreach ($festivals as $festival) {
        $results[$festival->id] = $festival->get_title();
    }
    return $results;
}

function get_parent_filmmaker_options(): array
{
    $results = array();
    $results[0] = "Select...";
    $potentialParents = get_db()->getTable('SuperEightFestivalsFilmmaker')->findAll();
    foreach ($potentialParents as $potentialParent) {
        $results[$potentialParent->id] = $potentialParent->get_display_name();
    }
    return $results;
}

function get_parent_contributor_options(): array
{
    $results = array();
    $results[0] = "Select...";
    $potentialParents = get_db()->getTable('SuperEightFestivalsContributor')->findAll();
    foreach ($potentialParents as $potentialParent) {
        $results[$potentialParent->id] = $potentialParent->get_display_name();
    }
    return $results;
}

function get_all_users (){
    return get_db()->getTableName("User")->findAll();
}

// get_country_by_name
// get_all_city_banners
// get_city_banner
// get_all_cities
// get_all_cities_in_country
// get_city_by_name
// get_city_by_name_ambiguous
// SuperEightFestivalsCity::get_by_id
// get_all_festivals
// get_all_festivals_in_country
// get_all_festivals_in_city
// SuperEightFestivalsFestival::get_by_id
// get_all_film_catalogs
// get_all_film_catalogs_for_festival
// get_all_film_catalogs_for_city
// get_film_catalog_by_id
// get_all_filmmakers
// get_all_filmmakers_for_city
// SuperEightFestivalsFilmmaker::get_by_id
// get_all_films
// get_all_films_for_festival
// get_all_films_for_city
// get_film_by_id
// get_all_memorabilia
// get_all_memorabilia_for_festival
// get_all_memorabilia_for_city
// get_memorabilia_by_id
// get_all_print_media
// get_all_print_media_for_festival
// get_all_print_media_for_city
// get_print_media_by_id
// get_all_photos
// get_all_photos_for_festival
// get_all_photos_for_city
// get_photo_by_id
// get_all_posters
// get_all_posters_for_festival
// get_all_posters_for_city
// get_poster_by_id
// get_all_contributors
// SuperEightFestivalsContributor::get_by_id
// get_filmmaker_photo_by_id
// get_all_photos_for_filmmaker
// get_all_films_for_filmmaker
// get_all_staffs
// get_staff_by_id
// get_all_cities_by_name_ambiguous