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

// ============================================================================================================================================================= \\

interface Super8FestivalsRecordType
{
    const City = 0;
    const CityBanner = 1;
    const Contributor = 2;
    const Country = 3;
    const CountryBanner = 4;
    const Festival = 5;
    const FestivalFilm = 6;
    const FestivalFilmCatalog = 7;
    const FestivalFilmmaker = 8;
    const FestivalMemorabilia = 9;
    const FestivalPhoto = 10;
    const FestivalPoster = 11;
    const FestivalPrintMedia = 12;
    const Page = 13;
}

function get_festival_records_by_type($festivalID, $recordType)
{
    switch ($recordType) {
        case Super8FestivalsRecordType::FestivalFilm:
            return get_all_films_for_festival($festivalID);
        case Super8FestivalsRecordType::FestivalFilmCatalog:
            return get_all_film_catalogs_for_festival($festivalID);
        case Super8FestivalsRecordType::FestivalFilmmaker:
            return get_all_filmmakers_for_festival($festivalID);
        case Super8FestivalsRecordType::FestivalMemorabilia:
            return get_all_memorabilia_for_festival($festivalID);
        case Super8FestivalsRecordType::FestivalPhoto:
            return get_all_photos_for_festival($festivalID);
        case Super8FestivalsRecordType::FestivalPoster:
            return get_all_posters_for_festival($festivalID);
        case Super8FestivalsRecordType::FestivalPrintMedia:
            return get_all_print_media_for_festival($festivalID);
    }
}

// ============================================================================================================================================================= \\

function get_all_federation_newsletters(): array
{
    return get_db()->getTable("SuperEightFestivalsFederationNewsletter")->findAll();
}

function get_federation_newsletter_by_id($newsletterID): ?SuperEightFestivalsFederationNewsletter
{
    return get_db()->getTable('SuperEightFestivalsFederationNewsletter')->find($newsletterID);
}

function get_all_federation_photos(): array
{
    return get_db()->getTable("SuperEightFestivalsFederationPhoto")->findAll();
}

function get_federation_photo_by_id($photoID): ?SuperEightFestivalsFederationPhoto
{
    return get_db()->getTable('SuperEightFestivalsFederationPhoto')->find($photoID);
}

function get_all_federation_magazines(): array
{
    return get_db()->getTable("SuperEightFestivalsFederationMagazine")->findAll();
}

function get_federation_magazine_by_id($magazineID): ?SuperEightFestivalsFederationMagazine
{
    return get_db()->getTable('SuperEightFestivalsFederationMagazine')->find($magazineID);
}

function get_all_federation_bylaws(): array
{
    return get_db()->getTable("SuperEightFestivalsFederationBylaw")->findAll();
}

function get_federation_bylaw_by_id($bylawID): ?SuperEightFestivalsFederationBylaw
{
    return get_db()->getTable('SuperEightFestivalsFederationBylaw')->find($bylawID);
}

// ============================================================================================================================================================= \\

function get_all_countries(): array
{
    return get_db()->getTable("SuperEightFestivalsCountry")->findAll();
}

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

function get_country_by_id($countryID): ?SuperEightFestivalsCountry
{
    return get_db()->getTable('SuperEightFestivalsCountry')->find($countryID);
}

function get_country_by_name($countryName): ?SuperEightFestivalsCountry
{
    $results = get_db()->getTable('SuperEightFestivalsCountry')->findBy(array('name' => strtolower($countryName)), 1);
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


function add_country($countryName, $lat = 0, $long = 0): ?SuperEightFestivalsCountry
{
    $country = new SuperEightFestivalsCountry();
    $country->name = $countryName;
    $country->latitude = $lat;
    $country->longitude = $long;
    try {
        $country->save();
        return $country;
    } catch (Omeka_Record_Exception $e) {
        return null;
    } catch (Omeka_Validate_Exception $e) {
        return null;
    }
}

function add_countries_by_names(array $countryNames): void
{
    foreach ($countryNames as $countryName) {
        add_country($countryName);
    }
}

function delete_country_records($country_id)
{
    $cities = get_all_cities_in_country($country_id);
    foreach ($cities as $city) {
        delete_city_records($city);
        $city->delete();
    }
}

// ============================================================================================================================================================= \\

function get_all_city_banners(): array
{
    return get_db()->getTable("SuperEightFestivalsCityBanner")->findAll();
}

function get_city_banner($cityID): ?SuperEightFestivalsCityBanner
{
    $results = get_db()->getTable('SuperEightFestivalsCityBanner')->findBy(array('city_id' => $cityID), 1);
    return count($results) > 0 ? $results[0] : null;
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
    $results[0] = "Select...";
    $potentialParents = get_db()->getTable('SuperEightFestivalsCity')->findAll();
    foreach ($potentialParents as $potentialParent) {
        $results[$potentialParent->id] = $potentialParent->name;
    }
    return $results;
}

function get_city_by_name($countryID, $cityName): ?SuperEightFestivalsCity
{
    $results = get_db()->getTable('SuperEightFestivalsCity')->findBy(array('country_id' => $countryID, 'name' => $cityName), 1);
    return count($results) > 0 ? $results[0] : null;
}

function get_city_by_name_ambiguous($cityName): ?SuperEightFestivalsCity
{
    $results = get_db()->getTable('SuperEightFestivalsCity')->findBy(array('name' => $cityName), 1);
    return count($results) > 0 ? $results[0] : null;
}

function get_city_by_id($cityID): ?SuperEightFestivalsCity
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
    return $city;
}

