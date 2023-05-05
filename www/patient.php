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

// Display patient
$patient = new Patient();
$patients = $patient->getAllPatients();
$notFoundMessage = null;

// Display patient by search name
$searchedName = null;
$search_result_count = null;
$search_result = null;


if (isset($_GET['success']) && $_GET['success'] == 'true') {
    echo "<p class='alert alert-success' id='successfulMessage'>Patient added successfully!</p>";
    // Hide the message after 5 seconds
    echo
    "<script>
        const successfulMessage = document.getElementById('successfulMessage');
        setTimeout(function() {
            successfulMessage.style.display = 'none';
        }, 5000);
    </script>";
} else if (isset($_GET['success']) && $_GET['success'] == 'false'){
    $errorMessage = $_GET['errorMessage'];
    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>   
    $errorMessage
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>;
    ";    
}

$site_name = "iMed";

// create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(
    "patient.html.twig",
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

        "patients" => $patients,
        "search_result" => $search_result,
        "search_result_count" => $search_result_count,
        "notFoundMessage" => $notFoundMessage,

    ]
);