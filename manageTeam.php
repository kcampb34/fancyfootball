<?php 
include 'header.php';
require 'dbConnect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usertype'])) {
    header("Location: index.php");
    exit;
}

if ($_SESSION['usertype'] == 1) {
    header("Location: admin.php");
    exit;
}

$userID = $_SESSION['userID'];

$message = openDB();
if ($message !== "Connected") {
    die("Database error: $message");
}

global $conn;

// Fetch user's current team
$teamStmt = $conn->prepare("SELECT * FROM team WHERE userID = ?");
$teamStmt->execute([$userID]);
$teamRoster = $teamStmt->fetch(PDO::FETCH_ASSOC);

if (!$teamRoster) {
    echo "<h2>No team found. Please create one first.</h2>";
    exit;
}

// Get all player names on user's team (starters + bench)
$teamPlayers = [];
$positionKeys = ['QB', 'RB1', 'RB2', 'WR1', 'WR2', 'TE', 'FLEX', 'D/ST', 'K'];
for ($i = 1; $i <= 7; $i++) {
    $positionKeys[] = 'BE' . $i;
}
foreach ($positionKeys as $pos) {
    if (!empty($teamRoster[$pos])) {
        $teamPlayers[] = $teamRoster[$pos];
    }
}

// Fetch all team players' info
$sortKey = $_GET['sort'] ?? null;
$validSortKeys = ['totalscore', 'avgscore', 'lastscore'];
$sortColumn = in_array($sortKey, $validSortKeys) ? $sortKey : 'totalscore';

$stmt = $conn->prepare("SELECT playerID, playername, position, totalscore, avgscore, lastscore FROM player");
$stmt->execute();
$allPlayers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Filter players to just those on user's team
$teamPlayerDetails = [];
foreach ($allPlayers as $player) {
    if (in_array($player['playername'], $teamPlayers)) {
        $teamPlayerDetails[$player['playername']] = $player;
    }
}

// If sorting is requested, auto-assign players
if (in_array($sortKey, $validSortKeys)) {
    usort($allPlayers, function ($a, $b) use ($sortColumn) {
        return $b[$sortColumn] <=> $a[$sortColumn];
    });

    $usedPlayers = [];
    $positionSlots = [
        'QB' => ['QB'],
        'RB1' => ['RB'],
        'RB2' => ['RB'],
        'WR1' => ['WR'],
        'WR2' => ['WR'],
        'TE' => ['TE'],
        'FLEX' => ['RB', 'WR', 'TE'],
        'D/ST' => ['D/ST'],
        'K' => ['K']
    ];

    // Helper to find next best player not already used
    function findNextPlayer($allowedPositions, $players, &$usedPlayers, $teamPlayers) {
        foreach ($players as $p) {
            if (in_array($p['playername'], $teamPlayers) &&
                in_array($p['position'], $allowedPositions) &&
                !in_array($p['playername'], $usedPlayers)) {
                $usedPlayers[] = $p['playername'];
                return $p['playername'];
            }
        }
        return null;
    }

    // Build new team roster
    $newTeamRoster = [];

    foreach ($positionSlots as $slot => $validPos) {
        $newTeamRoster[$slot] = findNextPlayer($validPos, $allPlayers, $usedPlayers, $teamPlayers);
    }

    // Fill the bench with any remaining players
    $benchIndex = 1;
    foreach ($allPlayers as $p) {
        if (in_array($p['playername'], $teamPlayers) && !in_array($p['playername'], $usedPlayers)) {
            $benchSlot = 'BE' . $benchIndex++;
            $newTeamRoster[$benchSlot] = $p['playername'];
            $usedPlayers[] = $p['playername'];
            if ($benchIndex > 7) break;
        }
    }

    $teamRoster = $newTeamRoster;
}

// Function to render a dropdown with only players from team
function renderDropdown($label, $name, $currentPlayerName, $allowedPositions, $teamPlayerDetails) {
    echo "<div class='item'><label>$label:</label><select name='$name' required>";
    echo "<option value=''>-- Select Player --</option>";
    foreach ($teamPlayerDetails as $playerName => $player) {
        if (in_array($player['position'], $allowedPositions)) {
            $selected = ($playerName === $currentPlayerName) ? "selected" : "";
            $display = htmlspecialchars($playerName) . " - " . $player['position'] . " - " . $player['totalscore'] . " pts";
            echo "<option value='" . htmlspecialchars($playerName) . "' $selected>$display</option>";
        }
    }
    echo "</select></div>";
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Your Fantasy Team</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
        .form-container {
            width: 500px; margin: 0 auto; background: white;
            padding: 20px; border: 1px solid #ccc; border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        }
        .item { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select {
            width: 100%; padding: 8px;
            box-sizing: border-box; border: 1px solid #ccc;
            border-radius: 4px;
        }
        .sort-buttons {
            text-align: center;
            margin-bottom: 15px;
        }
        .sort-buttons a {
            margin: 0 5px;
            text-decoration: none;
            padding: 6px 10px;
            background: #007bff;
            color: white;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Manage Your Team</h2>

    <div class="sort-buttons">
        <strong>Auto-Sort By:</strong>
        <a href="?sort=totalscore">Total Score</a>
        <a href="?sort=avgscore">Average Score</a>
        <a href="?sort=lastscore">Last Score</a>
    </div>

    <form method="post" action="manageTeamAction.php">
        <?php
        renderDropdown("Quarterback (QB)", "QB", $teamRoster['QB'] ?? null, ['QB'], $teamPlayerDetails);
        renderDropdown("Running Back 1 (RB1)", "RB1", $teamRoster['RB1'] ?? null, ['RB'], $teamPlayerDetails);
        renderDropdown("Running Back 2 (RB2)", "RB2", $teamRoster['RB2'] ?? null, ['RB'], $teamPlayerDetails);
        renderDropdown("Wide Receiver 1 (WR1)", "WR1", $teamRoster['WR1'] ?? null, ['WR'], $teamPlayerDetails);
        renderDropdown("Wide Receiver 2 (WR2)", "WR2", $teamRoster['WR2'] ?? null, ['WR'], $teamPlayerDetails);
        renderDropdown("Tight End (TE)", "TE", $teamRoster['TE'] ?? null, ['TE'], $teamPlayerDetails);
        renderDropdown("Flex (FLEX)", "FLEX", $teamRoster['FLEX'] ?? null, ['RB', 'WR', 'TE'], $teamPlayerDetails);
        renderDropdown("Defense/Special Teams (D/ST)", "DST", $teamRoster['D/ST'] ?? null, ['D/ST'], $teamPlayerDetails);
        renderDropdown("Kicker (K)", "K", $teamRoster['K'] ?? null, ['K'], $teamPlayerDetails);

        for ($i = 1; $i <= 7; $i++) {
            $slot = 'BE' . $i;
            renderDropdown("Bench Player $i ($slot)", $slot, $teamRoster[$slot] ?? null, ['QB', 'RB', 'WR', 'TE', 'D/ST', 'K'], $teamPlayerDetails);
        }
        ?>

        <div class="item">
            <input type="submit" value="Update Team" />
        </div>
    </form>
</div>

</body>
</html>



