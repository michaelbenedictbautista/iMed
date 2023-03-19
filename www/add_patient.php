<?php

// enable composer autoloading
require("vendor/autoload.php");

use imed\Patient;
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
$newPatient =  null;

// Verify post method, user_id and user institution ID
if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($user_id != null) && ($user_ins_ID != null)) {

    // Check if submit button was clicked
    if (isset($_POST['submit'])) {
        $new_patient_firstName = trim(strtolower($_POST["firstName"]));
        $new_patient_lastName = trim(strtolower($_POST["lastName"]));
        $new_patient_dob = trim(strtolower($_POST["dob"]));
        $new_patient_age = $_POST["age"];
        $new_patient_gender = trim(strtolower($_POST["gender"]));
        $new_patient_status = trim(strtolower($_POST["status"]));
        $new_patient_er_response = trim(strtolower($_POST["er_response"]));
        $new_patient_allergy = trim(strtolower($_POST["allergy"]));
        if ($new_patient_allergy == "") {
            $new_patient_allergy = "no known allergies";
        }
        $new_patient_room = trim(strtolower($_POST["room"]));
        if ($new_patient_room == "") {
            $new_patient_room = "undefined";
        }

        // Rename the file
        $new_patient_image = $_FILES['file']['name'];
        $tmp_file = $_FILES['file']['tmp_name'];


        if (!empty($new_patient_image)) {
            //Create new filename and verify image file format

            // Find "." and separate into the array 
            $fileExt = explode('.', $new_patient_image);

            // Find the last element in the array -> make it lower case
            $fileActualExt = strtolower(end($fileExt));

            // allowing certain file format
            $fileAllowed = array('jpg', 'jpeg', 'png');


            if (in_array($fileActualExt, $fileAllowed)) {
                $new_patient_image = $user_id . '_' . time() . '_' . str_replace(array('!', "@", '#', '$', '%', '^', '&', ' ', '*', '(', ')', ':', ';', ',', '?', '/' . '\\', '~', '`', '-'), '_', strtolower($new_patient_image));

                // Save file to folder
                if (move_uploaded_file($tmp_file, 'img/patient/' . $new_patient_image)) {
                    try {

                        // TODO
                        $newPatient = $patient->createPatient($new_patient_firstName, $new_patient_lastName, $new_patient_dob, $new_patient_age, $new_patient_gender, $new_patient_status, $new_patient_er_response, $new_patient_allergy, $new_patient_room, $user_ins_ID, $user_id, $new_patient_image);

                        echo "<script>
                        alert('Patient added successfully!');
                        window.location.href='patient.php';
                        </script>";
                    } catch (Exception $e) {

                        echo $e->getMessage();
                    }
                } else {
                    echo "<p class='alert alert-danger'>Choose file to upload.</p>";
                }
            } else {
                echo "<script>
                    alert('Error adding new patient!');
                    window.location.href='add_patient.php';
                    </script>";
            }
        }
    }
}


$site_name = "iMed";

// Create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(

    "add_patient.html.twig",
    [
        // Pass all variables to be used
        "page_title" => "Add Patient",
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

        "newPatient" => $newPatient,

    ]
);