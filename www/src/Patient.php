<?php

namespace imed;

use imed\Database;
use Exception;

class Patient extends Database
{

    private $dbconnection;

    // Connect to database
    public function __construct()
    {
        parent::__construct();
        $this->dbconnection = parent::getConnection();
    }

    // Fetch data from Patient table
    public function createPatient($first_name, $last_name, $date_of_birth, $age, $gender, $status, $emergency_response, $allergy, $room, $ins_ID, $user_ID, $patient_image)
    {
        // Declaring variables
        $errors = array();
        $response = array();

        $first_name = trim(strtolower($first_name));
        $last_name = trim(strtolower($last_name));
        $date_of_birth = trim($date_of_birth);
        $age = trim($age);
        $gender = trim(strtolower($gender));
        $status = trim(strtolower($status));
        $emergency_response = trim(strtolower($emergency_response));
        $allergy = trim(strtolower($allergy));
        $room = trim(strtolower($room));


        // Query to insert user
        $queryInsertPatient = "
        INSERT INTO patient (first_name, last_name, date_of_birth, age, gender, status, emergency_response, allergy, room, ins_ID, user_ID, patient_image)
        VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            // Verify database connection and parameters
            $statementPatient = $this->dbconnection->prepare($queryInsertPatient) or die($this->dbconnection->error);
            $statementPatient->bind_param("sssisssssiis", $first_name, $last_name, $date_of_birth, $age, $gender, $status, $emergency_response, $allergy, $room, $ins_ID, $user_ID, $patient_image);

            // Execute query
            if (!$statementPatient->execute()) {
                throw new Exception("Database connection error occured!");
            } else {
                $response["success"] = true;
                $response["message"] = "Account has been created!";
            }
        } catch (Exception $exc) {
            $errors["system"] = $exc->getMessage();
            $response["success"] = false;
            $response["message"] = "Account cannot be created!";
            $response["errors"] = $errors;
        }
        return $response;
    }

    // Fetch data from patient table 
    public function getAllPatients()
    {
        $query = "
        SELECT 
        patient_ID,
        patient.first_name,
        patient.last_name,
        date_of_birth,
        age,
        status,
        emergency_response,
        allergy,
        room,
        patient.ins_ID,
        patient.user_ID,
        patient_image,
        patient.updated_date,
        institution.ins_name
        
        FROM patient
        INNER JOIN institution
        ON patient.ins_ID = institution.ins_ID
        INNER JOIN user
        ON patient.user_ID = user.user_ID
        ORDER BY patient.updated_date DESC";

        try {
            // Verify database connection
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }

            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                $notes = array();
                $items =  array();
                $result = $statement->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($items, $row);
                }
                $notes["total"] =  count($items);
                $notes["items"] =  $items;

                return $notes;
            }
            return null;
        } catch (Exception $exception) {
            // Handle errors
            $errors = array();
            $errors["system"] = $exception->getMessage();
            $notes["errors"] = $errors;
        }
    }
}