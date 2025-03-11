<?php
session_start();

// Include the database configuration file
include('../config.php');

// Check if the user is logged in as a student
if (isset($_SESSION["id"]) && $_SESSION["role"] == "student") {
    $id = $_SESSION["id"];

    echo $id ;

}   
    

    
?>