function add_city_by_country_name($countryName, $name, $latitude, $longitude)
{
    return add_city(get_country_by_name($countryName)->id, $name, $latitude, $longitude);
}

function delete_city_records($city_id)
{
    // banner
    $banner = get_city_banner($city_id);
    if ($banner != null) $banner->delete();

    // festivals
    $festivals = get_all_festivals_in_city($city_id);
    foreach ($festivals as $festival) {
        delete_festival_records($festival);
        $festival->delete();
    }
}

// ============================================================================================================================================================= \\

function get_all_festivals(): array
{
    return get_db()->getTable("SuperEightFestivalsFestival")->findAll();
}

function get_all_festivals_in_country($countryID): array
{
    $results = array();
    $cities = get_all_cities_in_country($countryID);
    foreach ($cities as $city) {
        $festivals = get_all_festivals_in_city($city->id);
        $results = array_merge($results, $festivals);
    }
    return $results;
}

function get_all_festivals_in_city($cityID): array
{
    return get_db()->getTable('SuperEightFestivalsFestival')->findBy(array('city_id' => $cityID), -1);
}

function get_default_festival_for_city($cityID): ?SuperEightFestivalsFestival
{
    $results = get_db()->getTable('SuperEightFestivalsFestival')->findBy(array('city_id' => $cityID, 'year' => -1), 1);
    return count($results) > 0 ? $results[0] : null;
}

function get_festival_by_id($festivalID): ?SuperEightFestivalsFestival
{
    return get_db()->getTable('SuperEightFestivalsFestival')->find($festivalID);
}

function get_parent_festival_options(): array
{
    $results = array();
    $results[0] = "Select...";
    $festivals = get_all_festivals();
    foreach ($festivals as $festival) {
        $results[$festival->id] = $festival->get_title();
    }
    return $results;
}

function add_festival($city_id, $year, $title = null, $description = null): ?SuperEightFestivalsFestival
{
    $festival = new SuperEightFestivalsFestival();
    $festival->city_id = $city_id;
    $festival->year = $year;
    $festival->title = $title;
    $festival->description = $description;
    $festival->save();
    return $festival;
}

