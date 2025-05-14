<?php
session_start();
require 'dbConnect.php';
include 'header.php';

// Ensure the user is logged in
if (!isset($_SESSION['userID'])) {
    echo "<h2>Error: You must be logged in to save a team.</h2>";
    echo "<p><a href='selectRoster.php'>Try Again?</a></p>";
    exit;
}


$userID = $_SESSION['userID'];

// Open DB connection
$message = openDB();
if ($message !== "Connected") {
    echo "<h2>Database Error: $message</h2>";
    exit;
}
global $conn;

// Grab updated roster selections
$roster = [
    'QB'   => $_POST['QB'] ?? null,
    'RB1'  => $_POST['RB1'] ?? null,
    'RB2'  => $_POST['RB2'] ?? null,
    'WR1'  => $_POST['WR1'] ?? null,
    'WR2'  => $_POST['WR2'] ?? null,
    'TE'   => $_POST['TE'] ?? null,
    'FLEX' => $_POST['FLEX'] ?? null,
    'DST'  => $_POST['DST'] ?? null,
    'K'    => $_POST['K'] ?? null,
    'BE1'  => $_POST['BE1'] ?? null,
    'BE2'  => $_POST['BE2'] ?? null,
    'BE3'  => $_POST['BE3'] ?? null,
    'BE4'  => $_POST['BE4'] ?? null,
    'BE5'  => $_POST['BE5'] ?? null,
    'BE6'  => $_POST['BE6'] ?? null,
    'BE7'  => $_POST['BE7'] ?? null,
];

// Check for duplicate players
$selectedPlayers = array_filter($roster);
$duplicates = array_diff_assoc($selectedPlayers, array_unique($selectedPlayers));
if (!empty($duplicates)) {
    echo "<h2>Error: Duplicate players selected. Each player must be unique.</h2>";
    echo "<p><a href='manageTeam.php'>Go Back</a></p>";
    exit;
}

// Fetch current team ID
$stmt = $conn->prepare("SELECT TeamID FROM team WHERE userID = ?");
$stmt->execute([$userID]);
$team = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$team) {
    echo "<h2>Error: No team found to update.</h2>";
    echo "<p><a href='manageTeam.php'>Go Back</a></p>";
    exit;
}

$teamID = $team['TeamID'];

// Reset all previous players on this team to NULL
$resetStmt = $conn->prepare("UPDATE player SET teamID = NULL WHERE teamID = ?");
$resetStmt->execute([$teamID]);

// Update team table with new roster
$updateSQL = "UPDATE team SET 
    QB = :QB, RB1 = :RB1, RB2 = :RB2, WR1 = :WR1, WR2 = :WR2, TE = :TE, FLEX = :FLEX, `D/ST` = :DST, K = :K,
    BE1 = :BE1, BE2 = :BE2, BE3 = :BE3, BE4 = :BE4, BE5 = :BE5, BE6 = :BE6, BE7 = :BE7
    WHERE TeamID = :teamID";
$updateStmt = $conn->prepare($updateSQL);

$params = array_merge(
    array_combine(array_map(fn($k) => ":$k", array_keys($roster)), array_values($roster)),
    [':teamID' => $teamID, ':DST' => $roster['DST']]
);
$updateStmt->execute($params);

// Assign new players to the team
$assignStmt = $conn->prepare("UPDATE player SET teamID = ? WHERE playername = ?");
foreach ($selectedPlayers as $playername) {
    $assignStmt->execute([$teamID, $playername]);
}

// Confirmation message
echo "<h2>Your Team Has Been Updated!</h2><ul>";
foreach ($roster as $position => $playername) {
    echo "<li><strong>$position:</strong> " . ($playername ? htmlspecialchars($playername) : "None") . "</li>";
}
echo "</ul>";
echo "<p><a href='userP.php'>Return to User Page</a></p>";

// Close DB
closeDB();


