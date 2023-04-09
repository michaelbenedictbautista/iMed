<?php
// enable composer autoloading
require("vendor/autoload.php");

use imed\Note;

// $note = new Note();
// $detailText = null;
// $detailInfo = array();
// if (isset($_POST["note_ID"])) {
//     $note_id = $_POST['note_ID'];
//     $detail = $note->getNoteDetail($note_id);
//     //$detailText = $detail['note_text'];
//     $detailInfo["detailText"] = $detail['note_text'];
//     $detailInfo["detailID"] = $detail['note_ID'];
//     $detailInfo["detailFirstName"] = $detail['first_name'];

//     //   echo "<p class='alert alert-danger'>$note_id</p>";
// }


// echo $detailText;
// echo json_encode(array('detailInfo' => $detailInfo));


// $targetPath = null;
// $newtargetPath = null;

// if (is_array($_FILES)) {
//     if (is_uploaded_file($_FILES['userImage']['tmp_name'])) {
//         $sourcePath = $_FILES['userImage']['tmp_name'];
//         $targetPath = "img/extra_images/" . $_FILES['userImage']['name'];
//         if (move_uploaded_file($sourcePath, $targetPath)) {

//             echo $targetPath;
//             $newtargetPath = $targetPath;
//         }
//     }
// }

// if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
//     $searchedName = trim(strtolower($_POST["inputName"]));

//     // Check if submit button was clicked nd serach box is not empty or null
//     if (isset($_POST['searchBtn']) && ($_POST["inputName"] != "" || $_POST["inputName"] != null)) {


//         $search_result = $patient->getAllPatientByName($searchedName, $searchedName);
//         $search_result_count = count($search_result);
//         if ($search_result_count <= 0) {

//             $notFoundMessage = "No patient found!";
//             //  header('Location: patient.php');
//         } else {
//             $notFoundMessage = null;
//         }
//     } else {
//         echo "<p class='alert alert-danger'>Search box cannot be empty!</p>";
//     }
// }


// $status_result = null;
// $status_result_count = null;





$site_name = "iMed";

$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(

    "test.html.twig",
    [

        "page_title" => "Add Patient",
        "site_name" => $site_name,

        // Session after login
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

        "targetPath" => $targetPath,
        "newtargetPath" => $newtargetPath

    ]
);