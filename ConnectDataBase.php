<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "EduTrack";

//Create Connection
$connection = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check Connection
if($connection->connect_error){
    die("Connection Failed");
}
?>