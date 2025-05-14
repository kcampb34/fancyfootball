<?php 
include 'header.php';

// Ensure session is only started if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 
if ($_SESSION['usertype'] == 1) {
  header("Location:admin.php");
  exit;
}

// Check user type
if (!isset($_SESSION['usertype'])) {
    header("Location: index.php");
    exit;
}

?>

<html>
  <head>
    <title>Fancy Football</title>
  <br>
  <?php require 'dbConnect.php' ?>
</head>
<div class="w3-panel w3-leftbar w3-light-grey">
    <div class="logo">
        <h1 class="w3-cursive freshman-font">Hello Coach</h1>
        <a href="profile.php" button type="submit" class="btn btn-sm w3-blue w3-round w3-cursive freshman-font">View Profile</button></a>
        <a href="selectRoster.php" button type="submit" class="btn btn-sm w3-blue w3-round w3-cursive freshman-font">Test Draft</button></a>
        <a href="manageTeam.php" button type="submit" class="btn btn-sm w3-blue w3-round w3-cursive freshman-font">Manage Team</button></a>
</div>
</div>
    </div>
    <div class="prime">
        <img src="https://npr.brightspotcdn.com/dims4/default/dcc9640/2147483647/strip/true/crop/1252x1252+0+0/resize/1760x1760!/format/webp/quality/90/?url=http%3A%2F%2Fnpr-brightspot.s3.amazonaws.com%2Flegacy%2Fsites%2Fwamc%2Ffiles%2F201504%2Fnfldraft.jpeg" alt="nfl fantasy" height="800px;">
    </div>
  <br>
  <?php include 'footer.php' ?>
</body>
</html>
