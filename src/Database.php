<?php

namespace AuthPackage;

use AuthPackage\Logger;

class Database
{
    private $host = 'localhost';
    private $dbname = 'lms';
    private $username = 'root';
    private $password = '';
    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {

        try {
            $this->connection = new \mysqli($this->host, $this->username, $this->password, $this->dbname);
            if ($this->connection->connect_error) {
                throw new \Exception("Connection failed: " . $this->connection->connect_error);
            }
        } catch (\Throwable $error) {
            Logger::error('Database Connection Failed | ' . $error->getMessage(), __FILE__, __LINE__);
            // die("Database connection failed. Please try again later.");
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
