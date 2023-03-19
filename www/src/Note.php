<?php

namespace imed;

use imed\Database;
use Exception;

class Note extends Database
{
    private $dbconnection;

    // Connect to database
    public function __construct()
    {
        parent::__construct();
        $this->dbconnection = parent::getConnection();
    }

    // Fetch data from note table 
    public function getAllNotes()
    {
        $query = "
        SELECT 
        note_ID,
        note_text,
        note.updated_date,
        first_name,
        last_name,
        profession
        
        FROM note
        INNER JOIN user
        ON note.user_ID = user.user_ID
        ORDER BY note.updated_date DESC";

        try {
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
            $errors = array();
            $errors["system"] = $exception->getMessage();
            $notes["errors"] = $errors;
        }
    }

    // Add note function
    public function addNote($note_text, $user_id)
    {
        $notes = array();
        $errors = array();
        try {
            if ((empty($note) || is_null($note)) || (empty($user_id))) {
                throw new Exception("Text field can not be empty.");
                return false;
            } else return true;
        } catch (Exception $exception) {
            $errors["system"] = $exception->getMessage();
            $notes["errors"] = $errors;
        }

        $query = "
            INSERT INTO note (note_text, user_ID)
            VALUES (?, ?)";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }

            $statement->bind_param("si", $note_text, $user_id);
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                return true;
            }
        } catch (Exception $exception) {
            $errors["system"] = $exception->getMessage();
            $notes["errors"] = $errors;
        }
    }

    // Get note's details
    public function getNoteDetail($note_ID)
    {
        $notes = array();
        $errors = array();

        $query = "
            SELECT 
            note_ID,
            note_text,
            note.user_ID,
            note.updated_date,
            user.first_name,
            user.last_name,
            user.profession
        
            FROM note
            INNER JOIN user
            ON  note.user_ID= user.user_ID
            WHERE note.note_ID = ?";

        try {
            // Verify database connection
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }
            // pass an argument to a parameter
            $statement->bind_param("i", $note_ID);
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
            $notes["errors"] = $errors;
            return false;
        }
    }
}