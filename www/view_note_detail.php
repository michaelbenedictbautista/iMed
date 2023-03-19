<?php
// Enable composer autoloading
require("vendor/autoload.php");

use imed\Note;

// Create instance of Note class and declare variables
$note = new Note();
$noteDetail = array();

// Set timezone to Sydney Australia
date_default_timezone_set('Australia/Sydney');

// Check if noteID is being receive.
if (isset($_POST["note_ID"])) {
    $note_id = $_POST['note_ID'];
    $detail = $note->getNoteDetail($note_id);
    $noteDetail["note_text"] = $detail['note_text'];
    $noteDetail["note_ID"] = $detail['note_ID'];
    $noteDetail["first_name"] = $detail['first_name'];
    $noteDetail["last_name"] = $detail['last_name'];
    $noteDetail["profession"] = $detail['profession'];
    // $noteDetail["updated_date"] = $detail['updated_date'];

    // Convert a specific date and time to Sydney
    $original_datetime = new DateTime($detail['updated_date'], new DateTimeZone('UTC'));
    $converted_datetime = clone $original_datetime;
    $converted_datetime->setTimezone(new DateTimeZone('Australia/Sydney'));
    $noteDetail["updated_date"] = $converted_datetime->format('d/m/Y | h:ia');
}
// pass variable for display
echo json_encode(array('noteDetail' => $noteDetail));