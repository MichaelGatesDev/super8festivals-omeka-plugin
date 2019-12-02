<?php


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


function add_country($countryName)
{
    // Save an example page.
    $country = new SuperEightFestivalsCountry();
    $country->name = $countryName;
    $country->save();
}

function add_city($countryName, $name, $latitude, $longitude)
{
    echo "<script>alert($countryName);</script>";

    // Save an example page.
    $city = new SuperEightFestivalsCity();
    $city->name = $name;
    $city->latitude = $latitude;
    $city->longitude = $longitude;
    $city->country_id = get_country_by_name($countryName)->id;
    $city->save();
}
