<?php

function get_all_countries($sortByCountryName = false)
{
    $results = get_db()->getTable("SuperEightFestivalsCountry")->findAll();
    if ($sortByCountryName) {
        usort($results, function ($a, $b) {
            return get_country_by_id($a->id)->name > get_country_by_id($b->id)->name;
        });
    }
    return $results;
}

function get_all_cities($sortByCityName = false, $sortByCountryName = false)
{
    $results = get_db()->getTable("SuperEightFestivalsCity")->findAll();
    if ($sortByCityName) {
        usort($results, function ($a, $b) {
            return $a['name'] > $b['name'];
        });
    }
    if ($sortByCountryName) {
        usort($results, function ($a, $b) {
            return get_country_by_id($a['country_id'])->name > get_country_by_id($b['country_id'])->name;
        });
    }
    return $results;
}

function get_parent_country_options()
{
    $valuePairs = array();
    $potentialParents = get_db()->getTable('SuperEightFestivalsCountry')->findPotentialParentCountries();
    foreach ($potentialParents as $potentialParent) {
        if (trim($potentialParent->name) != '') {
            $valuePairs[$potentialParent->id] = $potentialParent->name;
        }
    }
    return $valuePairs;
}

function get_parent_city_options($countryID)
{
    $valuePairs = array();
    $potentialParents = get_db()->getTable('SuperEightFestivalsCity')->findPotentialParentCities();
    foreach ($potentialParents as $potentialParent) {
        if (trim($potentialParent->name) != '') {
            $valuePairs[$potentialParent->id] = $potentialParent->name;
        }
    }
    return $valuePairs;
}

function get_parent_country_id($cityID)
{
    $city = get_db()->getTable('SuperEightFestivalsCity')->find($cityID);
    return $city->country_id;
}

function get_city_by_id($cityID)
{
    return get_db()->getTable('SuperEightFestivalsCity')->find($cityID);
}

function get_country_by_id($countryID)
{
    return get_db()->getTable('SuperEightFestivalsCountry')->find($countryID);
}

function get_country_by_name($countryName)
{
    $results = get_db()->getTable('SuperEightFestivalsCountry')->findBy(array('name' => $countryName), 1);
    if (count($results) > 0) return $results[0];
    return null;
}

function get_city_by_name($countryID, $cityName)
{
    $results = get_db()->getTable('SuperEightFestivalsCity')->findBy(array('country_id' => $countryID, 'name' => $cityName), 1);
    if (count($results) > 0) return $results[0];
    return null;
}

function add_country($countryName)
{
    // Save an example page.
    $country = new SuperEightFestivalsCountry();
    $country->name = $countryName;
    $country->save();
}

function add_city($countryName, $name, $latitude, $longitude)
{
    // Save an example page.
    $city = new SuperEightFestivalsCity();
    $city->name = $name;
    $city->latitude = $latitude;
    $city->longitude = $longitude;
    $city->country_id = get_country_by_name($countryName)->id;
    $city->save();
}

function get_banner_for_country($countryID)
{
    $results = get_db()->getTable('SuperEightFestivalsCountryBanner')->findBy(array('country_id' => $countryID), 1);
    if (count($results) > 0) return $results[0];
    return null;
}

function get_all_posters_for_country($countryID)
{
    return get_db()->getTable('SuperEightFestivalsFestivalPoster')->findBy(array('country_id' => $countryID));
}

function get_all_photos_for_country($countryID)
{
    return get_db()->getTable('SuperEightFestivalsFestivalPhoto')->findBy(array('country_id' => $countryID));
}

function get_all_print_media_for_country($countryID)
{
    return get_db()->getTable('SuperEightFestivalsFestivalPrintMedia')->findBy(array('country_id' => $countryID));
}