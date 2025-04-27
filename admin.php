<html>
  <head>
    <title>Fancy Football</title>
  <br>
  <?php include 'header.php';
  
  // Ensure session is only started if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
 
if ($_SESSION['usertype'] == 0) {
  header("Location:userP.php");
  exit;
}

// Check user type
if (!isset($_SESSION['usertype'])) {
    header("Location: index.php");
    exit;
}
  ?>
  <?php require 'dbConnect.php'?>
</head>
<div class="w3-panel w3-leftbar w3-light-grey">
    <div class="logo">
        <h1 class="w3-cursive freshman-font">Welcome Admin</h1>
        <a href="newPlayer.php" button type="submit" class="btn btn-sm w3-blue w3-round w3-cursive freshman-font">Create Player</button></a>
        <a href="modifyPlayer.php" button type="submit" class="btn btn-sm w3-blue w3-round w3-cursive freshman-font">Modify</button></a>
</div>
</div>
    </div>
    <div class="prime">
        <img src="https://media.pff.com/2024/07/FiddyNEW-scaled.jpg?w=1912&h=1076" alt="nfl fantasy" height="800px;">
    </div>
  <br>
  <?php include 'footer.php' ?>
</body>
</html>