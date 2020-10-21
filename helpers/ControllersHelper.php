<?php

function get_request_param_by_id($request, $clazz, $param_name)
{
    $id = $request->getParam($param_name);
    $result = $clazz::get_by_id($id);

    if (!$result) {
        throw new Omeka_Controller_Exception_404("No such ${clazz} exists with that ID: '${$id}'.");
    }
    return $result;
}

function get_request_param_country($request): SuperEightFestivalsCountry
{
    $country_param = $request->getParam('country');
    $country = is_numeric($country_param) ? SuperEightFestivalsCountry::get_by_id($country_param) : SuperEightFestivalsCountry::get_by_name($country_param);
    if (!$country) {
        throw new Omeka_Controller_Exception_404("No country exists with that name/ID: '${$country_param}'.");
    }
    return $country;
}

function get_request_param_city($request): SuperEightFestivalsCity
{
    $city_param = $request->getParam('city');
    $city = is_numeric($city_param) ? SuperEightFestivalsCity::get_by_id($city_param) : SuperEightFestivalsCity::get_by_name($city_param);
    if (!$city) {
        throw new Omeka_Controller_Exception_404("No city exists with that name/ID: '${city_param}'.");
    }
    return $city;
}