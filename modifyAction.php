<?php
require 'dbConnect.php';
openDB();

$playerID = $_POST['playerID'];
$pname = trim($_POST['pname']);
$pos = trim($_POST['pos']);
$NFLteam = trim($_POST['NFLteam']);
$lscore = $_POST['lscore'];
$tscore = $_POST['tscore'];
$ascore = $_POST['ascore'];

try {
    $stmt = $conn->prepare("UPDATE player 
        SET playername = :pname, position = :pos, nflteam = :nflteam,
            lastscore = :lscore, totalscore = :tscore, avgscore = :ascore
        WHERE playerID = :playerID");

    $stmt->bindParam(':pname', $pname);
    $stmt->bindParam(':pos', $pos);
    $stmt->bindParam(':nflteam', $NFLteam);
    $stmt->bindParam(':lscore', $lscore);
    $stmt->bindParam(':tscore', $tscore);
    $stmt->bindParam(':ascore', $ascore);
    $stmt->bindParam(':playerID', $playerID);

    $stmt->execute();
    header("Location: modifyPlayer.php?playerID=$playerID&success=1");
} catch (PDOException $e) {
    echo "Error updating player: " . $e->getMessage();
}
