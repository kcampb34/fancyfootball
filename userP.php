<?php 
include 'header.php';
if (!(isset($_SESSION['usertype'])) or $usertype != 0) {
  header("Location:index.php");
  exit;
}
?>
<?php 
if ($usertype == 1) {
  header("Location:admin.php");
  exit;
}

?>
