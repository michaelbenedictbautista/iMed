<?php
// Enable composer autoloading
require("vendor/autoload.php");

// Request classes from autoloader
use imed\Session;
use imed\Note;
use thiagoalessio\TesseractOCR\TesseractOCR;

// Instantiate Session class
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

// Instantiate Note and display all notes dynamically
$note = new Note();
$notes = $note->getAllNotes();


// Convert text image into a new searchable text file
$fileRead = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Check if submit button was clicked
  if (isset($_POST['submit'])) {
    $file_name = $_FILES['file']['name'];
    $tmp_file = $_FILES['file']['tmp_name'];

    // Rename the file
    $file_name = $user_id . '_' . time() . '_' . str_replace(array('!', "@", '#', '$', '%', '^', '&', ' ', '*', '(', ')', ':', ';', ',', '?', '/' . '\\', '~', '`', '-'), '_', strtolower($file_name));

    if (move_uploaded_file($tmp_file, 'img/uploads/' . $file_name)) {
      try {

        //TODO 

        // Prepocessing of an image prior conversion
        $file = (new TesseractOCR('img/uploads/' . $file_name));
        $file->config('convert_to_grayscale', 'true');
        $file->config('image_resize', '1500');
        $file->config('preserve_interword_spaces', 'true');
        $file->config('language', 'eng');

        // Read text to images
        $fileRead = $file->run();

        
        // Delete the uploaded image after running
        unlink('img/uploads/' . $file_name);

      } catch (Exception $e) {
        //Handle error
        $errorMessage = $e->getMessage();
        // echo  $errorMessage;    
        "<p class='alert alert-danger'>$errorMessage</p>";
      }
    } else {
      echo "<p class='alert alert-danger'>Choose file to upload.</p>";
    }
  }
}


///////////////////////////////////////////
// $fileRead = null;
// if (isset($_POST['image'])) {
//   // decode the image data from base64
//   $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['image']));


//   // write the image data to a temporary file
//   // $tempFilePath = tempnam(sys_get_temp_dir('img/uploads/'), 'ocr-image-');
//   // file_put_contents($tempFilePath, $imageData);

//   $tmp_file = $_FILES['file']['tmp_name'];
//   if (move_uploaded_file($tmp_file, 'img/uploads/' . $imageData)) {
//      // create a TesseractOCR instance and set the image file path
//   $file = (new TesseractOCR('img/uploads/' . $imageData));
//   $file->config('convert_to_grayscale', 'true');
//   $file->config('image_resize', '1500');
//   $file->config('preserve_interword_spaces', 'true');
//   $file->config('language', 'eng');
//   $fileRead = $file->run();

//    // delete the temporary file
//    unlink('img/uploads/' . $imageData);
//   }

// }


////////////////////////////////////////////////

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   $tempFile = $_FILES['image']['tmp_name'];
//   $targetPath = 'img/uploads/';
//   $targetFile = $targetPath . uniqid() . '.png';
//   move_uploaded_file($tempFile, $targetFile);
//   echo 'File uploaded successfully.';
// } else {
//   echo "<p class='alert alert-danger'>Image.not received.</p>";
// }


$site_name = "iMed";

// Create twig environment
$loader = new \Twig\Loader\FilesystemLoader("templates");
$twig = new Twig\Environment($loader, ["cache" => false]);

echo $twig->render(
  "index.html.twig",
  [
    // Pass all variables to be used
    "page_title" => "iMed",
    "site_name" => $site_name,
    "greeting" => "Welcome to iMed",

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

    "notes" => $notes,
    "fileRead" => $fileRead,
  ]
);