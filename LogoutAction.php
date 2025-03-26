<?php

clearstatcache();
session_start();
unset($_SESSION['userID']);
unset($_SESSION['name']);
unset($_SESSION['usertype']);
header("Location:index.php");
?>
