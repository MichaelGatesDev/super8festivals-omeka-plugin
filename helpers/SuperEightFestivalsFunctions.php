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