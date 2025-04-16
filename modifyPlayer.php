<?php
include 'header.php';
require 'dbConnect.php';

// Open DB
openDB();

// Get list of players
$stmt = $conn->prepare("SELECT playerID, playername FROM player");
$stmt->execute();
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if a player was selected
$selectedID = isset($_GET['playerID']) ? $_GET['playerID'] : null;
$playerData = null;

if ($selectedID) {
    $stmt = $conn->prepare("SELECT * FROM player WHERE playerID = ?");
    $stmt->execute([$selectedID]);
    $playerData = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Modify Player</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .form-container {
            width: 400px; margin: 0 auto; background: white;
            padding: 20px; border: 1px solid #ccc; border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .item { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Modify NFL Player</h2>

    <form method="get" action="modifyPlayer.php">
        <div class="item">
            <label>Select a player:</label>
            <select name="playerID" onchange="this.form.submit()">
                <option value="">-- Select Player --</option>
                <?php foreach ($players as $player): ?>
                    <option value="<?= $player['playerID'] ?>" <?= $selectedID == $player['playerID'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($player['playername']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if ($playerData): ?>
    <form method="post" action="modifyAction.php">
        <input type="hidden" name="playerID" value="<?= $playerData['playerID'] ?>" />
        
        <div class="item">
            <label>Player Name</label>
            <input type="text" name="pname" value="<?= htmlspecialchars($playerData['playername']) ?>" required />
        </div>
        <div class="item">
            <label>Position</label>
            <input type="text" name="pos" value="<?= htmlspecialchars($playerData['position']) ?>" required />
        </div>
        <div class="item">
            <label>NFL Team</label>
            <input type="text" name="NFLteam" value="<?= htmlspecialchars($playerData['nflteam']) ?>" required />
        </div>
        <div class="item">
            <label>Last Score</label>
            <input type="text" name="lscore" value="<?= htmlspecialchars($playerData['lastscore']) ?>" required />
        </div>
        <div class="item">
            <label>Total Score</label>
            <input type="text" name="tscore" value="<?= htmlspecialchars($playerData['totalscore']) ?>" required />
        </div>
        <div class="item">
            <label>Average Score</label>
            <input type="text" name="ascore" value="<?= htmlspecialchars($playerData['avgscore']) ?>" required />
        </div>
        <div class="item">
            <input type="submit" value="Update Player" />
        </div>
    </form>
    <?php endif; ?>
</div>

</body>
</html>
