<?php

// enable composer autoloading
require("vendor/autoload.php");

$targetPath = null;
$newtargetPath = null;

if (is_array($_FILES)) {
    if (is_uploaded_file($_FILES['userImage']['tmp_name'])) {
        $sourcePath = $_FILES['userImage']['tmp_name'];
        $targetPath = "img/extra_images/" . $_FILES['userImage']['name'];
        if (move_uploaded_file($sourcePath, $targetPath)) {

            // echo $targetPath;
            $newtargetPath = $targetPath;
        }
    }
}

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