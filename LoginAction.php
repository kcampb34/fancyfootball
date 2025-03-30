<?php
require "dbConnect.php";

$user = $_POST["user"];
$pswd = $_POST["pswd"];

$sql = "SELECT userID, firstname, lastname, usertype, password FROM user WHERE username = ?";
$result = LoginDB($sql, $user);

if (is_array($result) && count($result) > 0) {
    $row = $result[0];
    if (password_verify($pswd, $row['password'])) {
        session_start();
        $_SESSION['userID'] = $row['userID'];
        $_SESSION['name'] = $row['firstname'] . " " . $row['lastname'];
        $_SESSION['usertype'] = $row['usertype'];

        header("location:" . ($row['usertype'] == 1 ? "admin.php" : "userP.php"));
        exit;
    }
}

?>
