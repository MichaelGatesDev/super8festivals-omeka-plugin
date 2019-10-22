<?php

class DatabaseManager
{
    const PREFIX = "omeka_super8festivals_";

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

    public function __construct($serverName, $username, $password, $databaseName)
    {
        $this->serverName = $serverName;
        $this->username = $username;
        $this->password = $password;
        $this->databaseName = $databaseName;
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

    public function createTable($name, $cols)
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS `$name` 
        (
            `$cols`
        ) 
        ENGINE = InnoDB
        DEFAULT CHARSET = utf8
        COLLATE = utf8_unicode_ci;
SQL;
        return $this->connection->query($sql);
    }

    public function executeFile($path)
    {
        $commands = file_get_contents($path);
        $commands = str_replace("%PREFIX%", self::PREFIX, $commands);
        return $this->connection->multi_query($commands);
    }

    public function query($query)
    {

    }


}