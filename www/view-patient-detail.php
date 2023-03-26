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
// Create instance of Note class and declare variables
$patient = new Patient();
$patientDetail = array();

// Set timezone to Sydney Australia
date_default_timezone_set('Australia/Sydney');

// Check if noteID is being receive.
if (isset($_POST["patient_ID"])) {
    $patient_id = $_POST['patient_ID'];
    $patientDetail = $patient->getPatientDetailById($patient_id);
}


$site_name = "iMed";

// create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(
    "view-patient-detail.html.twig",
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
    ]
);