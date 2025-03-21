<?php
  // Set expiration date and time (YYYY-MM-DD HH:MM:SS format)
  $expireDateTime = strtotime("2025-04-13 12:00:00"); // Change to your desired date & time
  $currentDateTime = time();

  // If the time has passed, prevent file inclusion
  if ($currentDateTime >= $expireDateTime) {
      die("Access to this service is no longer available. Please contact the administrator.");
  }
session_start();
//Database Config
define("H", "localhost");
define("U", "root");
define("P", "");
define("DB", "hardwarecore_db");
define("URL", "http://localhost:8080/new_project/coffee-tracking-system/");
define("FILEPATH", "C:\xampp\htdocs\NEW_PROJECT\coffee-tracking-system");
date_default_timezone_set("Asia/Manila")

?>