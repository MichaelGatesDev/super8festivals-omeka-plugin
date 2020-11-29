<?php

function get_request_param_by_id($request, $clazz, $param_name)
{
    $id = $request->getParam($param_name);
    $result = $clazz::get_by_id($id);

    if (!$result) {
        throw new Exception("No such {$clazz} exists with that ID: {$id}");
    }
    return $result;
}

function get_request_param_country($request): SuperEightFestivalsCountry
{
    $country_param = $request->getParam("country");

    if (is_numeric($country_param)) return get_request_param_by_id($request, SuperEightFestivalsCountry::class, "country");

    $country = SuperEightFestivalsCountry::get_by_name($country_param);
    if (!$country) {
        throw new Exception("No country exists with that name/ID: {$country_param}");
    }
    return $country;
}

function get_request_param_city($request): SuperEightFestivalsCity
{
    $city_param = $request->getParam("city");

    if (is_numeric($city_param)) return get_request_param_by_id($request, SuperEightFestivalsCity::class, "city");

    $city = SuperEightFestivalsCity::get_by_name($city_param);
    if (!$city) {
        throw new Exception("No city exists with that name/ID: {$city_param}");
    }
    return $city;
}