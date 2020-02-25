<?php

// ============================================================================================================================================================= \\

function get_all_countries(): array
{
    return get_db()->getTable("SuperEightFestivalsCountry")->findAll();
}

function get_parent_country_options()
{
    $results = array();
    $potentialParents = get_db()->getTable('SuperEightFestivalsCountry')->findPotentialParentCountries();
    foreach ($potentialParents as $potentialParent) {
        if (trim($potentialParent->name) != '') {
            $results[$potentialParent->id] = $potentialParent->name;
        }
    }
    return $results;
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

function get_all_countries_by_name_ambiguous($name, $partial = false)
{
    if ($partial) {
        $partialResults = array();
        $allCountries = get_all_countries();
        $split = explode(" ", $name);
        foreach ($split as $word) {
            foreach ($allCountries as $country) {
                if (strpos($country->name, $word) !== false) {
                    array_push($partialResults, $country);
                }
            }
        }
        return $partialResults;
    }
    return get_db()->getTable('SuperEightFestivalsCountry')->findBy(array('name' => $name), -1);
}


function add_country($countryName, $lat = 0, $long = 0)
{
    $country = new SuperEightFestivalsCountry();
    $country->name = $countryName;
    $country->latitude = $lat;
    $country->longitude = $long;
    $country->save();
}

function add_countries_by_names(array $countryNames)
{
    foreach ($countryNames as $countryName) {
        add_country($countryName);
    }
}

// ============================================================================================================================================================= \\

function get_all_cities(): array
{
    return get_db()->getTable("SuperEightFestivalsCity")->findAll();
}

function get_all_cities_in_country($countryID): array
{
    return get_db()->getTable('SuperEightFestivalsCity')->findBy(array('country_id' => $countryID), -1);
}

function get_parent_city_options(): array
{
    $results = array();
    $potentialParents = get_db()->getTable('SuperEightFestivalsCity')->findPotentialParentCities();
    foreach ($potentialParents as $potentialParent) {
        if (trim($potentialParent->name) != '') {
            $results[$potentialParent->id] = $potentialParent->name;
        }
    }
    return $results;
}

function get_city_by_name($countryID, $cityName): SuperEightFestivalsCity
{
    $results = get_db()->getTable('SuperEightFestivalsCity')->findBy(array('country_id' => $countryID, 'name' => $cityName), 1);
    if (count($results) > 0) return $results[0];
    return null;
}

function get_city_by_name_ambiguous($cityName): SuperEightFestivalsCity
{
    $results = get_db()->getTable('SuperEightFestivalsCity')->findBy(array('name' => $cityName), 1);
    if (count($results) > 0) return $results[0];
    return null;
}


function get_city_by_id($cityID): SuperEightFestivalsCity
{
    return get_db()->getTable('SuperEightFestivalsCity')->find($cityID);
}


function get_all_cities_by_name_ambiguous($cityName, $partial = false): array
{
    if ($partial) {
        $partialResults = array();
        $allCities = get_all_cities();
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

function get_all_festivals(): array
{
    return get_db()->getTable("SuperEightFestivalsFestival")->findAll();
}

function get_all_festivals_in_city($cityID): array
{
    return get_db()->getTable('SuperEightFestivalsFestival')->findBy(array('city_id' => $cityID), -1);
}


function get_parent_festival_options(): array
{
    $results = array();
    $potentialParents = get_db()->getTable('SuperEightFestivalsFestival')->findPotentialParentFestivals();
    foreach ($potentialParents as $potentialParent) {
        $results[$potentialParent->id] = $potentialParent->getDisplayName();
    }
    return $results;
}


function get_all_festivals_in_year($year): array
{
    return get_db()->getTable('SuperEightFestivalsFestival')->findBy(array('year' => $year), -1);
}

function get_all_festivals_in_city_and_year($cityID, $year): array
{
    return get_db()->getTable('SuperEightFestivalsFestival')->findBy(array('city_id' => $cityID, 'year' => $year), -1);
}

function get_festival_by_id($id): SuperEightFestivalsFestival
{
    return get_db()->getTable('SuperEightFestivalsFestival')->find($id);
}

// ============================================================================================================================================================= \\

function get_all_filmmakers(): array
{
    return get_db()->getTable("SuperEightFestivalsFestivalFilmmaker")->findAll();
}

function get_all_filmmakers_for_festival($id): array
{
    return get_db()->getTable('SuperEightFestivalsFestivalFilmmaker')->findBy(array('festival_id' => $id), -1);
}

// ============================================================================================================================================================= \\

function get_banner_for_country($countryID): SuperEightFestivalsCountryBanner
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

function get_all_pages_by_title_ambiguous($title, $partial = false)
{
    if ($partial) {
        $partialResults = array();
        $allPages = get_all_pages();
        $split = explode(" ", $title);
        foreach ($split as $word) {
            foreach ($allPages as $page) {
                if (strpos(strtolower($page->title), strtolower($word)) !== false) {
                    array_push($partialResults, $page);
                }
            }
        }
        return $partialResults;
    }
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

