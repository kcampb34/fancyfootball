<?php
include 'header.php';
require 'dbConnect.php'; 

// Get user inputs
$user = trim(htmlspecialchars($_GET['user']));
$email = trim(htmlspecialchars($_GET['email']));
$securityQ = trim(htmlspecialchars($_GET['securityQ']));
$pswd = $_GET['pswd'];
$pswd2 = $_GET['pswd2'];

// Redirect with field-specific error messages
function redirectWithError($field, $message) {
    header("Location: forgotPassword.php?error_{$field}=" . urlencode($message));
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
    // Validate user and security question
    $sql_validate_user = "SELECT userID FROM user WHERE username = :username AND securityQ = :securityQ";
    $stmt = $conn->prepare($sql_validate_user);
    $stmt->bindParam(':username', $user, PDO::PARAM_STR);
    $stmt->bindParam(':securityQ', $securityQ, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        redirectWithError("user", "Invalid username or security answer.");
    }

    // Update password
    $sql_update_password = "UPDATE user SET password = :password WHERE username = :username";
    $stmt = $conn->prepare($sql_update_password);
    $stmt->bindParam(':password', $pswd, PDO::PARAM_STR); // Consider hashing in real applications
    $stmt->bindParam(':username', $user, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header("Location: user.php?message=" . urlencode("Password updated successfully."));
        exit();
    } else {
        redirectWithError("general", "Could not update password.");
    }
} catch (PDOException $e) {
    redirectWithError("general", "Error: " . $e->getMessage());
} finally {
    closeDB();
}
?>