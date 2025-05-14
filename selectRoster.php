<?php
include 'header.php';
require 'dbConnect.php';


// Ensure session is only started if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and not an admin
if (!isset($_SESSION['usertype'])) {
    header("Location: index.php");
    exit;
}

if ($_SESSION['usertype'] == 1) {
    header("Location: admin.php");
    exit;
}

$userID = $_SESSION['userID'];

// Open DB
$message = openDB();
if ($message !== "Connected") {
    die("Database error: $message");
}

// Fetch players with scores and positions
$stmt = $conn->prepare("SELECT playerID, playername, position, totalscore FROM player ORDER BY position, playername");
$stmt->execute();
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group players by position
$groupedPlayers = [];
foreach ($players as $player) {
    $groupedPlayers[$player['position']][] = $player;
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Create Your Fantasy Team</title>
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
    </style>
</head>
<body>

<div class="form-container">
    <h2>Create Your Fantasy Team</h2>

    <form method="post" action="saveRoster.php">
        <div class="item">
            <label>Team Name:</label>
            <input type="text" name="teamname" required />
        </div>

        <?php
        function playerDropdown($label, $name, $groupedPlayers, $positions) {
            echo "<div class='item'><label>$label:</label><select name='$name' required>";
            echo "<option value=''>-- Select Player --</option>";

            foreach ($positions as $pos) {
                if (isset($groupedPlayers[$pos])) {
                    foreach ($groupedPlayers[$pos] as $player) {
                        $display = htmlspecialchars($player['playername']) . " - " . $player['position'] . " - " . $player['totalscore'] . " pts";
                        echo "<option value='" . htmlspecialchars($player['playername']) . "'>$display</option>";
                    }
                }
            }

            echo "</select></div>";
        }

        // Main Positions
        playerDropdown("Quarterback (QB)", "QB", $groupedPlayers, ['QB']);
        playerDropdown("Running Back 1 (RB1)", "RB1", $groupedPlayers, ['RB']);
        playerDropdown("Running Back 2 (RB2)", "RB2", $groupedPlayers, ['RB']);
        playerDropdown("Wide Receiver 1 (WR1)", "WR1", $groupedPlayers, ['WR']);
        playerDropdown("Wide Receiver 2 (WR2)", "WR2", $groupedPlayers, ['WR']);
        playerDropdown("Tight End (TE)", "TE", $groupedPlayers, ['TE']);
        playerDropdown("Flex (RB/WR/TE)", "FLEX", $groupedPlayers, ['RB', 'WR', 'TE']);
        playerDropdown("Defense/Special Teams (D/ST)", "DST", $groupedPlayers, ['D/ST', 'DEF']);
        playerDropdown("Kicker (K)", "K", $groupedPlayers, ['K']);

        // Bench Players
        for ($i = 1; $i <= 7; $i++) {
            playerDropdown("Bench Player $i (BE$i)", "BE$i", $groupedPlayers, ['QB', 'RB', 'WR', 'TE', 'D/ST', 'DEF', 'K']);
        }
        ?>

        <div class="item">
            <input type="submit" value="Save Team" />
        </div>
    </form>
</div>

</body>
</html>





