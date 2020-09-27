<?php

function get_request_param_country($request)
{
    $country_param = $request->getParam('country');
    $country = is_numeric($country_param) ? SuperEightFestivalsCountry::get_by_id($country_param) : SuperEightFestivalsCountry::get_by_name($country_param);
    if (!$country) {
        throw new Omeka_Controller_Exception_404("No country exists with that name/ID: '${$country_param}'.");
    }
    return $country;
}

function get_request_param_city($request)
{
    $city_param = $request->getParam('city');
    $city = is_numeric($city_param) ? SuperEightFestivalsCity::get_by_id($city_param) : SuperEightFestivalsCity::get_by_name($city_param);
    if (!$city) {
        throw new Omeka_Controller_Exception_404("No city exists with that name/ID: '${city_param}'.");
    }
    return $city;
}

function get_request_param_festival($request)
{
    $festivalID = $request->getParam('festival');
    $festival = SuperEightFestivalsFestival::get_by_id($festivalID);
    if (!$festival) {
        throw new Omeka_Controller_Exception_404("No festival exists with that ID: '${$festivalID}'.");
    }
    return $festival;
}
