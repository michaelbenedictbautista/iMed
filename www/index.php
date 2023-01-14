<?php
// Enable composer autoloading
require("vendor/autoload.php");

// Request classes from autoloader
use imed\Session;
use imed\Search;

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
  $user_ins_ID = Session::get("user_ins_ID");
  $user_ins_name = Session::get("user_ins_name");
  $user_ins_add = Session::get("user_ins_add");
}


//Restaurant class
// $restaurant = new Restaurant();
// $items = $restaurant->getItems();

$site_name = "Restaurant Review Expert";


//Instantiate Search class
// $search = new Search();
// $categories = $search->getCategories();

// Create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(
  "home.html.twig",
  [
    "page_title" => "iMed",
    "greeting" => "Welcome to expert review restaurant webpage",
    //"restaurants" => $items,
    "site_name" => $site_name,

    // nav category pull down menu
    //"categories" => $categories,

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
  ]
);