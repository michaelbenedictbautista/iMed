<?php

namespace imed;

use imed\Database;
use Exception;

class Account extends Database
{
    private $dbconnection;

    public function __construct()
    {
        parent::__construct();
        $this->dbconnection = parent::getConnection();
    }

    // Create user account
    public function createUser($firstName, $lastName, $userName, $password, $contactNumber, $email, $profession, $userLevel, $image, $insName, $insAdd)
    {
        $errors = array();
        $response = array();

        $firstName = trim($firstName);
        $lastName = trim($lastName);
        $userName = trim(strtolower($userName));
        $password = trim($password);
        $contactNumber = trim($contactNumber);
        $email = trim(strtolower($email));
        $profession = trim(strtolower($profession));

        $ins_ID = null;

        $insName = trim(strtolower($insName));
        $insAdd = trim(strtolower($insAdd));

        // check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["user_email"] = "Invalid email address";
        }
        // check password length
        if (strlen($password) < 8) {
            $errors["user_password"] = "Password must be longer than 8 characters";
        }

        // If there are no errors found
        if (count($errors) == 0) {

            // Query to select institution
            $querySelectInstitution = "
            SELECT * 
            FROM institution 
            WHERE ins_name = ?";

            // Execute query
            try {
                $statementSelect = $this->dbconnection->prepare($querySelectInstitution) or die($this->dbconnection->error);
                $statementSelect->bind_param("s", $insName);

                if (!$statementSelect->execute()) {
                    throw new Exception("Error executing query");
                } else {
                    $result = $statementSelect->get_result();

                    if ($result->num_rows == 0) {
                        // Query to insert institution
                        $queryInsertInstitution = "         
                         INSERT INTO iMed.Institution (ins_name, ins_add) 
                         VALUES ( ?, ?)";

                        $statementIns = $this->dbconnection->prepare($queryInsertInstitution) or die($this->dbconnection->error);
                        $statementIns->bind_param("ss", $insName, $insAdd);

                        // Execute query
                        try {
                            if (!$statementIns->execute()) {
                                throw new Exception("Database connection error occured!");
                            } else {
                                // Get the latest inserted auto increment ID        
                                $ins_ID = mysqli_insert_id($this->dbconnection);

                                // Query to insert user
                                $queryInsertUser = "
                                 INSERT INTO iMed.User (first_name, last_name, username, password, contact_number, email, ins_ID, profession, user_level, user_image) 
                                 VALUES( ?, ?, ?, ?, ?, ?, $ins_ID, ?, ?, ?)";

                                try {
                                    //$hashed = password_hash($password, PASSWORD_DEFAULT);
                                    $statementUser = $this->dbconnection->prepare($queryInsertUser) or die($this->dbconnection->error);
                                    $statementUser->bind_param("sssssssis", $firstName, $lastName, $userName, $password, $contactNumber, $email, $profession, $userLevel, $image);

                                    // Execute query
                                    if (!$statementUser->execute()) {
                                        throw new Exception("Database connection error occured!");
                                    } else {
                                        $response["success"] = true;
                                        $response["message"] = "Account has been created!";
                                        $response["ins_ID"] =  $ins_ID;
                                    }
                                } catch (Exception $exc) {
                                    $errors["system"] = $exc->getMessage();
                                    if ($this->dbconnection->errno == "1062") {
                                        $errors["account"] = "The email address already exists!";
                                    }
                                    $response["success"] = false;
                                    $response["message"] = "Account cannot be created!";
                                    $response["errors"] = $errors;
                                }
                                return $response;
                            }
                        } catch (Exception $exc) {
                            $errors["system"] = $exc->getMessage();

                            // Duplication of email error
                            if ($this->dbconnection->errno == "1062") {
                                $errors["account"] = "The email address already exists!";
                            }
                            $response["success"] = false;
                            $response["message"] = "Account cannot be created!";
                            $response["errors"] = $errors;
                        }
                        return $response;
                    } else {
                        $account_data = $result->fetch_assoc();

                        // Check for duplicate or same institution
                        if ($insName == $account_data["ins_name"]) {
                            $ins_ID = $account_data["ins_ID"];

                            // Query to insert user
                            $queryInsertUser = "
                        INSERT INTO iMed.User (first_name, last_name, username, password, contact_number, email, ins_ID, profession, user_level, user_image) 
                        VALUES( ?, ?, ?, ?, ?, ?, $ins_ID, ?, ?, ?)";

                            try {
                                //$hashed = password_hash($password, PASSWORD_DEFAULT);
                                $statementUser = $this->dbconnection->prepare($queryInsertUser) or die($this->dbconnection->error);
                                $statementUser->bind_param("sssssssis", $firstName, $lastName, $userName, $password, $contactNumber, $email, $profession, $userLevel, $image);

                                // Execute query
                                if (!$statementUser->execute()) {
                                    throw new Exception("Database connection error occured!");
                                } else {
                                    $response["success"] = true;
                                    $response["message"] = "Account has been created!";
                                    $response["ins_ID"] =  $ins_ID;
                                }
                            } catch (Exception $exc) {
                                $errors["system"] = $exc->getMessage();
                                if ($this->dbconnection->errno == "1062") {
                                    $errors["account"] = "The email address already exists!";
                                }
                                $response["success"] = false;
                                $response["message"] = "Account cannot be created!";
                                $response["errors"] = $errors;
                            }
                            return $response;
                        }
                    }
                }
            } catch (Exception $exc) {
                $errors["system"] = $exc->getMessage();
                $response["success"] = false;
                $response["message"] = "Account cannot be created!";
                $response["errors"] = $errors;
            }
            return $response;
        } else {
            // return errors to user
            $response["success"] = false;
            $response["message"] = "Account cannot be created!";
            $response["errors"] = $errors;
        }

