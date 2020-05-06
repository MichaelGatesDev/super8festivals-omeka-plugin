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


    public function create_tables()
    {
        $this->databaseManager->executeFile(__DIR__ . "/procedures/create_tables.sql");
    }

    public function drop_tables()
    {
        $this->databaseManager->executeFile(__DIR__ . "/procedures/drop_tables.sql");
    }
}