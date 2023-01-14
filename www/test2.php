<?php
// enable composer autoloading
require("vendor/autoload.php");

$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment( $loader, [ "cache" => false ] );
echo $twig -> render("test2.html.twig");
// test
?>