<?php

namespace imed;

use imed\Database;
use Exception;

class ProgressNote extends Database
{
    private $dbconnection;

    // Connect to database
    public function __construct()
    {
        parent::__construct();
        $this->dbconnection = parent::getConnection();
    }

    // Fetch data from progress note table
    public function getAllProgressNotes($patient_ID)
    {
        $errors = array();
        $progressNotes = array();

        // Query statement
        $query = "
        SELECT
        prog_ID,
        prog_text,
        progress_note.patient_ID,
        progress_note.user_ID,
        progress_note.updated_date,
        
        patient.patient_ID,

        user.first_name,
        user.last_name,
        user.profession

        FROM progress_note
        INNER JOIN patient
        ON progress_note.patient_ID = patient.patient_ID
        INNER JOIN user
        ON progress_note.user_ID= user.user_ID
        WHERE progress_note.patient_ID = ?
        ORDER BY progress_note.updated_date DESC";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            $statement->bind_param("i", $patient_ID);
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                $result = $statement->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($progressNotes, $row);
                }

                // $search_patient["total"] =  count($items);
                // $search_patient["items"] =  $items;

                // if ($search_patient["total"] == 0) {
                //     $errors["notFound"] = "No patient found!";
                // }

                return $progressNotes;
            }
        } catch (Exception $exception) {
            // Handle errors
            $errors["system"] = $exception->getMessage();
            $progressNotes["errors"] = $errors;
        }
        return $progressNotes;
    }



    // Add progress note function
    public function addProgNote($prog_text, $patient_ID, $user_ID)
    {
        $errors = array();
        $progressNotes = array();
        
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
            INSERT INTO progress_note (prog_text, patient_ID, user_ID)
            VALUES (?, ?, ?)";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }

            $statement->bind_param("sii", $prog_text, $patient_ID, $user_ID);
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                return true;
            }
        } catch (Exception $exception) {
            $errors["system"] = $exception->getMessage();
            $progressNotes["errors"] = $errors;
        }
        return $progressNotes;
    }


    // Get progress note's details
    public function getProgNoteDetail($prog_ID)
    {
        $progNotes = array();
        $errors = array();

        $query = "
            SELECT 
            prog_ID,
            prog_text,
            progress_note.patient_ID,
            progress_note.user_ID,
            progress_note.updated_date,

            patient.patient_ID,

            user.first_name,
            user.last_name,
            user.profession
            
    
            FROM progress_note
            INNER JOIN patient
            ON progress_note.patient_ID = patient.patient_ID
            INNER JOIN user
            ON progress_note.user_ID = user.user_ID
            WHERE progress_note.prog_ID = ?";

        try {
            // Verify database connection
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }
            // pass an argument to a parameter
            $statement->bind_param("i", $prog_ID);
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
            $progNotes["errors"] = $errors;
            return false;
        }
        return $progNotes;
    }
}