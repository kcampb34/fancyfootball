<?php
include 'header.php';
require 'dbConnect.php'; 

// Get user inputs
$pname = trim(htmlspecialchars($_GET['pname']));
$pos = trim(htmlspecialchars($_GET['pos']));
$NFLteam = trim(htmlspecialchars($_GET['NFLteam']));
$lscore = $_GET['lscore'];
$tscore = $_GET['tscore'];
$ascore = trim(htmlspecialchars($_GET['ascore']));

// Redirect with field-specific error messages
function redirectWithError($field, $message) {
    header("Location: newPlayer.php?error_{$field}=" . urlencode($message));
    exit();
}

// Open database connection
$message = openDB();
if ($message !== "Connected") {
    redirectWithError("general", "Database connection failed.");
}

global $conn; 

try {
    // Check if player name already exists
    $sql_check_player = "SELECT playername FROM player WHERE playername = :playername";
    $stmt = $conn->prepare($sql_check_player);
    $stmt->bindParam(':playername', $user, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        redirectWithError("pname", "playername already exists.");
    }

    // Insert new player
    $sql_insert = "INSERT INTO user (playername, position, nflteam, lastscore, totalscore, avgscore) 
                   VALUES (:playername, :position, :nflteam, :lastscore, :totalscore, :avgscore)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bindParam(':playername', $pname, PDO::PARAM_STR);
    $stmt->bindParam(':position', $pos, PDO::PARAM_STR);
    $stmt->bindParam(':nflteam', $NFLteam, PDO::PARAM_STR);
    $stmt->bindParam(':lastscore', $lscore, PDO::PARAM_STR);
    $stmt->bindParam(':totalscore', $tscore, PDO::PARAM_STR);
    $stmt->bindParam(':avgscore', $ascore, PDO::PARAM_STR);
?>

