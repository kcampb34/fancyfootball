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

// Open database
$message = openDB();
if ($message !== "Connected") {
    die("Database connection failed: $message");
}

global $conn;

// Fetch user data
$userStmt = $conn->prepare("SELECT username, email, firstname, lastname FROM user WHERE userID = ?");
$userStmt->execute([$userID]);
$userData = $userStmt->fetch(PDO::FETCH_ASSOC);

// Fetch team data (if exists)
$teamStmt = $conn->prepare("SELECT * FROM team WHERE userID = ?");
$teamStmt->execute([$userID]);
$teamData = $teamStmt->fetch(PDO::FETCH_ASSOC);
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <style>
     .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 500px;
        margin: auto;
        text-align: center;
        font-family: Arial, sans-serif;
     }

     .title {
        color: grey;
        font-size: 18px;
     }

     .info {
        margin: 10px 0;
     }

     button {
        border: none;
        outline: 0;
        display: inline-block;
        padding: 8px;
        color: white;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
     }

     a {
        text-decoration: none;
        font-size: 22px;
        color: black;
     }

     button:hover, a:hover {
        opacity: 0.7;
     }

     ul {
        text-align: left;
        margin: 20px;
     }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<div class="card">
  <img src="https://media-cldnry.s-nbcnews.com/image/upload/t_fit-1500w,f_auto,q_auto:best/rockcms/2024-01/bill-belichick-mc-240111-07-copy-582a30.jpg" alt="userpic" style="width:100%">
  <h1><?php echo htmlspecialchars($userData['firstname'] . ' ' . $userData['lastname']); ?></h1>
  <p class="title">@<?php echo htmlspecialchars($userData['username']); ?></p>
  <p class="info">Email: <?php echo htmlspecialchars($userData['email']); ?></p>

  <?php if ($teamData): ?>
      <h2>Your Team: <?php echo htmlspecialchars($teamData['teamname']); ?></h2>
      <ul>
          <?php
          foreach ($teamData as $position => $playerName) {
              if (in_array($position, ['teamname', 'scores', 'userID', 'TeamID']) || is_null($playerName)) continue;
              echo "<li><strong>$position:</strong> " . htmlspecialchars($playerName) . "</li>";
          }
          ?>
      </ul>
  <?php else: ?>
      <p><em>You have not created a team yet.</em></p>
  <?php endif; ?>


  <?php include 'footer.php'; ?>
</div>

</body>
</html>