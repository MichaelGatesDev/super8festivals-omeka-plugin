<?php

// ============================================================================================================================================================= \\

function get_root_dir()
{
    return $_SERVER['DOCUMENT_ROOT'];
}

function get_files_dir($fullPath = true)
{
    return ($fullPath ? get_root_dir() : "") . "/files/original";
}

function delete_file($fileName)
{
    unlink(get_files_dir() . "/" . $fileName);
}

// ============================================================================================================================================================= \\

function get_all_countries(): array
{
    return get_db()->getTable("SuperEightFestivalsCountry")->findAll();
}

function get_parent_country_options(): array
{
    $results = array();
    $potentialParents = get_db()->getTable('SuperEightFestivalsCountry')->findAll();
    foreach ($potentialParents as $potentialParent) {
        if (trim($potentialParent->name) != '') {
            $results[$potentialParent->id] = $potentialParent->name;
        }
    }
    return $results;
}

function get_country_by_id($countryID): ?SuperEightFestivalsCountry
{
    return get_db()->getTable('SuperEightFestivalsCountry')->find($countryID);
}

function get_country_by_name($countryName): ?SuperEightFestivalsCountry
{
    $results = get_db()->getTable('SuperEightFestivalsCountry')->findBy(array('name' => $countryName), 1);
    return count($results) > 0 ? $results[0] : null;
}

function get_all_countries_by_name_ambiguous($name, $partial = false): array
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


function add_country($countryName, $lat = 0, $long = 0): void
{
    $country = new SuperEightFestivalsCountry();
    $country->name = $countryName;
    $country->latitude = $lat;
    $country->longitude = $long;
    $country->save();
}

function add_countries_by_names(array $countryNames): void
{
    foreach ($countryNames as $countryName) {
        add_country($countryName);
    }
}

// ============================================================================================================================================================= \\

function get_all_country_banners(): array
{
    return get_db()->getTable("SuperEightFestivalsCountryBanner")->findAll();
}

function get_banner_for_country($countryID): ?SuperEightFestivalsCountryBanner
{
    $results = get_db()->getTable('SuperEightFestivalsCountryBanner')->findBy(array('country_id' => $countryID), 1);
    return count($results) > 0 ? $results[0] : null;
}

function get_banner_by_id($bannerID): ?SuperEightFestivalsCountryBanner
{
    return get_db()->getTable('SuperEightFestivalsCountryBanner')->find($bannerID);
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
    $potentialParents = get_db()->getTable('SuperEightFestivalsCity')->findAll();
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
    return count($results) > 0 ? $results[0] : null;
}

