<?php

// ============================================================================================================================================================= \\

function build_url($pieces)
{
    return join("/", $pieces) . (sizeof($pieces) > 0 ? "/" : "");
}

function build_admin_url($pieces)
{
    return "/admin/" . build_url($pieces);
}

function build_plugin_url($pieces)
{
    return admin_url() . "/" . build_url($pieces);
}

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

function alpha_only($string)
{
    $string = str_replace(' ', ' ', $string);
    $string = preg_replace('/[^A-Za-z\-]/', ' ', $string);
    return $string;
}

function get_nested_property($array, $path)
{
    $path = explode('.', $path);
    $temp =& $array;
    foreach ($path as $key) {
        $temp =& $temp[$key];
    }
    return $temp;
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
        $results[$potentialParent->id] = $potentialParent->get_person()->get_name();
    }
    return $results;
}

function get_parent_contributor_options(): array
{
    $results = array();
    $results[0] = "Select...";
    $potentialParents = get_db()->getTable('SuperEightFestivalsContributor')->findAll();
    foreach ($potentialParents as $potentialParent) {
        $results[$potentialParent->id] = $potentialParent->get_person()->get_name();
    }
    return $results;
}

function get_all_users()
{
    return get_db()->getTable("User")->findAll();
}

function filter_array($arr, $propertiesToRemove)
{
    foreach ($propertiesToRemove as $prop) {
        unset($arr[$prop]);
    }
    return $arr;
}