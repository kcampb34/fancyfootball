<?php 
include 'header.php';

// Ensure session is only started if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 
if ($_SESSION['usertype'] == 1) {
  header("Location:admin.php");
  exit;
}

// Check user type
if (!isset($_SESSION['usertype'])) {
    header("Location: index.php");
    exit;
}
?>