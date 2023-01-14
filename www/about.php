<?php
// enable composer autoloading
require("vendor/autoload.php");

//request classes from autoloader
use imed\Restaurant;
use imed\Search;
use imed\Session;

$restaurant = new Restaurant();
$items = $restaurant -> getItems();
$site_name = "Restaurant Review Expert";

// Session class
$user_email = Session::get("user_email");
$user_Id = Session::get("user_id");
$user_image = Session::get("user_image");

//Instantiate Search class
$search = new Search();
$categories = $search -> getCategories();

// Create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment( $loader, [ "cache" => false ] );

echo $twig -> render(
  "about.html.twig", 
  [
    "page_title" => "Restaurant Review Expert", 
    "greeting" => "Welcome to expert review restaurant webpage", 
    "restaurants" => $items,
    "site_name" => $site_name,

    // nav category pull down menu
    "categories" => $categories,

    //Session after login
    "user_email" => $user_email,
    "user_Id"=> $user_Id,
    "user_image" => $user_image
  ] );
?>