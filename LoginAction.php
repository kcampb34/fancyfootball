
<?php
require "dbConnect.php";

session_start();

// Retrieve login form data
$user = $_POST["user"];
$pswd = $_POST["pswd"];

// Prepare SQL query to fetch user details based on username
$sql = "SELECT userID, firstname, lastname, usertype, password FROM user WHERE username = ?";
$result = LoginDB($sql, $user);

// Check if the query returned any results
if (is_array($result) && count($result) > 0) {
    $row = $result[0];

    // Use password_verify to check if the provided password matches the stored hashed password
    if (password_verify($pswd, $row['password'])) {
        // Successful login, store session variables
        $_SESSION['userID'] = $row['userID'];
        $_SESSION['name'] = $row['firstname'] . " " . $row['lastname'];
        $_SESSION['usertype'] = $row['usertype'];

        // Redirect based on user type
        if ($row['usertype'] == 1) {
            // Admin user, redirect to admin page
            header("Location: admin.php");
        } else {
            // Regular user, redirect to user profile page
            header("Location: userP.php");
        }
        exit;
    } else {
        // Invalid password, redirect with an error message
        header("Location: index.php?msg=" . urlencode("Invalid password."));
        exit;
    }
} else {
    // No user found with the provided username
    header("Location: index.php?msg=" . urlencode("User not found."));
    exit;
}

