<?php include 'header.php' ?>
<?php require 'dbConnect.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Player Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="mystyles.css">
</head>
<body class="p-4">

    <h2>Search Results</h2>

    <?php if (!empty($searchQuery)): ?>
        <p>Showing results for: <strong><?php echo htmlspecialchars($searchQuery); ?></strong></p>

        <?php if (!empty($results)): ?>
            <div class="list-group">
                <?php foreach ($results as $player): ?>
                    <div class="list-group-item">
                        <h5><?php echo htmlspecialchars($player['playername']); ?> (<?php echo htmlspecialchars($player['position']); ?>)</h5>
                        <p><strong>Team:</strong> <?php echo htmlspecialchars($player['nflteam']); ?></p>
                        <p><strong>Stats:</strong> <?php echo htmlspecialchars($player['avgscore']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning mt-3">No players found matching your search.</div>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert alert-danger">No search query provided.</div>
    <?php endif; ?>

    <a href="index.php" class="btn btn-primary mt-4">Back to Home</a>

</body>
</html>