function get_city_by_name_ambiguous($cityName): SuperEightFestivalsCity
{
    $results = get_db()->getTable('SuperEightFestivalsCity')->findBy(array('name' => $cityName), 1);
    return count($results) > 0 ? $results[0] : null;
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

function add_city($countryID, $name, $latitude, $longitude)
{
    $city = new SuperEightFestivalsCity();
    $city->name = $name;
    $city->latitude = $latitude;
    $city->longitude = $longitude;
    $city->country_id = $countryID;
    $city->save();

    add_festival($city->id, -1, "$name default festival", "this is the default festival for $name");
}

function add_city_by_country_name($countryName, $name, $latitude, $longitude)
{
    add_city(get_country_by_name($countryName)->id, $name, $latitude, $longitude);
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
    $potentialParents = get_db()->getTable('SuperEightFestivalsFestival')->findAll();
    foreach ($potentialParents as $potentialParent) {
        $results[$potentialParent->id] = $potentialParent->getDisplayName();
    }
    return $results;
}

function add_festival($city_id, $year, $title, $description)
{
    $festival = new SuperEightFestivalsFestival();
    $festival->city_id = $city_id;
    $festival->year = $year;
    $festival->title = $title;
    $festival->description = $description;
    $festival->save();
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

function get_parent_filmmaker_options(): array
{
    $results = array();
    $potentialParents = get_db()->getTable('SuperEightFestivalsFestivalFilmmaker')->findAll();
    foreach ($potentialParents as $potentialParent) {
        $results[$potentialParent->id] = $potentialParent->email;
    }
    return $results;
}


// ============================================================================================================================================================= \\

function get_all_films(): array
{
    return get_db()->getTable("SuperEightFestivalsFestivalFilm")->findAll();
}

function get_all_films_for_festival($id): array
{
    return get_db()->getTable('SuperEightFestivalsFestivalFilm')->findBy(array('festival_id' => $id), -1);
}

// ============================================================================================================================================================= \\

function get_all_film_catalogs(): array
{
    return get_db()->getTable("SuperEightFestivalsFestivalFilmCatalog")->findAll();
}

function get_all_film_catalogs_for_festival($id): array
{
    return get_db()->getTable('SuperEightFestivalsFestivalFilmCatalog')->findBy(array('festival_id' => $id), -1);
}

// ============================================================================================================================================================= \\

function get_all_memorabilia(): array
{
    return get_db()->getTable("SuperEightFestivalsFestivalMemorabilia")->findAll();
}

function get_all_memorabilia_for_festival($id): array
{
    return get_db()->getTable('SuperEightFestivalsFestivalMemorabilia')->findBy(array('festival_id' => $id), -1);
}

// ============================================================================================================================================================= \\

function get_all_print_media(): array
{
    return get_db()->getTable("SuperEightFestivalsFestivalPrintMedia")->findAll();
}

function get_all_print_media_for_festival($id): array
{
    return get_db()->getTable('SuperEightFestivalsFestivalPrintMedia')->findBy(array('festival_id' => $id), -1);
}

// ============================================================================================================================================================= \\

function get_all_photos(): array
{
    return get_db()->getTable("SuperEightFestivalsFestivalPhoto")->findAll();
}

function get_all_photos_for_festival($id): array
{
    return get_db()->getTable('SuperEightFestivalsFestivalPhoto')->findBy(array('festival_id' => $id), -1);
}

function add_photo($festivalID, $contributorID, $title, $description, $thumbnailPathFile, $thumbnailPathWeb, $pathFile, $pathWeb, $width, $height)
{
    try {
        $poster = new SuperEightFestivalsFestivalPhoto(
            $festivalID,
            $contributorID,
            $title,
            $description,
            $thumbnailPathFile,
            $thumbnailPathWeb,
            $pathFile,
            $pathWeb,
            $width,
            $height
        );
        $poster->save();
    } catch (Omeka_Record_Exception $e) {
    }
}

// ============================================================================================================================================================= \\

function get_all_posters(): array
{
    return get_db()->getTable("SuperEightFestivalsFestivalPoster")->findAll();
}

function get_all_posters_for_festival($id): array
{
    return get_db()->getTable('SuperEightFestivalsFestivalPoster')->findBy(array('festival_id' => $id), -1);
}

function add_poster($festivalID, $contributorID, $title, $description, $thumbnailPathFile, $thumbnailPathWeb, $pathFile, $pathWeb, $width, $height)
{
    try {
        $poster = new SuperEightFestivalsFestivalPoster(
            $festivalID,
            $contributorID,
            $title,
            $description,
            $thumbnailPathFile,
            $thumbnailPathWeb,
            $pathFile,
            $pathWeb,
            $width,
            $height
        );
        $poster->save();
    } catch (Omeka_Record_Exception $e) {
    }
}

// ============================================================================================================================================================= \\

function get_parent_contributor_options(): array
{
    $results = array();
    $potentialParents = get_db()->getTable('SuperEightFestivalsContributor')->findAll();
    foreach ($potentialParents as $potentialParent) {
        $results[$potentialParent->id] = $potentialParent->email;
    }
    return $results;
}

function get_all_contributors(): array
{
    return get_db()->getTable("SuperEightFestivalsContributor")->findAll();
}

function add_contributor(string $first_name, string $last_name, string $organization_name, string $email)
{
    $contributor = new SuperEightFestivalsContributor();
    $contributor->first_name = $first_name;
    $contributor->last_name = $last_name;
    $contributor->organization_name = $organization_name;
    $contributor->email = $email;
    $contributor->save();
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
    return count($results) > 0 ? $results[0] : null;
}


function add_page($title, $url, $content)
{
    $page = new SuperEightFestivalsPage();
    $page->title = $title;
    $page->url = $url;
    $page->content = $content;
    $page->save();
}

