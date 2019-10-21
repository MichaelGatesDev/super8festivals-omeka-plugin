<?php

class DatabaseHelper
{
    /**
     * @var DatabaseManager|null
     */
    private $databaseManager;

    public function __construct($databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }


    public function createTables()
    {
        // create tables
        $this->databaseManager->executeFile(__DIR__ . "/procedures/create_tables.sql");
    }

    public function dropTables()
    {
        // drop tables
        $this->databaseManager->executeFile(__DIR__ . "/procedures/drop_tables.sql");
    }
}