<?php
$servername = "localhost";
$username = "Braeden";
$password = "Kenny";
$dbname = "fancy football";

function openDB() {
    global $conn, $servername, $username, $password, $dbname;

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return "Connected"; 
    } catch (PDOException $e) {
        return "Connection failed: " . $e->getMessage();
    }
}

function closeDB() {
    global $conn;
    $conn = null; // Close the connection
}


function LoginDB($sql, $user, $pswd) {
    global $conn;

    $message = openDB(); // Open the connection
    if ($message !== "Connected") {
        return $message; // Return connection error
    }

    try {
        // Prepare and execute the SQL query
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $user, PDO::PARAM_STR);
        $stmt->bindParam(2, $pswd, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch all rows as an array
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result ?: []; // Return empty array if no rows match
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage(); // Handle SQL errors
    } finally {
        closeDB(); // Ensure the connection is closed
    }
}