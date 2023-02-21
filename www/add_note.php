<?php

// enable composer autoloading
require("vendor/autoload.php");

use imed\Note;
use imed\Session;

// Session class
$user_id = null;
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

$note = new Note();
$result =  null;
$newNote = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && (('user_email') != null)) {
    $newNote = trim($_POST["addingNote"]);
    $result = $note->addNote($newNote, $user_id);

    // echo "<script>
    // alert('Note added successfully!');
    // window.location.href='index.php';
    // </script>";

    header('Location: index.php');
} else {
    // echo "<script>
    // alert('Error occured during execution!);
    // window.location.href='index.php';
    // </script>";

    header('Location: test2.php');
}

$site_name = "iMed";

// Create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(

    "home.html.twig",
    [
        "user_id" => $user_id,
        "user_email" => $user_email,
        "result" => $result,

        "newNote" => $newNote,
        
    ]
);

 