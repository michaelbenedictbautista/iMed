<?php
// enable composer autoloading
require("vendor/autoload.php");

use imed\Session;
use imed\Patient;

// Session class
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

// Check if patient_ID is being receive.
$patient = new Patient();
$resultsMedProvider = null;
$newMedicalProviderName = null;
$newMedicalProviderNumber = null;
$patient_id = null;

$patientDetail = array();
$successfulMessage = null;
$unSuccessfulMessage = null;
$resultsErrorsCount = null;
$resultsErrorsMessage = array();
$myArrayresultsErrorsMessage = "";


$providerDetail = array();

// Add medical provider
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_ID'];


    if (isset($_POST['submitMedProvider'])) {
        $newMedicalProviderName = trim(strtolower($_POST["medProviderName"]));
        $newMedicalProviderNumber = trim($_POST["medProviderNumber"]);

        // Display all patient's detail from our database
        $patientDetail = $patient->getPatientDetailById($patient_id);

        // Add new medical provider in the database
        $resultsMedProvider = $patient->addMedicalProvider($newMedicalProviderName, $newMedicalProviderNumber, $patient_id, $user_id);

        // Check for errors
        if (isset($resultsMedProvider['errors'])) {

            // Combine to all erros to a string with a delimeter of (,)
            $myArrayresultsErrorsMessage = implode(",", $resultsMedProvider['errors']);
            $unSuccessfulMessage = $myArrayresultsErrorsMessage;

            echo
            "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
            $unSuccessfulMessage
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";

            // Display all patient's detail from our database
            $patientDetail = $patient->getPatientDetailById($patient_id);
            // Display Medical provider
            $providerDetail = $patient->getProviderDetail($patient_id);
        } else {

            $successfulMessage = "Medical provider added successfully!";
            echo "<p class='alert alert-success' id='successfulMessage'>$successfulMessage</p>";

            // Hide the message after 5 seconds
            echo
            "<script>
                const successfulMessage = document.getElementById('successfulMessage');
                setTimeout(function() {
                    successfulMessage.style.display = 'none';
                }, 5000);
            </script>";

            // Display all patient's detail from our database
            $patientDetail = $patient->getPatientDetailById($patient_id);
            // Display Medical provider
            $providerDetail = $patient->getProviderDetail($patient_id);
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

        // Display all patient's detail from our database
        $patientDetail = $patient->getPatientDetailById($patient_id);
        // Display Medical provider
        $providerDetail = $patient->getProviderDetail($patient_id);
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

    // Display all patient's detail from our database
    $patientDetail = $patient->getPatientDetailById($patient_id);
    // Display Medical provider
    $providerDetail = $patient->getProviderDetail($patient_id);
}


// // Add diagnosis
// $resultsDiagnosis = null;
// $newDx_text = null;
// $newName_of_doctor = null;

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (isset($_POST['submitDiagnosis'])) {
//         $newDx_text = trim(strtolower($_POST["dx_text"]));
//         $newName_of_doctor = trim($_POST["name_of_doctor"]);
//         $patient_id = $_POST['patient_ID'];
//         // $user_id = $_POST['user_ID'];

//         // Add new medical provider in the database
//         $resultsDiagnosis = $patient->addDiagnosis($newDx_text, $newName_of_doctor, $patient_id, $user_id);

//         // Display all patient's detail from our database
//         $patientDetail = $patient->getPatientDetailById($patient_id);

//         // Check for errors
//         if (isset($resultsDiagnosis['errors'])) {

//             // Combine to all erros to a string with a delimeter of (,)
//             $myArrayresultsErrorsMessage = implode(",", $resultsDiagnosis['errors']);
//             $unSuccessfulMessage = $myArrayresultsErrorsMessage;

//             echo
//             "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
//             $unSuccessfulMessage
//             <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
//             </div>";
//         } else {

//             $successfulMessage = "Medical provider added successfully!";
//             echo "<p class='alert alert-success' id='successfulMessage'>$successfulMessage</p>";

//             // Hide the message after 5 seconds
//             echo
//             "<script>
//                 const successfulMessage = document.getElementById('successfulMessage');
//                 setTimeout(function() {
//                     successfulMessage.style.display = 'none';
//                 }, 5000);
//             </script>";
//         }
//     } else {
//         $unSuccessfulMessage = "Error occured during execution!";
//         echo "<p class='alert alert-warning' id='successfulMessage'>$unSuccessfulMessage</p>";
//         // Hide the message after 5 seconds
//         echo
//         "<script>
//             const successfulMessage = document.getElementById('successfulMessage');
//             setTimeout(function() {
//                 successfulMessage.style.display = 'none';
//             }, 5000);
//         </script>";
//     }
// } else {
//      // Display all patient's detail from our database
//      $patientDetail = $patient->getPatientDetailById($patient_id);

//     $unSuccessfulMessage = "Error occured during execution!";
//     echo "<p class='alert alert-warning' id='successfulMessage'>$unSuccessfulMessage</p>";
//     // Hide the message after 5 seconds
//     echo
//     "<script>
//         const successfulMessage = document.getElementById('successfulMessage');
//         setTimeout(function() {
//             successfulMessage.style.display = 'none';
//         }, 5000);
//     </script>";
// }

$site_name = "iMed";

// create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(
    "view-patient-profile.html.twig",
    [
        //Pass all variables to be used
        "page_title" => "Patient details",
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
        "resultsMedProvider" => $resultsMedProvider,
        "newMedicalProviderName" => $newMedicalProviderName,
        "newMedicalProviderNumber" => $newMedicalProviderNumber,
        "patient_id" => $patient_id,
        "successfulMessage" => $successfulMessage,

        "providerDetail" => $providerDetail,
        //"resultsDiagnosis" => $resultsDiagnosis,
    ]
);