        return $response;
    }

    // User login/signin 
    public function login($email, $password)
    {
        $errors = array();
        $response = array();

        $email = trim(strtolower($email));
        //$password = trim($password);

        // Query to select user
        $query = "
        SELECT user_ID, first_name, last_name, username, password, contact_number, email, user.ins_ID, profession, user_level, user_image, user.updated_date, ins_name, ins_add 
        FROM user 
        INNER JOIN institution
        ON user.ins_ID = institution.ins_ID
        WHERE email = ?";


        try {
            $statement = $this->dbconnection->prepare($query) or die($this->dbconnection->error);
            $statement->bind_param("s", $email);

            // Execute query
            if (!$statement->execute()) {
                throw new Exception("Error executing query");
            } else {
                $result = $statement->get_result();
                if ($result->num_rows == 0) {
                    throw new Exception("Invalid email or password!");
                } else {
                    $account_data = $result->fetch_assoc();
                    

                    // Check password
                    //if (password_verify($password, $account_data["password"])) {
                    
                     if ($password == $account_data["password"]) {
                        $response["success"] = true;
                        $response["id"] = $account_data["user_ID"];
                        $response["uName"] = $account_data["username"];
                        $response["password"] = $account_data["password"];
                        $response["fName"] = $account_data["first_name"];
                        $response["lName"] = $account_data["last_name"];
                        $response["contact"] = $account_data["contact_number"];
                        $response["email"] = $account_data["email"];
                        $response["profession"] = $account_data["profession"];
                        $response["user_level"] = $account_data["user_level"];
                        $response["image"] = $account_data["user_image"];
                        $response["ins_ID"] = $account_data["ins_ID"];
                        $response["ins_name"] = $account_data["ins_name"];
                        $response["ins_add"] = $account_data["ins_add"];

                        return $response;
                    } else {
                        throw new Exception("Password is incorrect!");
                    }
                }
            }
        } catch (Exception $exc) {
            $errors["system"] = $exc->getMessage();
            $response["success"] = false;
            $response["errors"] = $errors;
        }
        return $response;
    }

    // Update account
    public function updateAccount($userID, $firstName, $lastName, $userName, $password, $contactNumber, $email, $profession, $userLevel, $image, $insID, $insName, $insAdd)
    {
        $errors = array();
        $response = array();

        $firstName = trim($firstName);
        $lastName = trim($lastName);
        $userName = trim(strtolower($userName));
        $password = trim($password);
        //$hashed = password_hash($password, PASSWORD_DEFAULT);
        $contactNumber = trim($contactNumber);
        $email = trim(strtolower($email));
        $profession = trim(strtolower($profession));

        $insName = trim(strtolower($insName));
        $insAdd = trim(strtolower($insAdd));

        // Query to update institution
        $queryUpdateInstitution = "
        UPDATE institution
        SET
        ins_name = '$insName',
        ins_add = '$insAdd'
        WHERE ins_ID = ?";

        try {
            $statementUpdateInstitution = $this->dbconnection->prepare($queryUpdateInstitution);
            $statementUpdateInstitution->bind_param("i", $insID);

            // Execute query
            if (!$statementUpdateInstitution->execute()) {
                throw new Exception("Database connection error occured!");
            } elseif (empty($insName) || empty($insAdd)) {
                throw new Exception("All fields are required!");
                return false;
            } else {
                //$hashed = password_hash($user_pw, PASSWORD_DEFAULT);

                // Execute query
                $query = "
                UPDATE user         
                SET 
                first_name = '$firstName', 
                last_name = '$lastName',
                username = '$userName',
                password = '$password',
                contact_number = '$contactNumber',
                email = '$email',
                profession = '$profession',
                user_level = '$userLevel',
                user_image = '$image'                  
                WHERE user_ID = ?";

                // Execute query
                try {
                    $statementUpdateUser = $this->dbconnection->prepare($query);
                    $statementUpdateUser->bind_param("i", $userID);

                    if (!$statementUpdateUser->execute()) {
                        throw new Exception("Database connection error occured!");
                    } elseif (
                        empty($firstName) || empty($lastName) || empty($userName) || empty($contactNumber) ||
                        empty($email) || empty($profession) || empty($userLevel) || empty($image)
                    ) {
                        throw new Exception("All fields are required!");
                        return false;
                    } elseif (empty($password)) {
                        throw new Exception("Type new password or input your old password");
                        return false;
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
        } catch (Exception $exc) {
            $errors["system"] = $exc->getMessage();
            $response["success"] = false;
            $response["message"] = "Account cannot be updated";
            $response["errors"] = $errors;
        }
        return $response;
    }

    // Delete account
    public function deleteAccount($user_id)
    {
        $errors = array();
        $response = array();

        $query = "
        DELETE from user where user_id = ?";

        try {
            $statement = $this->dbconnection->prepare($query);
            $statement->bind_param("i", $user_id);
            if (!$statement->execute()) {
                throw new Exception("Account cannot be deleted");
            } else {
                $response["success"] = true;
                $response["message"] = "Account has been deleted!";
            }
        } catch (Exception $exc) {
            $errors["system"] = $exc->getMessage();
            $response["success"] = false;
            $response["message"] = "account cannot be deleted";
            $response["errors"] = $errors;
        }
        return $response;
    }
}