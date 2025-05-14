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
    echo "<p><a href='selectRoster.php'>Try Again?</a></p>";
    exit;
}
global $conn;

// Get team name
$teamname = $_POST['teamname'] ?? null;
if (!$teamname) {
    echo "<h2>Error: Team name is required.</h2>";
    echo "<p><a href='selectRoster.php'>Try Again?</a></p>";
    exit;
}

// Grab roster selections
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
    echo "<p><a href='selectRoster.php'>Try Again?</a></p>";
    exit;
}

// Disband existing team (delete team and reset player teamIDs)
$teamQuery = $conn->prepare("SELECT TeamID FROM team WHERE userID = ?");
$teamQuery->execute([$userID]);
$oldTeam = $teamQuery->fetch(PDO::FETCH_ASSOC);

if ($oldTeam) {
    $oldTeamID = $oldTeam['TeamID'];

    // Reset player.teamID to NULL
    $resetStmt = $conn->prepare("UPDATE player SET teamID = NULL WHERE teamID = ?");
    $resetStmt->execute([$oldTeamID]);

    // Delete the old team
    $deleteStmt = $conn->prepare("DELETE FROM team WHERE userID = ?");
    $deleteStmt->execute([$userID]);
}

// Insert the new team
$insertSQL = "INSERT INTO team (
    teamname, scores, userID, QB, RB1, RB2, WR1, WR2, TE, FLEX, `D/ST`, K,
    BE1, BE2, BE3, BE4, BE5, BE6, BE7
) VALUES (
    :teamname, 0, :userID, :QB, :RB1, :RB2, :WR1, :WR2, :TE, :FLEX, :DST, :K,
    :BE1, :BE2, :BE3, :BE4, :BE5, :BE6, :BE7
)";
$insertStmt = $conn->prepare($insertSQL);

$params = array_merge([
    ':teamname' => $teamname,
    ':userID'   => $userID,
    ':DST'      => $roster['DST'],
], array_combine(
    array_map(fn($key) => ":$key", array_keys($roster)),
    array_values($roster)
));
$insertStmt->execute($params);

// Get the new team ID
$newTeamID = $conn->lastInsertId();

// Assign players to new team
$updatePlayerStmt = $conn->prepare("UPDATE player SET teamID = ? WHERE playername = ?");
foreach ($selectedPlayers as $playername) {
    $updatePlayerStmt->execute([$newTeamID, $playername]);
}

// Confirmation
echo "<h2>Your Roster Has Been Saved!</h2><ul>";
foreach ($roster as $position => $playerID) {
    echo "<li><strong>$position:</strong> " . ($playerID ? htmlspecialchars($playerID) : "No selection") . "</li>";
}
echo "</ul>";

echo "<p><a href='userP.php'>Return to User Page</a></p>";

// Close connection
closeDB();
?>

