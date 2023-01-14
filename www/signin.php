<?php

require("vendor/autoload.php"); // Enable composer autoloading

use imed\Account;
use imed\Session;

$account = new Account();

$result = null;
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
$user_ins_ID = null;
$user_ins_name = null;
$user_ins_add = null;

// Set variable after successful log in
//if ($_SERVER["REQUEST_METHOD"] == "POST")
if (isset($_POST['signin'])) {
    $user_email = $_POST["email"];
    $user_pw = $_POST["password"];
    if (strlen($user_email) > 0 && strlen($user_pw) > 0) {
        $result = $account->login($user_email, $user_pw);
        if ($result["success"] == true) {
            Session::set("user_id", $result["id"]);
            Session::set("user_userName", $result["uName"]);
            Session::set("user_pw", $result["password"]);
            Session::set("user_firstName", $result["fName"]);
            Session::set("user_lastName", $result["lName"]);
            Session::set("user_contact", $result["contact"]);
            Session::set("user_email", $result['email']);
            Session::set("user_profession", $result['profession']);
            Session::set("user_level", $result['user_level']);
            Session::set("user_image", $result['image']);
            Session::set("user_ins_ID", $result['ins_ID']);
            Session::set("user_ins_name", $result['ins_name']);
            Session::set("user_ins_add", $result['ins_add']);

            if ($result['user_level'] == 1) {
                header('Location: userdashboard.php');
            } else {
                header('Location: /');
            }
        }
    }
}

$site_name = "iMed";

// Create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(

    "signin.html.twig",
    [
        "page_title" => "Sign in",
        "site_name" => $site_name,

        // Session after login. Setting user accountdata
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
        "user_ins_ID" => $user_ins_ID,
        "user_ins_name" => $user_ins_name,
        "user_ins_add" => $user_ins_add,

    ]
);
