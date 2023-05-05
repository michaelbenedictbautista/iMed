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

    // Create patient model class
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
            $response["message"] = "Patient cannot be created!";
            $response["errors"] = $errors;
        }
        return $response;
    }


    // Edit patient's information model class
    public function updatePatientInformation ($patient_ID ,$first_name, $last_name, $date_of_birth, $age, $gender, $status, $emergency_response, $allergy, $room, $ins_ID, $user_ID, $patient_image) {
        
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
        $queryUpdatePatientInformation = "
        UPDATE patient
        SET
        first_name = '$first_name',
        last_name = '$last_name',
        date_of_birth = '$date_of_birth',
        age = '$age',
        gender = '$gender',
        status = '$status',
        emergency_response = '$emergency_response',
        allergy = '$allergy',
        room = '$room',
        ins_ID = '$ins_ID',
        user_ID = '$user_ID',
        patient_image = '$patient_image'
        WHERE patient_ID = ?
        ";
        
        // Execute query }
        try {
            $statementUpdatePatientInformation = $this->dbconnection->prepare($queryUpdatePatientInformation);
            $statementUpdatePatientInformation->bind_param("i", $patient_ID);

            if (!$statementUpdatePatientInformation->execute()) {
                throw new Exception("Database connection error occured!");
                
            } else {
                $response["success"] = true;
                $response["message"] = "Account has been updated!";
            }
        } catch (Exception $exc) {
            $errors["system"] = $exc->getMessage();
            $response["success"] = false;
            $response["message"] = "account cannot be updated";
            $response["errors"] = $errors;
        }
        return $response;

    }

    // Fetch data from patient table 
    public function getAllPatients()
    {
        // Declaring variables
        $errors = array();
        $patients = array();

        $query = "
        SELECT 
        patient_ID,
        patient.first_name,
        patient.last_name,
        date_of_birth,
        age,
        gender,
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
                $items =  array();
                $result = $statement->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($items, $row);
                }
                $patients["total"] =  count($items);
                $patients["items"] =  $items;

                return $patients;
            }
            return null;
        } catch (Exception $exception) {
            // Handle errors
            $errors["system"] = $exception->getMessage();
            $patients["errors"] = $errors;
        }
    }


    // Search patient by name
    public function getAllPatientByName($patientName)
    {
        $errors = array();
        $search_patient = array();
        $items =  array();
        $patientName = "%$patientName%";

        $query = "
        SELECT 
        patient_ID,
        patient.first_name,
        patient.last_name,
        date_of_birth,
        age,
        gender,
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
        WHERE patient.first_name LIKE ? OR patient.last_name LIKE ?
        ORDER BY patient.updated_date DESC";


        $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
        $statement->bind_param("ss", $patientName, $patientName);
        try {
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                $result = $statement->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($search_patient, $row);
                }

                // $search_patient["total"] =  count($items);
                // $search_patient["items"] =  $items;

                // if ($search_patient["total"] == 0) {
                //     $errors["notFound"] = "No patient found!";
                // }

                return $search_patient;
            }
        } catch (Exception $exception) {
            // Handle errors
            $errors["system"] = $exception->getMessage();
            $search_patient["errors"] = $errors;
        }
        return $search_patient;
    }


    // Display patient by status
    public function getAllPatientByStatus($status)
    {
        $errors = array();
        $search_patient = array();

        $query = "
        SELECT 
        patient_ID,
        patient.first_name,
        patient.last_name,
        date_of_birth,
        age,
        gender,
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
        WHERE status = ?
        ORDER BY patient.updated_date DESC";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            $statement->bind_param("s", $status);

            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                $result = $statement->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($search_patient, $row);
                }

                // $search_patient["total"] =  count($items);
                // $search_patient["items"] =  $items;

                // if ($search_patient["total"] == 0) {
                //     $errors["notFound"] = "No patient found!";
                // }

                return $search_patient;
            }
        } catch (Exception $exception) {
            // Handle errors
            $errors["system"] = $exception->getMessage();
            $search_patient["errors"] = $errors;
        }
    }


    // Display patient by searched name and status active,deceased, dischard 
    public function getAllPatientBySearchNameAndStatus($patientName, $status)
    {
        $errors = array();
        $search_patient = array();
        $patientName = "%$patientName%";

        $query = "
        SELECT
        patient_ID,
        patient.first_name,
        patient.last_name,
        date_of_birth,
        age,
        gender,
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
        WHERE ((patient.first_name LIKE ? OR patient.last_name LIKE ?) AND (status = ?)) 
        ORDER BY patient.updated_date DESC";


        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            $statement->bind_param("sss", $patientName, $patientName, $status);

            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                $result = $statement->get_result();
                while ($row = $result->fetch_assoc()) {
                    array_push($search_patient, $row);
                }

                // $search_patient["total"] =  count($items);
                // $search_patient["items"] =  $items;

                // if ($search_patient["total"] == 0) {
                //     $errors["notFound"] = "No patient found!";
                // }

                return $search_patient;
            }
        } catch (Exception $exception) {
            // Handle errors
            $errors["system"] = $exception->getMessage();
            $search_patient["errors"] = $errors;
        }
    }

    // View patient's detail by patient ID
    public function getPatientDetailById($patient_ID)
    {
        $patients = array();
        $errors = array();

        $query = "
        SELECT
        patient_ID,
        patient.first_name,
        patient.last_name,
        date_of_birth,
        age,
        gender,
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
        WHERE patient_ID = ?
        ORDER BY patient.updated_date DESC";

        try {
            // Verify database connection
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }
            // pass an argument to a parameter
            $statement->bind_param("i", $patient_ID);
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
            $patients["errors"] = $errors;
            return false;
        }
    }

    // Add Medical provider function
    public function addMedicalProvider($mp_name, $med_number, $patient_ID, $user_ID)
    {
        $patients = array();
        $errors = array();

        $query = "
            INSERT INTO patient_medical_provider (mp_name, med_number, patient_ID, user_ID)
            VALUES (?, ?, ?, ?)";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }

            $statement->bind_param("ssii", $mp_name, $med_number, $patient_ID, $user_ID);
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                $patients["success"] = true;
                return true;
            }
        } catch (Exception $exception) {
            $errors["system"] = $exception->getMessage();
            $patients["success"] = false;
            $patients["message"] = "Medical provider cannot be added!";
            $patients["errors"] = $errors;
        }
        return $patients;
    }

    // Get provider details
    public function getProviderDetail($patient_ID)
    {
        $providers = array();
        $errors = array();

        $query = "
            SELECT 
            mp_ID,
            mp_name,
            med_number,
            patient_medical_provider.patient_ID,
            patient_medical_provider.user_ID,
            patient_medical_provider.updated_date,

            patient.patient_ID,

            user.first_name,
            user.last_name,
            user.profession
        
            FROM patient_medical_provider
            INNER JOIN patient
            ON patient_medical_provider.patient_ID = patient.patient_ID
            INNER JOIN user
            ON  patient_medical_provider.user_ID= user.user_ID
            WHERE patient_medical_provider.patient_ID = ?
            ORDER BY patient_medical_provider.updated_date DESC";

        try {
            // Verify database connection
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }
            // pass an argument to a parameter
            $statement->bind_param("i", $patient_ID);
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
            $providers["errors"] = $errors;
            return false;
        }
        return $providers;
    }


    // Add diagnosis function
    public function addDiagnosis($dx_text, $name_of_doctor, $patient_ID, $user_ID)
    {
        $patients = array();
        $errors = array();

        $query = "
            INSERT INTO patient_diagnosis(dx_text, name_of_doctor, patient_ID, user_ID)
            VALUES (?, ?, ?, ?)";

        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }

            $statement->bind_param("ssii", $dx_text, $name_of_doctor, $patient_ID, $user_ID);
            if (!$statement->execute()) {
                throw new Exception("Query execution error!");
            } else {
                $patients["success"] = true;
                return true;
            }
        } catch (Exception $exception) {
            $errors["system"] = $exception->getMessage();
            $patients["success"] = false;
            $patients["message"] = "Diagnosis cannot be added!";
            $patients["errors"] = $errors;
        }
        return $patients;
    }

    // Get diagnosis details
    public function getDignosisDetail($patient_ID)
    {
        $diagnosis = array();
        $errors = array();

        $query = "
            SELECT 
            dx_ID,
            dx_text,
            name_of_doctor,
            patient_diagnosis.patient_ID,
            patient_diagnosis.user_ID,
            patient_diagnosis.updated_date,

            patient.patient_ID,

            user.first_name,
            user.last_name,
            user.profession
        
            FROM patient_diagnosis
            INNER JOIN patient
            ON patient_diagnosis.patient_ID = patient.patient_ID
            INNER JOIN user
            ON patient_diagnosis.user_ID= user.user_ID
            WHERE patient_diagnosis.patient_ID = ?
            ORDER BY patient_diagnosis.updated_date DESC";

        try {
            // Verify database connection
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }
            // pass an argument to a parameter
            $statement->bind_param("i", $patient_ID);
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
            $diagnosis["errors"] = $errors;
            return false;
        }
        return $diagnosis;
    }
    
    // Get diet details
    public function getDietDetail($patient_ID)
    {
        $diet = array();
        $errors = array();

        $query = "
            SELECT 
            diet_ID,
            diet_text,
            name_of_dietitian,
            patient_diet.patient_ID,
            patient_diet.user_ID,
            patient_diet.updated_date,

            patient.patient_ID,

            user.first_name,
            user.last_name,
            user.profession
        
            FROM patient_diet
            INNER JOIN patient
            ON patient_diet.patient_ID = patient.patient_ID
            INNER JOIN user
            ON patient_diet.user_ID= user.user_ID
            WHERE patient_diet.patient_ID = ?
            ORDER BY patient_diet.updated_date DESC";

        try {
            // Verify database connection
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            if (!$statement) {
                throw new Exception("Database connection error!");
            }
            // pass an argument to a parameter
            $statement->bind_param("i", $patient_ID);
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
            $diet["errors"] = $errors;
            return false;
        }
        return $diet;
    }
}