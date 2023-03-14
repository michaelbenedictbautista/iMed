<?php
// enable composer autoloading
require("vendor/autoload.php");

use imed\Note;

$note = new Note();
$detailText = null;
$detailInfo = array();
if (isset($_POST["note_ID"])) {
    $note_id = $_POST['note_ID'];
    $detail = $note->getNoteDetail($note_id);
    //$detailText = $detail['note_text'];
    $detailInfo["detailText"] = $detail['note_text'];
    $detailInfo["detailID"] = $detail['note_ID'];

    //   echo "<p class='alert alert-danger'>$note_id</p>";
}

//echo $detailText;
echo json_encode(array('detailInfo' => $detailInfo));

// $loader = new \Twig\Loader\FilesystemLoader("templates");
// $twig = new Twig\Environment( $loader, [ "cache" => false ] );
// echo $twig -> render("test.html.twig");
// test