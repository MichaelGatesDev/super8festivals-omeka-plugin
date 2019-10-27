<?php


function get_parent_country_options($city)
{
//    $valuePairs = array('0' => __('(No Country)'));
    $valuePairs = array();
    $potentialParents = get_db()->getTable('SuperEightFestivalsCountry')->findPotentialParentCountries($city->id);
    foreach ($potentialParents as $potentialParent) {
        if (trim($potentialParent->name) != '') {
            $valuePairs[$potentialParent->id] = $potentialParent->name;
        }
    }
    return $valuePairs;
}