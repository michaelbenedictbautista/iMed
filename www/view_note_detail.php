<?php
// Enable composer autoloading
require("vendor/autoload.php");

use imed\Note;

// Create instance of Note class and declare variables
$note = new Note();
$noteDetail = array();

// Check if noteID is being receive.
if (isset($_POST["note_ID"])) {
    $note_id = $_POST['note_ID'];
    $detail = $note->getNoteDetail($note_id);
    $noteDetail["note_text"] = $detail['note_text'];
    $noteDetail["note_ID"] = $detail['note_ID'];
    $noteDetail["first_name"] = $detail['first_name'];
    $noteDetail["last_name"] = $detail['last_name'];
    $noteDetail["profession"] = $detail['profession'];
}

echo json_encode(array('noteDetail' => $noteDetail));
