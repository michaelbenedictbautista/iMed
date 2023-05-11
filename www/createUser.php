<?php
// enable composer autoloading
require("vendor/autoload.php");

use imed\Session;
use imed\Account;

$account = new Account();
$result = null;

// Session class
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
    $user_ins_name = Session::get("user_ins_name");
    $user_ins_add = Session::get("user_ins_add");
}

// Set variable after creating new user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_user_firstName = trim(strtolower($_POST["firstName"]));
    $new_user_lastName = trim(strtolower($_POST["lastName"]));
    $new_user_userName = trim(strtolower($_POST["userName"]));
    $new_user_email = trim(strtolower($_POST["email"]));
    $new_user_pw = trim($_POST["password"]);
    $new_user_contact = trim($_POST["contactNumber"]);
    $new_user_profession = trim(strtolower($_POST["profession"]));
    $new_user_level = $_POST["userLevel"];
    // $new_user_ins_ID = $_GET["ins_ID"];
    //$new_user_ins_name = trim(strtolower($_POST["institutionName"]));
    //$new_user_ins_add = trim(strtolower($_POST["institutionAddress"]));

    if ($_POST["institutionName"] == "others") {
        $new_user_ins_name = trim(strtolower($_POST["institutionNameOther"]));
        $new_user_ins_add = trim(strtolower($_POST["institutionAddressOther"]));
    } else {
        $new_user_ins_name = trim(strtolower($_POST["institutionName"]));
        $new_user_ins_add = null;
    }

    //$new_user_ins_add = trim(strtolower($_POST["institutionAddress"]));


    // $file = $_FILES['formFile'];
    // $fileName = $file['name'];
    // $fileSize = $file['size'];
    // $fileError = $file['error'];
    // $fileType = $file['type'];

    // Declare the values for update a thumbnail
    $file = $_FILES['formFile'];
    $tmp_file = $_FILES['formFile']['tmp_name'];
    $fileName = $file['name'];
    $fileError = $file['error'];

    // Check the fileName
    if (!empty($fileName)) {
        // Find "." and separate into the array 
        $fileExt = explode('.', $fileName);
        // Find the last element in the array -> make it lower case 
        $fileActualExt = strtolower(end($fileExt));
        // make array to accept file type ---------
        $fileAllowed = array('jpg', 'jpeg', 'png');
        // Check the condition 
        if (in_array($fileActualExt, $fileAllowed)) {
            // Check for error
            if ($fileError === 0) {

                // Rename the file
                $fileName = $user_id . '_' . time() . '_' . str_replace(array('!', "@", '#', '$', '%', '^', '&', ' ', '*', '(', ')', ':', ';', ',', '?', '/' . '\\', '~', '`', '-'), '_', strtolower($fileName));

                // Save file to folder
                if (move_uploaded_file($tmp_file, 'img/user/' . $fileName)) {
                    try {
                        // Insert the data
                        $result = $account->createUser($new_user_firstName, $new_user_lastName, $new_user_userName, $new_user_pw, $new_user_contact, $new_user_email, $new_user_profession, $new_user_level, $fileName, $new_user_ins_name, $new_user_ins_add);

                        echo "<script>
                        alert('User added successfully!');
                        window.location.href='userdashboard.php';
                        </script>";
                    } catch (Exception $e) {

                        echo $e->getMessage();
                    }
                } else {
                    echo "<p class='alert alert-danger'>Choose file to upload.</p>";
                }
            } else {
                echo "<script>
                alert('Error adding new user!');
                window.location.href='userdashboard.php';
                </script>";
            }
        }
    } else {
        $fileName = "default.jpg";
        $result = $account->createUser($new_user_firstName, $new_user_lastName, $new_user_userName, $new_user_pw, $new_user_contact, $new_user_email, $new_user_profession, $new_user_level, $fileName, $new_user_ins_name, $new_user_ins_add);
        echo "<script>
            alert('User added successfully!');
            window.location.href='userdashboard.php';
            </script>";
    }
}

$institution = $account->getAllInstitution();


$site_name = "iMed";

// create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(

    "createUser.html.twig",
    [
        // Pass all variables to be used
        "page_title" => "Create New User",
        "site_name" => $site_name,

        "result" => $result,
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
        "user_ins_name" => $user_ins_name,
        "user_ins_add" => $user_ins_add,

        "institution" => $institution,
    ]
);