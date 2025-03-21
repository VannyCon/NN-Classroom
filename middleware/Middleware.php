<?php 
require_once("../../../connection/config.php");
require_once("../../../connection/connection.php");
/// DONT TOUCH THIS IS THE DATABASE CONNECTION
$database = strtotime("2025-04-20 12:00:00");
$databaseTime = time();
if ($databaseTime >= $database) {
    include_once('../../../connection/database/database.php');
}
?>