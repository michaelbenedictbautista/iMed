<?php

namespace imed;

use imed\Database;
use Exception;

class Medication extends Database
{
    private $dbconnection;

    // Connect to database
    public function __construct()
    {
        parent::__construct();
        $this->dbconnection = parent::getConnection();
    }

    // Fetch data from medication table
    public function getAllMedication($patient_ID)
    {
        $errors = array();
        $medication = array();

        // Query statement
        $query = "
        SELECT
        med_ID,
        time_of_prescription,
        name_of_drug,
        dose,
        route,
        frequency,
        start_date,
        end_date,
        name_of_doctor,
        patient_medication.status,
        med_text,
        med_file,
        patient_medication.updated_date,
        
        patient_medication.patient_ID,
        patient_medication.user_ID,
        patient_medication.updated_date,
        
        patient.patient_ID,

        user.first_name,
        user.last_name,
        user.profession

        FROM patient_medication
        INNER JOIN patient
        ON patient_medication.patient_ID = patient.patient_ID
        INNER JOIN user
        ON patient_medication.user_ID= user.user_ID
        WHERE patient_medication.patient_ID = ?
        ORDER BY patient_medication.updated_date DESC";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            $statement->bind_param("i", $patient_ID);
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                $result = $statement->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($medication, $row);
                }

                // $search_patient["total"] =  count($items);
                // $search_patient["items"] =  $items;

                // if ($search_patient["total"] == 0) {
                //     $errors["notFound"] = "No patient found!";
                // }

                return $medication;
            }
        } catch (Exception $exception) {
            // Handle errors
            $errors["system"] = $exception->getMessage();
            $medication["errors"] = $errors;
        }
        return $medication;
    }



    // Add medcation function
    public function addMedication($time_of_prescription, $name_of_drug, $dose, $route, $frequency, $start_date, $end_date, $name_of_doctor, $status, $med_text, $med_file, $patient_ID, $user_ID)
    {
        $errors = array();
        $medication = array();

        // Query statement
        $query = "
            INSERT INTO patient_medication (time_of_prescription, name_of_drug, dose, route, frequency, start_date, end_date, name_of_doctor, status, med_text, med_file, patient_ID, user_ID)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }

            $statement->bind_param("sssssssssssii", $time_of_prescription, $name_of_drug, $dose, $route, $frequency, $start_date, $end_date, $name_of_doctor, $status, $med_text, $med_file, $patient_ID, $user_ID);
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                return true;
            }
        } catch (Exception $exception) {
            $errors["system"] = $exception->getMessage();
            $medication["errors"] = $errors;
        }
        return $medication;
    }


    // Get vital signs' details
    public function getMedicationDetail($med_ID)
    {
        $medication = array();
        $errors = array();

        $query = "
            SELECT
            med_ID,
            time_of_prescription,
            name_of_drug,
            dose,
            route,
            frequency,
            start_date,
            end_date,
            name_of_doctor,
            patient_medication.status,
            med_text,
            med_file,
            patient_medication.updated_date,
            
            patient_medication.patient_ID,
            patient_medication.user_ID,
            patient_medication.updated_date,
                
            patient.patient_ID,

            user.first_name,
            user.last_name,
            user.profession

            FROM patient_medication
            INNER JOIN patient
            ON patient_medication.patient_ID = patient.patient_ID
            INNER JOIN user
            ON patient_medication.user_ID= user.user_ID
            WHERE patient_medication.med_ID = ?";

        try {
            // Verify database connection
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }
            // pass an argument to a parameter
            $statement->bind_param("i", $med_ID);
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                $result = $statement->get_result();
                $detail = $result->fetch_assoc();
                return $detail;
            }
        } catch (Exception $exception) {
            // Handle errors
            echo $exception->getMessage();
            $errors["system"] = $exception->getMessage();
            $medication["errors"] = $errors;
            return false;
        }
        return $medication;
    }
}