<?php

namespace imed;

use imed\Database;
use Exception;

class VitalSigns extends Database
{
    private $dbconnection;

    // Connect to database
    public function __construct()
    {
        parent::__construct();
        $this->dbconnection = parent::getConnection();
    }

    // Fetch data from vital signs table
    public function getAllVitalSigns($patient_ID)
    {
        $errors = array();
        $vitalSigns = array();

        // Query statement
        $query = "
        SELECT
        vs_ID,
        time_of_obs,
        systolic,
        diastolic,
        temperature,
        pulse_rate,
        respiratory_rate,
        oxygen_saturation,
        vs_text,
        
        patient_vital_signs.patient_ID,
        patient_vital_signs.user_ID,
        patient_vital_signs.updated_date,
        
        patient.patient_ID,

        user.first_name,
        user.last_name,
        user.profession

        FROM patient_vital_signs
        INNER JOIN patient
        ON patient_vital_signs.patient_ID = patient.patient_ID
        INNER JOIN user
        ON patient_vital_signs.user_ID= user.user_ID
        WHERE patient_vital_signs.patient_ID = ?
        ORDER BY patient_vital_signs.updated_date DESC";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            $statement->bind_param("i", $patient_ID);
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                $result = $statement->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($vitalSigns, $row);
                }

                // $search_patient["total"] =  count($items);
                // $search_patient["items"] =  $items;

                // if ($search_patient["total"] == 0) {
                //     $errors["notFound"] = "No patient found!";
                // }

                return $vitalSigns;
            }
        } catch (Exception $exception) {
            // Handle errors
            $errors["system"] = $exception->getMessage();
            $vitalSigns["errors"] = $errors;
        }
        return $vitalSigns;
    }



    // Add vital signs function
    public function addVitalSigns($time_of_obs, $systolic, $diastolic, $temperature, $pulse_rate, $respiratory_rate, $oxygen_saturation, $patient_ID, $user_ID, $vs_text)
    {
        $errors = array();
        $vitalSigns = array();

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
            INSERT INTO patient_vital_signs (time_of_obs, systolic, diastolic, temperature, pulse_rate, respiratory_rate, oxygen_saturation, patient_ID,  user_ID, vs_text)
            VALUES (?,?,?,?,?,?,?,?,?,?)";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }

            $statement->bind_param("siisiiiiis", $time_of_obs, $systolic, $diastolic, $temperature, $pulse_rate, $respiratory_rate, $oxygen_saturation, $patient_ID, $user_ID, $vs_text);
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                return true;
            }
        } catch (Exception $exception) {
            $errors["system"] = $exception->getMessage();
            $vitalSigns["errors"] = $errors;
        }
        return $vitalSigns;
    }


    // Get vital signs' details
    public function getVitalSignsDetail($vs_ID)
    {
        $vitalSigns = array();
        $errors = array();

        $query = "
            SELECT
            vs_ID,
            time_of_obs,
            systolic,
            diastolic,
            temperature,
            pulse_rate,
            respiratory_rate,
            oxygen_saturation,
            vs_text,
            
            patient_vital_signs.patient_ID,
            patient_vital_signs.user_ID,
            patient_vital_signs.updated_date,
            
            patient.patient_ID,

            user.first_name,
            user.last_name,
            user.profession

            FROM patient_vital_signs
            INNER JOIN patient
            ON patient_vital_signs.patient_ID = patient.patient_ID
            INNER JOIN user
            ON patient_vital_signs.user_ID= user.user_ID
            WHERE patient_vital_signs.vs_ID = ?";

        try {
            // Verify database connection
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }
            // pass an argument to a parameter
            $statement->bind_param("i", $vs_ID);
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
            $vitalSigns["errors"] = $errors;
            return false;
        }
        return $vitalSigns;
    }
}