<?php

class SuperEightFestivalsFestivalTable extends Omeka_Db_Table
{
    public function findPotentialParentFestivals(): array
    {
        return $this->findAll();
    }
}