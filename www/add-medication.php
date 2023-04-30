<?php

// enable composer autoloading
require("vendor/autoload.php");

use imed\Medication;
use imed\Session;
use imed\Patient;

// Session class
$user_id = null;
$user_email = null;


if (Session::get('user_email') == null) {
    header('Location: signin.php');
} else {
    $user_id = Session::get("user_id");
    $user_userName = Session::get("user_userName");
    $user_pw = Session::get("user_pw");
    $user_firstName = Session::get("user_firstName");
    $user_lastName = Session::get("user_lastName");
    $user_contact = Session::get("user_contact");
    $user_email = Session::get("user_email");
    $user_profession = Session::get("user_profession");
    $user_level = Session::get("user_level");
    $user_image = Session::get("user_image");
    $user_ins_ID = Session::get("user_ins_ID");
    $user_ins_name = Session::get("user_ins_name");
    $user_ins_add = Session::get("user_ins_add");
}

//Declare variables
$patient = new Patient();
$patientDetail = null;

$medication = new Medication();
$medicationDetail = array();
$resultsMedication =  null;


// Verify post method and user email address
if ($_SERVER["REQUEST_METHOD"] == "POST" && (('user_email') != null)) {
    $patient_ID = trim($_POST["patient_ID"]);
    $time_of_prescription = trim($_POST["time_of_prescription"]);
    $name_of_drug = trim(strtolower($_POST["name_of_drug"]));
    $dose = trim(strtolower($_POST["dose"]));   
    //$dose .= "mg";
    $route = $_POST["route"];
    $frequency = $_POST["frequency"];
    $start_date = trim($_POST["start_date"]);
    $end_date = trim($_POST["end_date"]);
    $name_of_doctor = trim(strtolower($_POST["name_of_doctor"]));
    $status = trim(strtolower($_POST["status"]));
    $med_text = trim(strtolower($_POST["med_text"]));

    
    $med_file = $_FILES['med_file'];
    $imageFileName = $med_file['name'];
    $imageFileType = $med_file['type'];
    $imageFileTempName = $med_file['tmp_name'];
    $allowedTypes = array('image/jpeg', 'image/png', 'image/tiff'); // acceptable file extension
    $maxSize = 5 * 1024 * 1024; // 5MB max size of an image

    if (!empty($imageFilename)) {
        
        // Check file type
        if (!in_array($imageFileType, $allowedTypes)) {
            echo 'Error: Invalid file type. Only JPEG, PNG, and TIFF files are allowed.';
            exit;
        }

        // Check file size
        if ($med_file['size'] > $maxSize) {
            echo 'Error: File size exceeds 5MB limit.';
            exit;
        }

        $imageFileExtension = pathinfo($imageFileName, PATHINFO_EXTENSION); // image extension
        $generatedImageFileName = uniqid() . '.' . $imageFileExtension; // rename file with unique name

        // Move uploaded file to desired location
        $uploadPath = 'img/uploads_medication/' . $generatedImageFileName;

        if (move_uploaded_file($imageFileTempName, $uploadPath)) {
            try {
                // Add progress medication function
                $resultsMedication = $medication->addMedication($time_of_prescription, $name_of_drug, $dose, $route, $frequency, $start_date, $end_date, $name_of_doctor, $status, $med_text, $generatedImageFileName, $patient_ID, $user_id);

                // Display patient basic information
                $patientDetail = $patient->getPatientDetailById($patient_ID);

                // Display patient basic information
                $medicationDetail = $medication->getAllMedication($patient_ID);

                echo "<p class='alert alert-success' id='successfulMessage'>Medication added successfully!</p>";

                // Hide the message after 5 seconds
                echo
                "<script>
                    const successfulMessage = document.getElementById('successfulMessage');
                    setTimeout(function() {
                        successfulMessage.style.display = 'none';
                    }, 5000);
                </script>";
                
            } catch (Exception $e) {

                $myArrayresultsErrorsMessage = implode(",", $resultsMedication['errors']);
                
                echo
                "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                $myArrayresultsErrorsMessage
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                </div>";

                // Display patient basic information
                $patientDetail = $patient->getPatientDetailById($patient_ID);

                // Display patient medication information
                $medicationDetail = $medication->getAllMedication($patient_ID);
                
            } 
        } 
    } else {

        // Add progress note function
        $generatedImageFileName = null;
        $resultsMedication = $medication->addMedication($time_of_prescription, $name_of_drug, $dose, $route, $frequency, $start_date, $end_date, $name_of_doctor, $status, $med_text, $generatedImageFileName, $patient_ID, $user_id);

        // Display patient basic information
        $patientDetail = $patient->getPatientDetailById($patient_ID);

        // Display patient medication information
        $medicationDetail = $medication->getAllMedication($patient_ID);

        echo "<p class='alert alert-success' id='successfulMessage'>Medication added successfully!</p>";

        // Hide the message after 5 seconds
        echo
        "<script>
            const successfulMessage = document.getElementById('successfulMessage');
            setTimeout(function() {
                successfulMessage.style.display = 'none';
            }, 5000);
        </script>";    
    }
    
} else {
    // Display patient basic information
    $patientDetail = $patient->getPatientDetailById($patient_ID);

    // Display patient basic information
    $medicationDetail = $medication->getAllMedication($patient_ID);
}
  
$site_name = "iMed";

// Create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(

    "view-patient-medication.html.twig",
    [
        //Pass all variables to be used
        "page_title" => "Patient",
        "site_name" => $site_name,

        "user_id" => $user_id,
        "user_userName" => $user_userName,
        "user_pw" => $user_pw,
        "user_firstName" => $user_firstName,
        "user_lastName" => $user_lastName,
        "user_contact" => $user_contact,
        "user_email" => $user_email,
        "user_profession" => $user_profession,
        "user_level" => $user_level,
        "user_image" => $user_image,
        "user_ins_ID" => $user_ins_ID,
        "user_ins_name" => $user_ins_name,
        "user_ins_add" => $user_ins_add,

        "patientDetail" => $patientDetail,
        "medicationDetail" => $medicationDetail,
        "resultsMedication" => $resultsMedication,

    ]
);