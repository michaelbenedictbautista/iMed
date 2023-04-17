<?php
// Enable composer autoloading
require("vendor/autoload.php");

use thiagoalessio\TesseractOCR\TesseractOCR;
use imed\MedicalRecord;

//Declare and initialise variables
$fileRead = null;
$fileReadArray = array();
$errorMessage ="";
$errorMessagFilePut = 'Error saving file';
$errorMessagPostMethod = 'Error receiving dataUrl';

// Check for post method and dataUrl is receive
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dataUrl'])) {
    $dataUrl = $_POST['dataUrl'];
    $img = str_replace('data:image/png;base64,', '', $dataUrl);
    $img = str_replace(' ', '+', $img);
    $decoded = base64_decode($img);

    $targetPath = 'img/uploads/';
    $targetFile = $targetPath . uniqid() . '.png';

    //Optic character recognition process
    if (file_put_contents($targetFile, $decoded)) {
        try {
            // Prepocessing of an image prior image conversion
            $file = (new TesseractOCR($targetFile));
            $file->config('convert_to_grayscale', '1');
            $file->config('image_resize', '1500');          
            //$file->config('dpi', '500');          
            //$file->config('preserve_interword_spaces', 'true');
            $file->config('language', 'eng', 'jpn', 'spa');
            $file->threadLimit(1);
            $file->psm(6); // Assume a single uniform block of text.
            $file->oem(1); //Automatic page segmentation with OSD.
            $file->quiet();
           

            // Read text to images
            $fileRead = $file->run();

            // Extract the components, values, and ranges
            // preg_match_all('/([a-zA-Z\s]+)\s+([\d.]+)\s*(?:-\s*([\d.]+))?/', $fileRead, $matches, PREG_SET_ORDER);

            // iterate each components, values, and ranges
            // foreach ($matches as $match) {
            //     $fileReadArray['component'] = trim($match[1]);
            //     $fileReadArray['value'] = $match[2];
            //     $fileReadArray['range'] = isset($match[3]) ? "({$match[3]})" : '';
                
            // }
            
            
            // Tranfer back data to diplay result of converted image to text
            echo json_encode(['fileRead' => $fileRead]);
            //echo json_encode(array('fileReadArray' => $fileReadArray));
   
            // Delete the uploaded image after running OCR
            unlink($targetFile);
            
        } catch (Exception $e) {
            //Handle error
            // echo "<p class='alert alert-danger'>Unable to save image!</p>";
            $errorMessage = $e->getMessage();
            echo  $errorMessage;             
        }
    } else {
        $errorMessage = "File cannot be save!";
        echo  $errorMessage;
        
    }


} else {
    // echo "<p class='alert alert-danger'>Image not received.</p>";   
    $errorMessage = "Uploading image error!";
    echo  $errorMessage;
}

//Declare variables
$medicalRecord = new MedicalRecord();
$medicalRecordDetail = array();

//Check if patient_ID is being receive from add medical auto
if (isset($_GET["patient_ID"])) {
    $patient_ID = $_GET["patient_ID"];
    if(isset($_GET["user_ID"])) {
    $user_ID = $_GET["user_ID"];
    $medicalRecordDetail = $medicalRecord->addMedicalRecord($mr_time, $mr_title, $mr_result, $mr_file, $mr_text, $patient_ID, $user_ID);
    $medicalRecordDetail["mr_ID"] = $medicalRecordDetail['mr_ID'];
    $medicalRecordDetail["mr_title"] = $medicalRecordDetail['mr_title'];
    $medicalRecordDetail["mr_result"] = $medicalRecordDetail['mr_result'];
    $medicalRecordDetail["mr_file"] = $medicalRecordDetail['mr_file'];
    $medicalRecordDetail["mr_text"] = $medicalRecordDetail['mr_text'];
    
 
    $medicalRecordDetail["first_name"] = $medicalRecordDetail['first_name'];
    $medicalRecordDetail["last_name"] = $medicalRecordDetail['last_name'];
    $medicalRecordDetail["profession"] = $medicalRecordDetail['profession'];

    // Convert a specific date and time to Sydney
    $original_datetime = new DateTime($medicalRecordDetail['updated_date'], new DateTimeZone('UTC'));
    $converted_datetime = clone $original_datetime;
    $converted_datetime->setTimezone(new DateTimeZone('Australia/Sydney'));
    $medicalRecordDetail["updated_date"] = $converted_datetime->format('d/m/Y | h:ia');

    // pass variable for display
    echo json_encode(array('medicalRecordDetail' => $medicalRecordDetail));
    }
    
}