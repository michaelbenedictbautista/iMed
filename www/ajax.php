<?php
// Enable composer autoloading
require("vendor/autoload.php");

use imed\Note;
use imed\Patient;
use imed\ProgressNote;
use imed\VitalSigns;

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

    // pass variable for display
    echo json_encode(array('noteDetail' => $noteDetail));
}

// Create instance of Note class and declare variables
$patient = new Patient();
$providerDetail = array();

// Set timezone to Sydney Australia
date_default_timezone_set('Australia/Sydney');

// Check if patient_ID is being receive from medical provider
if (isset($_POST["patient_ID"])) {
    $patient_id = $_POST["patient_ID"];
    $providerDetail = $patient->getProviderDetail($patient_id);
    $providerDetail["mp_name"] = $providerDetail['mp_name'];
    $providerDetail["med_number"] = $providerDetail['med_number'];
    $providerDetail["patient_ID"] = $providerDetail['patient_ID'];
    $providerDetail["first_name"] = $providerDetail['first_name'];
    $providerDetail["last_name"] = $providerDetail['last_name'];
    $providerDetail["profession"] = $providerDetail['profession'];

    // Convert a specific date and time to Sydney
    $original_datetime = new DateTime($providerDetail['updated_date'], new DateTimeZone('UTC'));
    $converted_datetime = clone $original_datetime;
    $converted_datetime->setTimezone(new DateTimeZone('Australia/Sydney'));
    $providerDetail["updated_date"] = $converted_datetime->format('d/m/Y | h:ia');

    // pass variable for display
    echo json_encode(array('providerDetail' => $providerDetail));
}

//Declare variable
$diagnosisDetail = array();

//Check if patient_ID is being receive diagnosis
if (isset($_POST["dx_patient_ID"])) {
    $dx_patient_ID = $_POST["dx_patient_ID"];
    $diagnosisDetail = $patient->getDignosisDetail($dx_patient_ID);
    $diagnosisDetail["dx_ID"] = $diagnosisDetail['dx_ID'];
    $diagnosisDetail["dx_text"] = $diagnosisDetail['dx_text'];
    $diagnosisDetail["name_of_doctor"] = $diagnosisDetail['name_of_doctor'];
    $diagnosisDetail["patient_ID"] = $diagnosisDetail['patient_ID'];
    $diagnosisDetail["first_name"] = $diagnosisDetail['first_name'];
    $diagnosisDetail["last_name"] = $diagnosisDetail['last_name'];
    $diagnosisDetail["profession"] = $diagnosisDetail['profession'];

    // Convert a specific date and time to Sydney
    $original_datetime = new DateTime($diagnosisDetail['updated_date'], new DateTimeZone('UTC'));
    $converted_datetime = clone $original_datetime;
    $converted_datetime->setTimezone(new DateTimeZone('Australia/Sydney'));
    $dignosisDetail["updated_date"] = $converted_datetime->format('d/m/Y | h:ia');

    // pass variable for display
    echo json_encode(array('diagnosisDetail' => $diagnosisDetail));
}

//Declare variable
$dietDetail = array();

//Check if patient_ID is being receive from diet
if (isset($_POST["diet_patient_ID"])) {
    $diet_patient_ID = $_POST["diet_patient_ID"];
    $dietDetail = $patient->getDietDetail($diet_patient_ID);
    $dietDetail["diet_ID"] = $dietDetail['diet_ID'];
    $dietDetail["diet_text"] = $dietDetail['diet_text'];
    $dietDetail["name_of_dietitian"] = $dietDetail['name_of_dietitian'];
    $dietDetail["patient_ID"] = $dietDetail['patient_ID'];
    $dietDetail["first_name"] = $dietDetail['first_name'];
    $dietDetail["last_name"] = $dietDetail['last_name'];
    $dietDetail["profession"] = $dietDetail['profession'];

    // Convert a specific date and time to Sydney
    $original_datetime = new DateTime($dietDetail['updated_date'], new DateTimeZone('UTC'));
    $converted_datetime = clone $original_datetime;
    $converted_datetime->setTimezone(new DateTimeZone('Australia/Sydney'));
    $dietDetail["updated_date"] = $converted_datetime->format('d/m/Y | h:ia');

    // pass variable for display
    echo json_encode(array('dietDetail' => $dietDetail));
}


