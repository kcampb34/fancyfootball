<?php 
include 'header.php';

// Ensure session is only started if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check user type
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != 0) {
    header("Location: index.php");
    exit;
}
?>