<?php

// enable composer autoloading
require("vendor/autoload.php");

use imed\Patient;
use imed\MedicalRecord;
use imed\Session;

// Session class
$user_id = null;
$user_userName = null;
$user_pw = null;
$user_firstName = null;
$user_lastName = null;
$user_contact = null;
$user_email = null;
$user_profession = null;
$user_level = null;
$user_image = null;
$user_ins_name = null;
$user_ins_add = null;

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

$patient = new Patient();
$patient_id = null;
$patientDetail = null;

$medicalRecord= new MedicalRecord();
$medicalRecordDetail = array();
$resultsMedicalRecord =  null;

// Check if patient_ID patient and view-patient-profile page is being receive.
if (isset($_GET["patient_ID"])) {
    $patient_id = $_GET['patient_ID'];
    // Display patient basic information
    $patientDetail = $patient->getPatientDetailById($patient_id);
}

// Verify post method
if ($_SERVER['REQUEST_METHOD'] == 'POST' && (('user_email') != null)) {
    $patient_ID = trim($_POST["patient_ID"]);
    $mr_time = trim($_POST["mr_time"]);
    $mr_title = trim(strtolower($_POST["mr_title"]));
    $mr_result = trim(strtolower($_POST["mr_result"]));
    $mr_text = trim(strtolower($_POST["mr_text"]));


    // Uploading file
    $mr_file = $_FILES['mr_file'];
    $imageFileName = $mr_file['name'];
    $imageFileType = $mr_file['type'];
    $imageFileTempName = $mr_file['tmp_name'];
    $allowedTypes = array('image/jpeg', 'image/jpg','image/png', 'image/tiff'); // acceptable file extension
    $maxSize = 5 * 1024 * 1024; // 5MB max size of an image

    //echo $imageFileName;

    if (!empty($imageFileName))  {
         
        // Check file type
        if (!in_array($imageFileType, $allowedTypes)) {
            echo 'Error: Invalid file type. Only JPEG, PNG, and TIFF files are allowed.';
            "<script>
                alert('Error occured during execution!);
                window.location.href='view-patient-medical-record.php?patient_ID=$patient_ID';
            </script>";
        }

        // Check file size
        if ($mr_file['size'] > $maxSize) {
            echo 'Error: File size exceeds 5MB limit.';
            "<script>
                alert('Error occured during execution!);
                window.location.href='view-patient-medical-record.php?patient_ID=$patient_ID';
            </script>";
        }

        $imageFileExtension = pathinfo($imageFileName, PATHINFO_EXTENSION); // image extension
        $generatedImageFileName = uniqid() . '.' . $imageFileExtension; // rename file with unique name
        
        // Move uploaded file to desired location
        $uploadPath = 'img/uploads_medical_record/' . $generatedImageFileName;

        if (move_uploaded_file($imageFileTempName, $uploadPath)) {
            try {
                // Add progress medical record function
                $resultsMedicalRecord = $medicalRecord->addMedicalRecord($mr_time, $mr_title, $mr_result, $generatedImageFileName, $mr_text, $patient_ID, $user_id);
                
                // Display patient basic information
                $patientDetail = $patient->getPatientDetailById($patient_ID);

                // Display patient basic information
                $medicalRecordDetail = $medicalRecord->getAllMedicalRecords($patient_ID);

                // //alert('Note added successfully!');
                // echo "<script>
                // window.location.href='view-patient-medical-record.php';
                // <p class='alert alert-success' id='successfulMessage'>Medical record added successfully!</p>;
                // </script>"; 

                // // Hide the message after 5 seconds
                // echo
                // "<script>
                //     const successfulMessage = document.getElementById('successfulMessage');
                //     setTimeout(function() {
                //         successfulMessage.style.display = 'none';
                //     }, 5000);
                // </script>";

                echo 
                "<script>
                    alert('Medical record added successfully!');
                    window.location.href='view-patient-medical-record.php?patient_ID=$patient_ID';
                </script>";

                      
            } catch (Exception $e) {

                $myArrayresultsErrorsMessage = implode(",", $resultsMedicalRecord['errors']);

                // echo "<script>
                // window.location.href='view-patient-medical-record.php';
                // <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                // $myArrayresultsErrorsMessage
                // <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                // </div>;
                // </script>";     

                // Display patient basic information
                $patientDetail = $patient->getPatientDetailById($patient_ID);

                // Display patient all medical records information
                $medicalRecordDetail = $medicalRecord->getAllMedicalRecords($patient_ID);

                echo 
                "<script>
                    alert('Error occured during execution!);
                    window.location.href='view-patient-medical-record.php?patient_ID=$patient_ID';
                </script>";
                
            } 
        } else {
            echo 
            "<script>
                alert('Unable to upload file!);
                window.location.href='view-patient-medical-record.php?patient_ID=$patient_ID';
            </script>";
        }
    } else {

        // Add progress note function
        $generatedImageFileName = null;
        $resultsMedicalRecord = $medicalRecord->addMedicalRecord($mr_time, $mr_title, $mr_result, $generatedImageFileName, $mr_text, $patient_ID, $user_id);

        // Display patient basic information
        $patientDetail = $patient->getPatientDetailById($patient_ID);

        // Display patient medical records information
        $medicalRecordDetail = $medicalRecord->getAllMedicalRecords($patient_ID);

        // echo "<script>
        //         window.location.href=view-patient-medical-record.php';
        //         <p class='alert alert-success' id='successfulMessage'>Medical record added successfully!</p>;
        //         </script>"; 

        // // Hide the message after 5 seconds
        // echo
        // "<script>
        //     const successfulMessage = document.getElementById('successfulMessage');
        //     setTimeout(function() {
        //         successfulMessage.style.display = 'none';
        //     }, 5000);
        // </script>";

        echo 
        "<script>
            alert('Medical record added successfully!');
            window.location.href='view-patient-medical-record.php?patient_ID=$patient_ID';
        </script>";
                
     }
   
}


$site_name = "iMed";

// Create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(

    "add-medical-record.html.twig",
    [
        // Pass all variables to be used
        "page_title" => "Add medical record",
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

        //"patient_id" => $patient_id,
        "patientDetail" => $patientDetail,
        "medicalRecordDetail" => $medicalRecordDetail,
        "resultsMedicalRecord" => $resultsMedicalRecord,

    ]
);