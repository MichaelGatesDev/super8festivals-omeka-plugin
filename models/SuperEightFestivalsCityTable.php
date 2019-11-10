<?php

class SuperEightFestivalsCityTable extends Omeka_Db_Table
{
    /**
     *  Returns an array of countries that could be a parent for the current city.
     *  This is used to populate a dropdown for selecting a new parent for the current country.
     *
     * @return array The potential parent countries.
     */
    public function findPotentialParentCities()
    {
        return $this->findAll();
    }
}