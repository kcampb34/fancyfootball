<?php
require "dbConnect.php";

$user = $_POST["user"];
$pswd = $_POST["pswd"];

$sql = "SELECT userID, firstname, lastname, usertype FROM user WHERE username = ? AND password = ?";
$result = LoginDB($sql, $user, $pswd);

if (is_array($result) && count($result) > 0) {
    // Fetch the first matching row
    $row = $result[0];
    $userID = $row['userID'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $usertype = $row['usertype'];

    session_start();
    $_SESSION['userID'] = $userID;
    $_SESSION['name'] = $firstname . " " . $lastname;
    $_SESSION['usertype'] = $usertype;

    if ($usertype == 1) {
        header("location:admin.php");
    } else {
        header("location:userP.php");
    }
    exit;
} else {
    // Redirect with an error message
    header("location:index.php?msg=" . (is_string($result) ? urlencode($result) : "Login Failed"));
    exit;
}
?>
