<?php
// enable composer autoloading
require("vendor/autoload.php");

use imed\Session;
use imed\User;
use imed\Account;

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

//User class
$user = new User();
if ($user_level == 2) {
    $userDisplayLevel = 3;
} else {
    $userDisplayLevel = 1;
}

// Call funtion to display users base on their user levels
$items = $user->getAllUser($userDisplayLevel);

// Update user
$account = new Account();
$result =  null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($user_id))) {

    //Unset account data
    Session::unset("user_userName", $user_userName);
    Session::unset("user_pw", $user_pw);
    Session::unset("user_firstName", $user_firstName);
    Session::unset("user_lastName", $user_lastName);
    Session::unset("user_userName", $user_userName);
    Session::unset("user_contact", $user_contact);
    Session::unset("user_email", $user_email);
    Session::unset("user_profession", $user_profession);
    Session::unset("user_level", $user_level);
    //Session::unset("user_image", $user_image);
    Session::unset("user_image", $user_image);
    Session::unset("user_ins_name", $user_ins_name);
    Session::unset("user_ins_add", $user_ins_add);

    // Get variable('name') from Post method
    $user_firstName = trim(strtolower($_POST["firstName"]));
    $user_lastName = trim(strtolower($_POST["lastName"]));
    $user_userName = trim(strtolower($_POST["userName"]));
    $user_email = trim(strtolower($_POST["email"]));
    $user_pw = trim($_POST["password"]);
    $user_contact = trim($_POST["contactNumber"]);
    $user_profession = trim(strtolower($_POST["profession"]));
    $user_level = $_POST["userLevel"];
    $user_ins_name = trim(strtolower($_POST["institutionName"]));
    $user_ins_add = trim(strtolower($_POST["institutionAddress"]));

    // Declare the values for update a thumbnail
    $userProfilePic = $_FILES['userProfilePic'];
    $imageFileName = $userProfilePic['name'];
    $imageFileType = $userProfilePic['type'];
    $imageFileTempName = $userProfilePic['tmp_name'];
    $allowedTypes = array('image/jpeg', 'image/jpg','image/png', 'image/tiff'); // acceptable file extension
    $maxSize = 5 * 1024 * 1024; // 5MB max size of an image

    // Check the fileName
    if (!empty($imageFileName)) {
        // Check file type
        if (!in_array($imageFileType, $allowedTypes)) {
            echo 'Error: Invalid file type. Only JPEG, PNG, and TIFF files are allowed.';
            "<script>
                alert('Error occured during execution!);
                window.location.href='view-patient-medical-record.php?patient_ID=$patient_ID';
            </script>";
        }

        // Check file size
        if ($userProfilePic['size'] > $maxSize) {
            echo 'Error: File size exceeds 5MB limit.';
            "<script>
                alert('Error occured during execution!);
                window.location.href='view-patient-medical-record.php?patient_ID=$patient_ID';
            </script>";
        }

        // Check if file exists
        if (file_exists("img/user/$imageFileName")) {
            unlink("img/user/$imageFileName"); // Delete the old file
        }
        
        $imageFileExtension = pathinfo($imageFileName, PATHINFO_EXTENSION); // image extension
        $generatedImageFileName = uniqid() . '.' . $imageFileExtension; // rename file with unique name

        // Move uploaded file to desired location
        $uploadPath = 'img/user/' . $generatedImageFileName;
        
        if (move_uploaded_file($imageFileTempName, $uploadPath)) {
            try {
                // Update account function
                $result = $account->updateAccount($user_id, $user_firstName, $user_lastName, $user_userName, $user_pw, $user_contact, $user_email, $user_profession, $user_level, $generatedImageFileName, $user_ins_ID, $user_ins_name, $user_ins_add);
                echo 
                "<script>
                    alert('Edit account successfully uploaded!');
                    window.location.href='userdashboard.php';
                </script>";
            }catch (Exception $e) {
                echo
                "<script>
                    alert('Edit account unsuccessful! Try again!!!');
                    window.location.href='userdashboard.php';
                </script>";
            }
        }
    } else {
        $generatedImageFileName = "default.jpg";
        $result = $account->updateAccount($user_id, $user_firstName, $user_lastName, $user_userName, $user_pw, $user_contact, $user_email, $user_profession, $user_level, $generatedImageFileName, $user_ins_ID, $user_ins_name, $user_ins_add);
        
        echo 
        "<script>
            alert('Edit account successful!');
            window.location.href='userdashboard.php';
        </script>";
    }
    
    // Set account data
    Session::set("user_userName", $user_userName);
    Session::set("user_pw", $user_pw);
    Session::set("user_firstName", $user_firstName);
    Session::set("user_lastName", $user_lastName);
    Session::set("user_userName", $user_userName);
    Session::set("user_contact", $user_contact);
    Session::set("user_email", $user_email);
    Session::set("user_profession", $user_profession);
    Session::set("user_level", $user_level);
    Session::set("user_image", $generatedImageFileName);
    Session::set("user_ins_name", $user_ins_name);
    Session::set("user_ins_add", $user_ins_add);

    echo "<script>
    alert('Account updated successfully!');
    window.location.href='userdashboard.php';
    </script>";
}


$site_name = "iMed";

// create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(
    "userdashboard.html.twig",
    [
        //Pass all variables to be used
        "page_title" => "User dashboard",
        "site_name" => $site_name,

        "user_email" => $user_email,
        "result" => $result,

        "accounts" => $items,

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

        "userDisplayLevel" => $userDisplayLevel,
    ]
);