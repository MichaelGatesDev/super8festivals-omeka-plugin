<?php

/**
 * @param bool $sortByCountryName Sort results by country name ascending (A-Z)
 * @return array Resulting array of countries
 */
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

// ============================================================================================================================================================= \\

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

function get_parent_countries_without_banners_options()
{
    $valuePairs = array();
    $potentialParents = get_db()->getTable('SuperEightFestivalsCountry')->findPotentialParentCountries();
    foreach ($potentialParents as $potentialParent) {
        if (get_banner_for_country($potentialParent->id) != null) continue;
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

function get_all_countries_by_name_ambiguous($name)
{
    return get_db()->getTable('SuperEightFestivalsCountry')->findBy(array('name' => $name), -1);
}


function add_country($countryName)
{
    $country = new SuperEightFestivalsCountry();
    $country->name = $countryName;
    $country->save();
}


// ============================================================================================================================================================= \\

function get_parent_city_options()
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


/**
 * @param bool $sortByCityName Sort results by city name ascending (A-Z)
 * @param bool $sortByCountryName Sort results by country name ascending (A-Z)
 * @return array Resulting array of cities
 */
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

/**
 * @param int $countryID ID of the country to fetch cities from
 * @param bool $sortByCityName Sort results by city name ascending (A-Z)
 * @param bool $sortByCountryName Sort results by country name ascending (A-Z)
 * @return array Resulting array of cities
 */
function get_all_cities_in_country($countryID, $sortByCityName = false, $sortByCountryName = false)
{
    $cities = get_all_cities($sortByCityName, $sortByCountryName);
    return array_filter($cities, function ($city) use ($countryID) {
        return $city->country_id === $countryID;
    });
}

/**
 * @param int $countryID ID of the country to fetch the city from
 * @param string $cityName The name of the city
 * @return SuperEightFestivalsCity|null Resulting city which matches the country and name, or null if none
 */
function get_city_by_name($countryID, $cityName)
{
    $results = get_db()->getTable('SuperEightFestivalsCity')->findBy(array('country_id' => $countryID, 'name' => $cityName), 1);
    if (count($results) > 0) return $results[0];
    return null;
}

function get_city_by_name_ambiguous($cityName)
{
    $results = get_db()->getTable('SuperEightFestivalsCity')->findBy(array('name' => $cityName), 1);
    if (count($results) > 0) return $results[0];
    return null;
}


function get_all_cities_by_name_ambiguous($cityName)
{
    return get_db()->getTable('SuperEightFestivalsCity')->findBy(array('name' => $cityName), -1);
}

function get_city_by_id($cityID)
{
    return get_db()->getTable('SuperEightFestivalsCity')->find($cityID);
}

function add_city_by_country_name($countryName, $name, $latitude, $longitude)
{
    $city = new SuperEightFestivalsCity();
    $city->name = $name;
    $city->latitude = $latitude;
    $city->longitude = $longitude;
    $city->country_id = get_country_by_name($countryName)->id;
    $city->save();
}

function add_city_by_country_id($countryID, $name, $latitude, $longitude)
{
    $city = new SuperEightFestivalsCity();
    $city->name = $name;
    $city->latitude = $latitude;
    $city->longitude = $longitude;
    $city->country_id = $countryID;
    $city->save();
}

// ============================================================================================================================================================= \\

function get_banner_for_country($countryID)
{
    $results = get_db()->getTable('SuperEightFestivalsCountryBanner')->findBy(array('country_id' => $countryID), 1);
    if (count($results) > 0) return $results[0];
    return null;
}

function add_banner_for_country_by_id($countryID, $path, $thumbnail)
{
    $banner = new SuperEightFestivalsCountryBanner();
    $banner->country_id = $countryID;
    $banner->path = $path;
    $banner->thumbnail = $thumbnail;
    $banner->save();
}

function add_banner_for_country_by_name($countryName, $path, $thumbnail)
{
    add_banner_for_country_by_id(get_country_by_name($countryName)->id, $path, $thumbnail);
}


// ============================================================================================================================================================= \\

function get_all_records_for_country($countryID, $recordType)
{
    $cities = get_all_cities_in_country($countryID);
    $results = array();
    foreach ($cities as $city) {
        $media = get_db()->getTable($recordType)->findBy(array('city_id' => $city->id));
        $results = array_merge($results, $media);
    }
    return $results;
}

// ============================================================================================================================================================= \\

function get_all_posters_for_country($countryID)
{
    return get_all_records_for_country($countryID, "SuperEightFestivalsFestivalPoster");
}

function add_poster_for_city_by_id($cityID, $title, $description, $path, $thumbnail)
{
    $poster = new SuperEightFestivalsFestivalPoster();
    $poster->city_id = $cityID;
    $poster->title = $title;
    $poster->description = $description;
    $poster->path = $path;
    $poster->thumbnail = $thumbnail;
    $poster->save();
}

function add_poster_for_city_by_name($countryID, $cityName, $title, $description, $path, $thumbnail)
{
    $cityID = get_city_by_name($countryID, $cityName)->id;
    add_poster_for_city_by_id($cityID, $title, $description, $path, $thumbnail);
}

function add_poster_for_city_by_name_and_country_by_name($countryName, $cityName, $title, $description, $path, $thumbnail)
{
    $countryID = get_country_by_name($countryName)->id;
    $cityID = get_city_by_name($countryID, $cityName)->id;
    add_poster_for_city_by_id($cityID, $title, $description, $path, $thumbnail);
}

// ============================================================================================================================================================= \\

function get_all_photos_for_country($countryID)
{
    return get_all_records_for_country($countryID, "SuperEightFestivalsFestivalPhoto");
}

function add_photo_for_city_by_id($cityID, $title, $description, $path, $thumbnail)
{
    $poster = new SuperEightFestivalsFestivalPhoto();
    $poster->city_id = $cityID;
    $poster->title = $title;
    $poster->description = $description;
    $poster->path = $path;
    $poster->thumbnail = $thumbnail;
    $poster->save();
}

function add_photo_for_city_by_name($countryID, $cityName, $title, $description, $path, $thumbnail)
{
    $cityID = get_city_by_name($countryID, $cityName)->id;
    add_photo_for_city_by_id($cityID, $title, $description, $path, $thumbnail);
}

function add_photo_for_city_by_name_and_country_by_name($countryName, $cityName, $title, $description, $path, $thumbnail)
{
    $countryID = get_country_by_name($countryName)->id;
    $cityID = get_city_by_name($countryID, $cityName)->id;
    add_photo_for_city_by_id($cityID, $title, $description, $path, $thumbnail);
}

// ============================================================================================================================================================= \\

function get_all_print_media_for_country($countryID)
{
    return get_all_records_for_country($countryID, "SuperEightFestivalsFestivalPrintMedia");
}

// ============================================================================================================================================================= \\

function get_all_memorabilia_for_country($countryID)
{
    return get_all_records_for_country($countryID, "SuperEightFestivalsFestivalMemorabilia");
}

// ============================================================================================================================================================= \\

function get_all_films_for_country($countryID)
{
    return get_all_records_for_country($countryID, "SuperEightFestivalsFestivalFilm");
}

// ============================================================================================================================================================= \\

function get_all_filmmakers_for_country($countryID)
{
    return get_all_records_for_country($countryID, "SuperEightFestivalsFestivalFilmmaker");
}

// ============================================================================================================================================================= \\

function get_all_contribution_types()
{
    return get_db()->getTable('SuperEightFestivalsContributionType')->findAll();
}

// ============================================================================================================================================================= \\

function get_all_pages()
{
    return get_db()->getTable('SuperEightFestivalsPage')->findAll();
}

function get_all_pages_by_title_ambiguous($title)
{
    return get_db()->getTable('SuperEightFestivalsPage')->findBy(array('title' => $title), -1);
}

function get_page_by_url($url)
{
    $results = get_db()->getTable('SuperEightFestivalsPage')->findBy(array('url' => $url), 1);
    if (count($results) > 0) return $results[0];
    return null;
}


function add_page($title, $url, $content)
{
    $page = new SuperEightFestivalsPage();
    $page->title = $title;
    $page->url = $url;
    $page->content = $content;
    $page->save();
}

