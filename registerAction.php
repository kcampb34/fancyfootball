<?php
include 'header.php';
require 'dbConnect.php'; // Assumes dbConnect.php contains openDB(), closeDB(), and modifyDB() functions.

$servername = "localhost";
$dbname = "fantasyhelper";
$username = "Braeden";
$password = "Kenny";

// Get user inputs
$user = htmlspecialchars($_GET['user']);
$fname = htmlspecialchars($_GET['fname']);
$lname = htmlspecialchars($_GET['lname']);
$pswd = htmlspecialchars($_GET['pswd']);
$pswd2 = htmlspecialchars($_GET['pswd2']);
$email = htmlspecialchars($_GET['email']);


$sql = "INSERT INTO user (username, firstname, lastname, password, email) 
        VALUES ('$user', '$fname', '$lname', '$pswd', '$email')";


$result = ModifyDB($servername, $dbname, $username, $password, $sql);


echo $result;
?>