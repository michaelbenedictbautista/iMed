<?php
// enable composer autoloading
require("vendor/autoload.php");

use imed\Account;
use imed\Session;

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

$account = new Account();
$result = $account->deleteAccount($user_id);

if ($result["success"] == true) {
    // Unset variable after when user log out
    $user_id = Session::unset("user_id");
    $user_lastName = Session::unset("user_lastName");
    $user_pw = Session::unset("user_pw");
    $user_firstName = Session::unset("user_firstName");
    $user_lastName = Session::unset("user_lastName");
    $user_contact = Session::unset("user_contact");
    $user_email = Session::unset("user_email");
    $user_profession = Session::unset("user_profession");
    $user_level = Session::unset("user_level");
    $user_image = Session::unset("user_image");
    $user_ins_ID = Session::unset("user_ins_ID");
    $user_ins_name = Session::unset("user_ins_name");
    $user_ins_add = Session::unset("user_ins_add");

    header('Location: signin.php');
}


// create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(

    "signin.html.twig",
    [
        //Pass all variables to be used
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
    ]
);