//Declare variables
$progressNote = new ProgressNote();
$progressNoteDetail = array();

//Check if patient_ID is being receive from view-progress-note page
if (isset($_POST["prog_ID"])) {
    $progress_patient_ID = $_POST["prog_ID"];
    $progressNoteDetail = $progressNote->getProgNoteDetail($progress_patient_ID);
    $progressNoteDetail["prog_ID"] = $progressNoteDetail['prog_ID'];
    $progressNoteDetail["prog_text"] = $progressNoteDetail['prog_text'];
    $progressNoteDetail["patient_ID"] = $progressNoteDetail['patient_ID'];
    $progressNoteDetail["first_name"] = $progressNoteDetail['first_name'];
    $progressNoteDetail["last_name"] = $progressNoteDetail['last_name'];
    $progressNoteDetail["profession"] = $progressNoteDetail['profession'];

    // Convert a specific date and time to Sydney
    $original_datetime = new DateTime($progressNoteDetail['updated_date'], new DateTimeZone('UTC'));
    $converted_datetime = clone $original_datetime;
    $converted_datetime->setTimezone(new DateTimeZone('Australia/Sydney'));
    $progressNoteDetail["updated_date"] = $converted_datetime->format('d/m/Y | h:ia');

    // pass variable for display
    echo json_encode(array('progressNoteDetail' => $progressNoteDetail));
}


//Declare variables
$vitalSigns = new VitalSigns();
$vitalSignsDetail = array();

//Check if patient_ID is being receive from view-vital-signs- page
if (isset($_POST["vs_ID"])) {
    $vs_ID = $_POST["vs_ID"];
    $vitalSignsDetail = $vitalSigns->getVitalSignsDetail($vs_ID);
    $vitalSignsDetail["vs_ID"] = $vitalSignsDetail['vs_ID'];
    $vitalSignsDetail["time_of_obs"] = $vitalSignsDetail['time_of_obs'];
    $vitalSignsDetail["systolic"] = $vitalSignsDetail['systolic'];
    $vitalSignsDetail["diastolic"] = $vitalSignsDetail['diastolic'];
    $vitalSignsDetail["temperature"] = $vitalSignsDetail['temperature'];
    $vitalSignsDetail["pulse_rate"] = $vitalSignsDetail['pulse_rate'];
    $vitalSignsDetail["respiratory_rate"] = $vitalSignsDetail['respiratory_rate'];
    $vitalSignsDetail["oxygen_saturation"] = $vitalSignsDetail['oxygen_saturation'];
    $vitalSignsDetail["vs_text"] = $vitalSignsDetail['vs_text'];
    $vitalSignsDetail["updated_date"] = $vitalSignsDetail['updated_date'];


    $vitalSignsDetail["first_name"] = $vitalSignsDetail['first_name'];
    $vitalSignsDetail["last_name"] = $vitalSignsDetail['last_name'];
    $vitalSignsDetail["profession"] = $vitalSignsDetail['profession'];

    // Convert a specific date and time to Sydney
    $original_datetime = new DateTime($vitalSignsDetail['updated_date'], new DateTimeZone('UTC'));
    $converted_datetime = clone $original_datetime;
    $converted_datetime->setTimezone(new DateTimeZone('Australia/Sydney'));
    $vitalSignsDetail["updated_date"] = $converted_datetime->format('d/m/Y | h:ia');

    // pass variable for display
    echo json_encode(array('vitalSignsDetail' => $vitalSignsDetail));
}
