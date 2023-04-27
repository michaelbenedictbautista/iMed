<?php

namespace imed;

use imed\Database;
use Exception;

class MedicalRecord extends Database
{
    private $dbconnection;

    // Connect to database
    public function __construct()
    {
        parent::__construct();
        $this->dbconnection = parent::getConnection();
    }


    // Fetch data from medical record table
    public function getAllMedicalRecords($patient_ID)
    {
        $errors = array();
        $medicalRecords = array();

        // Query statement
        $query = "
        SELECT
        mr_ID,
        mr_time,
        mr_title,
        mr_result,
        mr_file,
        mr_text,
        
        patient_medical_record.patient_ID,
        patient_medical_record.user_ID,
        patient_medical_record.updated_date,
        
        patient.patient_ID,

        user.first_name,
        user.last_name,
        user.profession

        FROM patient_medical_record
        INNER JOIN patient
        ON patient_medical_record.patient_ID = patient.patient_ID
        INNER JOIN user
        ON patient_medical_record.user_ID= user.user_ID
        WHERE patient_medical_record.patient_ID = ?
        ORDER BY patient_medical_record.updated_date DESC";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            $statement->bind_param("i", $patient_ID);
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                $result = $statement->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($medicalRecords, $row);
                }

                // $search_patient["total"] =  count($items);
                // $search_patient["items"] =  $items;

                // if ($search_patient["total"] == 0) {
                //     $errors["notFound"] = "No patient found!";
                // }

                return $medicalRecords;
            }
        } catch (Exception $exception) {
            // Handle errors
            $errors["system"] = $exception->getMessage();
            $medicalRecords["errors"] = $errors;
        }
        return $medicalRecords;
    }


    // Add medical record function
    public function addMedicalRecord($mr_time, $mr_title, $mr_result, $mr_file, $mr_text, $patient_ID, $user_ID)
    {
        $errors = array();
        $medicalRecords = array();

        // try {
        //     if ((empty($note) || is_null($note)) || (empty($user_id))) {
        //         throw new Exception("Text field can not be empty.");
        //         return false;
        //     } else return true;
        // } catch (Exception $exception) {
        //     $errors["system"] = $exception->getMessage();
        //     $notes["errors"] = $errors;
        // }

        // Query statement
        $query = "
            INSERT INTO patient_medical_record (mr_time, mr_title, mr_result, mr_file, mr_text, patient_ID, user_ID)
            VALUES (?,?,?,?,?,?,?)";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }
            // Prevent SQL injection
            $statement->bind_param("sssssii", $mr_time, $mr_title, $mr_result, $mr_file, $mr_text, $patient_ID, $user_ID);
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                return true;
            }
        } catch (Exception $exception) {
            $errors["system"] = $exception->getMessage();
            $medicalRecords["errors"] = $errors;
        }
        return $medicalRecords;
    }

    // Get  medical record details
    public function getMedicalRecordDetail($mr_ID)
    {
        $medicalRecords = array();
        $errors = array();

        $query = "
            SELECT
            mr_ID,
            mr_time,
            mr_title,
            mr_result,
            mr_file,
            mr_text,
            
            patient_medical_record.patient_ID,
            patient_medical_record.user_ID,
            patient_medical_record.updated_date,
            
            patient.patient_ID,

            user.first_name,
            user.last_name,
            user.profession

            FROM patient_medical_record
            INNER JOIN patient
            ON patient_medical_record.patient_ID = patient.patient_ID
            INNER JOIN user
            ON patient_medical_record.user_ID= user.user_ID
            WHERE patient_medical_record.mr_ID = ?";

        try {
            // Verify database connection
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }
            // pass an argument to a parameter
            $statement->bind_param("i", $mr_ID);
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
            $medicalRecords["errors"] = $errors;
            return false;
        }
        return $medicalRecords;
    }

}