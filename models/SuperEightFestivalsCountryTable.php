<?php

class SuperEightFestivalsCountryTable extends Omeka_Db_Table
{

    /**
     * Retrieve child countries from list of countries matching country ID.
     *
     * Matches against the countries parameter against the country ID. Also matches all
     * children for the same to retrieve all children of a country.
     *
     * @param int $parentId The id of the original parent
     * @param array $countries The array of all countries
     * @return array
     */
    public function findChildrenCountries($parentId, $includeAllDescendants = false, $idToCountriesCountryLookup = null, $parentToChildrenLookup = null)
    {
        if ((string)$parentId == '') {
            return array();
        }

        $descendantCountries = array();

        if ($includeAllDescendants) {
            // create the id to country lookup if required
            if (!$idToCountriesCountryLookup) {
                $idToCountriesCountryLookup = $this->_createIdToCountriesCountryLookup();
            }

            // create the parent to children lookup if required
            if (!$parentToChildrenLookup) {
                $parentToChildrenLookup = $this->_createParentToChildrenLookup($idToCountriesCountryLookup);
            }
            // get all of the descendant countries of the parent country
            $childrenCountries = $parentToChildrenLookup[$parentId];
            $descendantCountries = array_merge($descendantCountries, $childrenCountries);
            foreach ($childrenCountries as $childCountriesCountry) {
                if ($allGrandChildren = $this->findChildrenCountries($childCountriesCountry->id, true, $idToCountriesCountryLookup, $parentToChildrenLookup)) {
                    $descendantCountries = array_merge($descendantCountries, $allGrandChildren);
                }
            }
        } else {
            // only include the immediate children
            $descendantCountries = $this->findBy(array('parent_id' => $parentId, 'sort' => 'order'));
        }

        return $descendantCountries;
    }

    protected function _createIdToCountriesCountryLookup()
    {
        // get all of the countries
        // this should eventually be just the id/parent_id pairs for all countries
        $allCountries = $this->findAll();

        // create the country lookup
        $idToCountriesCountryLookup = array();
        foreach ($allCountries as $country) {
            $idToCountriesCountryLookup[$country->id] = $country;
        }

        return $idToCountriesCountryLookup;
    }

    protected function _createParentToChildrenLookup($idToCountriesCountryLookup)
    {
        // create an associative array that maps parent ids to an array of any children's ids
        $parentToChildrenLookup = array();
        $allCountries = array_values($idToCountriesCountryLookup);

        // initialize the children array for all potential parents
        foreach ($allCountries as $country) {
            $parentToChildrenLookup[$country->id] = array();
        }

        // add each child to his parent's array
        foreach ($allCountries as $country) {
            $parentToChildrenLookup[$country->parent_id][] = $country;
        }

        return $parentToChildrenLookup;
    }

    /**
     *  Returns an array of countries that could be a parent for the current country.
     *  This is used to populate a dropdown for selecting a new parent for the current country.
     *  In particluar, a country cannot be a parent of itself, and a country cannot have one of its descendents as a parent.
     *
     * @param integer $countryId The id of the country whose potential parent countries are returned.
     * @return array The potential parent countries.
     */
    public function findPotentialParentCountries($countryId)
    {
        // create a country lookup table for all of the countries
        $idToCountriesCountryLookup = $this->_createIdToCountriesCountryLookup();

        // find all of the country's descendants
        $descendantCountries = $this->findChildrenCountries($countryId, true, $idToCountriesCountryLookup);

        // filter out all of the descendant countries from the lookup table
        $allCountries = array_values($idToCountriesCountryLookup);
        foreach ($descendantCountries as $descendantCountriesCountry) {
            unset($idToCountriesCountryLookup[$descendantCountriesCountry->id]);
        }

        // filter out the country itself from the lookup table
        unset($idToCountriesCountryLookup[$countryId]);
        // return the values of the filtered country lookup table
        return array_values($idToCountriesCountryLookup);
    }

    /**
     * Returns an array of all the ancestor countries of a country.
     *
     * @param integer $countryId The id of the country whose ancestors are returned.
     * @return array The array of ancestor countries.
     */
    public function findAncestorCountries($countryId)
    {
        // set the default ancestor countries to an empty array
        $ancestorCountries = array();

        // create a country lookup table for all of the countries
        $country = $this->find($countryId);
        while ($country && $country->parent_id) {
            if ($country = $this->find($country->parent_id)) {
                $ancestorCountries[] = $country;
            }
        }

        return $ancestorCountries;
    }

    public function getSelect()
    {
        $select = parent::getSelect();
        $permissions = new Omeka_Db_Select_PublicPermissions('SimpleCountries_CountriesCountry');
        $permissions->apply($select, 'simple_countries_countries', 'created_by_user_id', 'is_published');


        return $select;

    }
}