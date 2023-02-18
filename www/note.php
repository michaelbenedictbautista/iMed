<?php

// enable composer autoloading
require("vendor/autoload.php");

use imed\Note;
use imed\Session;

// Instantiate Note class
$note = new Note();
$notes = $note->getNotes();
 