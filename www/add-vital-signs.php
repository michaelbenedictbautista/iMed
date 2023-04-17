<?php

// enable composer autoloading
require("vendor/autoload.php");

use imed\VitalSigns;
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
$vitalSigns = new VitalSigns();
$vitalSignsDetail = array();
$resultsVitalSigns =  null;

// Verify post method and user email address
if ($_SERVER["REQUEST_METHOD"] == "POST" && (('user_email') != null)) {
    $patient_ID = trim($_POST["patient_ID"]);
    $time_of_obs = trim($_POST["time_of_obs"]);
    $systolic = trim($_POST["systolic"]);
    $diastolic = trim($_POST["diastolic"]);
    $temperature = trim($_POST["temperature"]);
    $pulse_rate = trim($_POST["pulse_rate"]);
    $respiratory_rate = trim($_POST["respiratory_rate"]);
    $oxygen_saturation = trim($_POST["oxygen_saturation"]);  
    $vs_text = trim(strtolower($_POST["vs_text"]));
    

    // Add progress note function
    $resultsVitalSigns = $vitalSigns->addVitalSigns($time_of_obs, $systolic, $diastolic, $temperature, $pulse_rate, $respiratory_rate, $oxygen_saturation, $patient_ID, $user_id, $vs_text);
    
    // Display patient basic information
    $patientDetail = $patient->getPatientDetailById($patient_ID);

    // Display patient basic information
    $vitalSignsDetail = $vitalSigns->getAllVitalSigns($patient_ID);

    
    if (isset($resultsVitalSigns['errors'])) {
        
        $myArrayresultsErrorsMessage = implode(",", $resultsVitalSigns['errors']);
    
    echo
            "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            $myArrayresultsErrorsMessage
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";


    // Display patient basic information
    $patientDetail = $patient->getPatientDetailById($patient_ID);

    // Display patient basic information
    $vitalSignsDetail = $vitalSigns->getAllVitalSigns($patient_ID);
        
    } else {

        echo "<p class='alert alert-success' id='successfulMessage'>Vital signs added successfully!</p>";

        // Hide the message after 5 seconds
        echo
        "<script>
            const successfulMessage = document.getElementById('successfulMessage');
            setTimeout(function() {
                successfulMessage.style.display = 'none';
            }, 5000);
        </script>";
        
        // Display patient basic information
        $patientDetail = $patient->getPatientDetailById($patient_ID);

        // Display patient basic information
        $vitalSignsDetail = $vitalSigns->getAllVitalSigns($patient_ID);
    }
    
} else {

    $unSuccessfulMessage = "Error occured during execution!";
    echo "<p class='alert alert-warning' id='successfulMessage'>$unSuccessfulMessage</p>";
    // Hide the message after 5 seconds
    echo
    "<script>
        const successfulMessage = document.getElementById('successfulMessage');
        setTimeout(function() {
            successfulMessage.style.display = 'none';
        }, 5000);
    </script>";

    // Display patient basic information
    $patientDetail = $patient->getPatientDetailById($patient_ID);

    // Display patient basic information
    $vitalSignsDetail = $vitalSigns->getAllVitalSigns($patient_ID);
}

$site_name = "iMed";

// Create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(

    "view-patient-vital-sign.html.twig",
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
        "vitalSignsDetail" => $vitalSignsDetail,
        "resultsVitalSigns" => $resultsVitalSigns,

    ]
);