function delete_festival_records($festival_id)
{
    $films = get_all_films_for_festival($festival_id);
    foreach ($films as $record) $record->delete();
    $film_catalogs = get_all_film_catalogs_for_festival($festival_id);
    foreach ($film_catalogs as $record) $record->delete();
    $filmmakers = get_all_filmmakers_for_festival($festival_id);
    foreach ($filmmakers as $record) $record->delete();
    $memorabilia = get_all_memorabilia_for_festival($festival_id);
    foreach ($memorabilia as $record) $record->delete();
    $photos = get_all_photos_for_festival($festival_id);
    foreach ($photos as $record) $record->delete();
    $posters = get_all_posters_for_festival($festival_id);
    foreach ($posters as $record) $record->delete();
    $print_media = get_all_print_media_for_festival($festival_id);
    foreach ($print_media as $record) $record->delete();
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

function get_all_film_catalogs_for_city($id): array
{
    $result = array();
    $festivals = get_all_festivals_in_city($id);
    foreach ($festivals as $festival) {
        $catalogs = get_all_film_catalogs_for_festival($festival->id);
        $result = array_merge($result, $catalogs);
    }
    return $result;
}

function get_film_catalog_by_id($id): ?SuperEightFestivalsFestivalFilmCatalog
{
    return get_db()->getTable('SuperEightFestivalsFestivalFilmCatalog')->find($id);
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

function get_all_filmmakers_for_city($id): array
{
    $result = array();
    $festivals = get_all_festivals_in_city($id);
    foreach ($festivals as $festival) {
        $filmmakers = get_all_filmmakers_for_festival($festival->id);
        $result = array_merge($result, $filmmakers);
    }
    return $result;
}

function get_parent_filmmaker_options(): array
{
    $results = array();
    $results[0] = "Select...";
    $potentialParents = get_db()->getTable('SuperEightFestivalsFestivalFilmmaker')->findAll();
    foreach ($potentialParents as $potentialParent) {
        $results[$potentialParent->id] = $potentialParent->get_display_name();
    }
    return $results;
}

function get_filmmaker_by_id($id): ?SuperEightFestivalsFestivalFilmmaker
{
    return get_db()->getTable('SuperEightFestivalsFestivalFilmmaker')->find($id);
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

function get_all_films_for_city($id): array
{
    $result = array();
    $festivals = get_all_festivals_in_city($id);
    foreach ($festivals as $festival) {
        $catalogs = get_all_films_for_festival($festival->id);
        $result = array_merge($result, $catalogs);
    }
    return $result;
}

function get_film_by_id($id): ?SuperEightFestivalsFestivalFilm
{
    return get_db()->getTable('SuperEightFestivalsFestivalFilm')->find($id);
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

function get_all_memorabilia_for_city($id): array
{
    $result = array();
    $festivals = get_all_festivals_in_city($id);
    foreach ($festivals as $festival) {
        $catalogs = get_all_memorabilia_for_festival($festival->id);
        $result = array_merge($result, $catalogs);
    }
    return $result;
}

function get_memorabilia_by_id($id): ?SuperEightFestivalsFestivalMemorabilia
{
    return get_db()->getTable('SuperEightFestivalsFestivalMemorabilia')->find($id);
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

function get_all_print_media_for_city($id): array
{
    $result = array();
    $festivals = get_all_festivals_in_city($id);
    foreach ($festivals as $festival) {
        $catalogs = get_all_print_media_for_festival($festival->id);
        $result = array_merge($result, $catalogs);
    }
    return $result;
}

function get_print_media_by_id($id): ?SuperEightFestivalsFestivalPrintMedia
{
    return get_db()->getTable('SuperEightFestivalsFestivalPrintMedia')->find($id);
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

function get_all_photos_for_city($id): array
{
    $result = array();
    $festivals = get_all_festivals_in_city($id);
    foreach ($festivals as $festival) {
        $catalogs = get_all_photos_for_festival($festival->id);
        $result = array_merge($result, $catalogs);
    }
    return $result;
}

function get_photo_by_id($id): ?SuperEightFestivalsFestivalPhoto
{
    return get_db()->getTable('SuperEightFestivalsFestivalPhoto')->find($id);
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

function get_all_posters_for_city($id): array
{
    $result = array();
    $festivals = get_all_festivals_in_city($id);
    foreach ($festivals as $festival) {
        $catalogs = get_all_posters_for_festival($festival->id);
        $result = array_merge($result, $catalogs);
    }
    return $result;
}

function get_poster_by_id($id): ?SuperEightFestivalsFestivalPoster
{
    return get_db()->getTable('SuperEightFestivalsFestivalPoster')->find($id);
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
    $results[0] = "Select...";
    $potentialParents = get_db()->getTable('SuperEightFestivalsContributor')->findAll();
    foreach ($potentialParents as $potentialParent) {
        $results[$potentialParent->id] = $potentialParent->get_display_name();
    }
    return $results;
}

function get_all_contributors(): array
{
    return get_db()->getTable("SuperEightFestivalsContributor")->findAll();
}

function get_contributor_by_id($id): ?SuperEightFestivalsContributor
{
    return get_db()->getTable('SuperEightFestivalsContributor')->find($id);
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

function get_all_contribution_types()
{
    return array(
        array("name" => "Festival Film", "value" => Super8FestivalsRecordType::FestivalFilm),
        array("name" => "Festival Film Catalog", "value" => Super8FestivalsRecordType::FestivalFilmCatalog),
        array("name" => "Festival Filmmaker", "value" => Super8FestivalsRecordType::FestivalFilmmaker),
        array("name" => "Festival Memorabilia", "value" => Super8FestivalsRecordType::FestivalMemorabilia),
        array("name" => "Festival Photo", "value" => Super8FestivalsRecordType::FestivalPhoto),
        array("name" => "Festival Poster", "value" => Super8FestivalsRecordType::FestivalPoster),
        array("name" => "Festival Print Media", "value" => Super8FestivalsRecordType::FestivalPrintMedia),
    );
}

// ============================================================================================================================================================= \\

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
