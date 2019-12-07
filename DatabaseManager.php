<?php

class DatabaseManager
{
    private $PREFIX = "omeka_super_eight_festivals_";

    /**
     * @var string The IP of the server
     */
    private $serverName = "localhost";
    /**
     * @var string The username to connect with
     */
    private $username = "username";
    /**
     * @var string The password to connect with
     */
    private $password = "password";

    /**
     * @var string The name of the database to use
     */
    private $databaseName = "example_db";

    /**
     * @var mysqli|null The connection to the database
     */
    private $connection = null;

    public function __construct()
    {
        $ini_array = parse_ini_file(__DIR__ . "/../../db.ini", true);
        $db = $ini_array["database"];
        $this->PREFIX = $db["prefix"] . "super_eight_festivals_";
        $this->serverName = $db["host"];
        $this->username = $db["username"];
        $this->password = $db["password"];
        $this->databaseName = $db["dbname"];
        $this->initialize();
    }

    public function initialize()
    {
        if ($this->connection != null) {
            $this->connection->close();
        }

        $this->connection = new mysqli($this->serverName, $this->username, $this->password, $this->databaseName);
        // Check connection
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function executeFile($path)
    {
        $commands = file_get_contents($path);
        $commands = str_replace("%PREFIX%", $this->PREFIX, $commands);
        return $this->connection->multi_query($commands);
    }

    public function executeSingleQueryFile($path)
    {
        $command = file_get_contents($path);
        $command = str_replace("%PREFIX%", $this->PREFIX, $command);
        return $this->connection->query($command);
    }

    public function query($query)
    {
        $query = str_replace("%PREFIX%", $this->PREFIX, $query);
        return $this->connection->query($query);
    }


}