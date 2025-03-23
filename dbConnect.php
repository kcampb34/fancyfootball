<?php
$servername = "localhost";
$username = "Braeden";
$password = "Kenny";
$dbname = "fancyfootball";

function modifyDB($servername, $dbname, $username, $password, $sql) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec($sql);
        return "New record created successfully";
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    } finally {
        $conn = null;
    }
}
?>