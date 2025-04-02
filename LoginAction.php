<?php
require "dbConnect.php";

session_start();

// Retrieve login form data
$user = $_POST["user"];
$pswd = $_POST["pswd"];

// Prepare SQL query to fetch user details based on username
$sql = "SELECT userID, firstname, lastname, usertype, password FROM user WHERE username = ? AND password = ?";
$result = LoginDB($sql, $user, $pswd);

// Check if the query returned any results
if (is_array($result) && count($result) > 0) {
    $row = $result[0];

    // Store user details in session
    $_SESSION['userID'] = $row['userID'];
    $_SESSION['name'] = $row['firstname'] . " " . $row['lastname'];
    $_SESSION['usertype'] = $row['usertype']; // ✅ Now correctly storing usertype

    // Redirect based on user type
    if ($row['usertype'] == 1) {
        header("Location: admin.php");
    } else {
        header("Location: userP.php");
    }
    exit;
} else {
    // No matching user found
    header("Location: index.php?msg=" . urlencode("Invalid username or password."));
    exit;
}
?>
