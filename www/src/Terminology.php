<?php

namespace imed;

use imed\Database;
use Exception;


class Terminology extends Database
{
    private $dbconnection;

    // Connect to database
    public function __construct()
    {
        parent::__construct();
        $this->dbconnection = parent::getConnection();
    }

    // Fetch data from Terminolgy table our from database
    public function getTerminology()
    {
        $query = "
        SELECT 
        term_ID,
        description,
        abbreviation
        FROM terminology
        ORDER BY description ASC";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }

            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                $terminologies = array();
                $items =  array();
                $result = $statement->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($items, $row);
                }
                $terminologies["total"] =  count($items);
                $terminologies["items"] =  $items;

                return $terminologies;
            }
            return null;
        } catch (Exception $exception) {
            $errors = array();
            $errors["system"] = $exception->getMessage();
            $notes["errors"] = $errors;
        }
    }
}
