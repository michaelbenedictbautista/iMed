<?php

namespace imed;

use Exception;

// Declaring varibles
class Database
{
    private $username;
    private $password;
    private $database_name;
    private $database_host;
    private $connection;

    // Function to set up the restaurnt class
    protected function __construct()
    {
        $this->username = getenv("dbuser");
        $this->password = getenv("dbpass");
        $this->database_name = getenv("dbname");
        $this->database_host = getenv("dbhost");
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->connection = mysqli_connect(
                $this->database_host,
                $this->username,
                $this->password,
                $this->database_name
            );
        } catch (Exception $ex) {
            // display the exception default from php exeception class message.
            echo $ex->getMessage();
        }
    }

    protected function getConnection()
    {
        return $this->connection;
    }
}