<?php
include 'header.php';
require 'dbConnect.php'; 

// Get user inputs
$user = trim(htmlspecialchars($_GET['user']));
$fname = trim(htmlspecialchars($_GET['fname']));
$lname = trim(htmlspecialchars($_GET['lname']));
$pswd = $_GET['pswd'];
$pswd2 = $_GET['pswd2'];
$email = trim(htmlspecialchars($_GET['email']));

// Redirect with field-specific error messages
function redirectWithError($field, $message) {
    header("Location: signup.php?error_{$field}=" . urlencode($message));
    exit();
}

// Validate passwords match
if ($pswd !== $pswd2) {
    redirectWithError("password", "Passwords do not match.");
}

// Open database connection
$message = openDB();
if ($message !== "Connected") {
    redirectWithError("general", "Database connection failed.");
}

global $conn; 

try {
    // Check if username already exists
    $sql_check_user = "SELECT username FROM user WHERE username = :username";
    $stmt = $conn->prepare($sql_check_user);
    $stmt->bindParam(':username', $user, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        redirectWithError("user", "Username already exists.");
    }

    // Check if email already exists
    $sql_check_email = "SELECT email FROM user WHERE email = :email";
    $stmt = $conn->prepare($sql_check_email);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        redirectWithError("email", "Email already in use.");
    }

    // Hash the password before storing
    $password = password($pswd, PASSWORD_DEFAULT);

    // Insert new user
    $sql_insert = "INSERT INTO user (username, firstname, lastname, password, email) 
                   VALUES (:username, :firstname, :lastname, :password, :email)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bindParam(':username', $user, PDO::PARAM_STR);
    $stmt->bindParam(':firstname', $fname, PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $lname, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header("Location: signup.php?success=Registration successful!");
        exit();
    } else {
        redirectWithError("general", "Could not register user.");
    }
} catch (PDOException $e) {
    redirectWithError("general", "Error: " . $e->getMessage());
} finally {
    closeDB();
}
?>
