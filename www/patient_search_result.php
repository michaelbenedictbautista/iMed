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

$search_result = array();
$notFoundMessage = null;
$search_result_count = null;


$searchedName = "";
$statusSelected = "";

if (($_SERVER['REQUEST_METHOD'] == 'POST')) {

    // Check if submit button was clicked nd serach box is not empty or null
    if (isset($_POST['searchBtn']) && isset($_POST["inputName"]) || isset($_POST["statusSelected"])) {

        $searchedName = trim(strtolower($_POST["inputName"]));
        $statusSelected = trim(strtolower($_POST["statusSelected"]));

        if ($statusSelected == "all") {


            $search_result = $patient->getAllPatientByName($searchedName);
            $search_result_count = count($search_result);

            if ($search_result_count <= 0) {

                $notFoundMessage = "No patient found!";

                //  header('Location: patient.php');
            } else {
                $notFoundMessage = null;
            }
        } else

            $search_result = $patient->getAllPatientBySearchNameAndStatus($searchedName, $statusSelected);

        $search_result_count = count($search_result);

        if ($search_result_count <= 0) {

            $notFoundMessage = "No patient found!";

            //  header('Location: patient.php');
        } else {
            $notFoundMessage = null;
        }
    } else {
        echo "<p class='alert alert-danger'>Search box cannot be empty!</p>";
    }
}


$site_name = "iMed";

// create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(
    "patient_search_result.html.twig",
    [
        //Pass all variables to be used
        "page_title" => "Search result",
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

        "search_result" => $search_result,
        "statusSelected" => $statusSelected,
        "search_result_count" => $search_result_count,
        "notFoundMessage" => $notFoundMessage,

    ]
);