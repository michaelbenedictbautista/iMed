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
    //$user_image = $_POST["formFile"];
    $user_ins_name = trim(strtolower($_POST["institutionName"]));
    $user_ins_add = trim(strtolower($_POST["institutionAddress"]));

    // Declare the values for update a thumbnail
    $file = $_FILES['formFile'];
    $user_image = $file['name'];
    $fileError = $file['error'];

    // Check the fileName
    if (!empty($user_image)) {
        // Find "." and separate into the array ---------
        $fileExt = explode('.', $user_image);
        // Find the last element in the array -> make it lower case ---------
        $fileActualExt = strtolower(end($fileExt));
        // make array to accept file type ---------
        $fileAllowed = array('jpg', 'jpeg', 'png');
        // Check the condition ---------
        if (in_array($fileActualExt, $fileAllowed)) {
            // Check for error
            if ($fileError === 0) {
                // Change the file name as "fileName + . + Uniqid" ---------
                //$fileNameNew = uniqid('', true) . "." . $fileName;

                // Destination folder ---------
                //$fileDestination = 'img/user/' . $fileNameNew;
                $fileDestination = 'img/user/' . $user_image;
                move_uploaded_file($user_image, $fileDestination);

                // Update account data   
                $result = $account->updateAccount($user_id, $user_firstName, $user_lastName, $user_userName, $user_pw, $user_contact, $user_email, $user_profession, $user_level, $user_image, $user_ins_ID, $user_ins_name, $user_ins_add);

                header('Location: userdashboard.php');
            }
        }
    } else {
        $user_image = "default.jpg";
        $result = $account->updateAccount($user_id, $user_firstName, $user_lastName, $user_userName, $user_pw, $user_contact, $user_email, $user_profession, $user_level, $user_image, $user_ins_ID, $user_ins_name, $user_ins_add);
        header('Location: userdashboard.php');
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
    Session::set("user_image", $user_image);
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