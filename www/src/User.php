<?php

namespace imed;

use imed\Database;
use Exception;

class User extends Database
{
    private $dbconnection;

    public function __construct()
    {
        parent::__construct();
        $this->dbconnection = parent::getConnection();
    }

    // Display user
    public function getAllUser($userDisplayLevel)
    {
        $errors = array();
        $accounts = array();
        $items =  array();

        // Query to select user
        $queryUser = "
        SELECT  first_name, last_name, email, profession, ins_name, user_image, user_level
        FROM user
        INNER JOIN institution
        ON user.ins_ID = institution.ins_ID
        WHERE user_level = ? ";

        try {
            $statement = $this->dbconnection->prepare($queryUser) or die($this->dbconnection->error);
            $statement->bind_param("i", $userDisplayLevel);

            // Execute query
            if (!$statement->execute()) {
                throw new Exception("Error executing query");
            } else {
                $result = $statement->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($items, $row);
                }
                $accounts["total"] =  count($items);
                $accounts["items"] =  $items;

                return $accounts;
            }
        } catch (Exception $exc) {
            $errors["system"] = $exc->getMessage();
            $accounts["success"] = false;
            $accounts["errors"] = $errors;
        }
        return $accounts;
    }
}