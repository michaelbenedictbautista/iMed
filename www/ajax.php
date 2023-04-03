<?php
// Enable composer autoloading
require("vendor/autoload.php");

use imed\Patient;

// Create instance of Note class and declare variables
$patient = new Patient();
$providerDetail = array();

// Set timezone to Sydney Australia
date_default_timezone_set('Australia/Sydney');

// Check if noteID is being receive.
if (isset($_POST["patient_ID"])) {
    $patient_id = $_POST["patient_ID"];
    $providerDetail = $patient->getProviderDetail($patient_id);
    $providerDetail["mp_name"] = $providerDetail['mp_name'];
    $providerDetail["med_number"] = $providerDetail['med_number'];
    $providerDetail["patient_ID"] = $providerDetail['patient_ID'];
    $providerDetail["first_name"] = $providerDetail['first_name'];
    $providerDetail["last_name"] = $providerDetail['last_name'];
    $providerDetail["profession"] = $providerDetail['profession'];
    // $providerDetail["updated_date"] = $providerDetail['updated_date'];
    // $noteDetail["updated_date"] = $detail['updated_date'];

    // Convert a specific date and time to Sydney
    $original_datetime = new DateTime($providerDetail['updated_date'], new DateTimeZone('UTC'));
    $converted_datetime = clone $original_datetime;
    $converted_datetime->setTimezone(new DateTimeZone('Australia/Sydney'));
    $providerDetail["updated_date"] = $converted_datetime->format('d/m/Y | h:ia');

    // pass variable for display
    echo json_encode(array('providerDetail' => $providerDetail));
}
