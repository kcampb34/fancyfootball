<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
   <link rel="stylesheet" href="mystyles.css">
   
   <style>
       
      @font-face {
        font-family: "Freshman";
        src: url("other/Freshman.ttf") format("truetype");
      }

      .freshman {
        font-family: "Freshman", sans-serif;
      }
    </style> 
   
 </head>
 <body>
     <?php
     session_start();
     if (isset($_SESSION['usertype'])) {
       $usertype = $_SESSION['usertype'];
       if ($usertype == 1) {
         $homepage = "admin.php";
         $signupPage = "signup.php";
       } else {
         $homepage = "userP.php";
         $signupPage = "signup.php";
       }
     } else {
       $homepage = "index.php";
       $signupPage = "signup.php";
     }
 
     ?>
   <div class="w3-container">
     <div class="w3-bar w3-blue boxed">
       <a href="index.php" class="w3-bar-item w3-button w3-mobile w3-green">Home</a>
       <a href="https://www.espn.com/" target="_blank" class="w3-bar-item w3-button w3-mobile">ESPN</a>
       <a href="https://www.nfl.com/news/" target="_blank" class="w3-bar-item w3-button w3-mobile">NFL News</a>
       <input type="text" class="w3-bar-item w3-input" placeholder="Search..">
       <a href="https://www.google.com/webhp " class="w3-bar-item w3-button w3-green">Go</a>
       <a href="userP.php" class="w3-bar-item w3-button w3-mobile w3-center">User Page</a>
       <a href="signup.php" class="w3-bar-item w3-button w3-mobile">Sign Up</a>
  <div class="col-sm-2">
   <?php if (isset($_SESSION['name'])): ?>
   <div class="w3-right d-flex align-items-center">
       <h6 class="me-2">Welcome, <?php echo $_SESSION['name']; ?></h6>
       <form class="form-inline" name="logout" action="LogoutAction.php" method="post">
           <button type="submit" class="btn btn-danger btn-sm">Logout</button>
       </form>
   </div>
   <?php else: ?>
       <form name="login" action="LoginAction.php" method="post">
           <input type="text" class="form-control form-control-sm w3-input w3-border w3-light-grey" style="margin-left:1500px;margin-bottom:10px" id="user" required placeholder="Username" name="user">
           <input type="password" class="form-control form-control-sm w3-input w3-border w3-light-grey" style="margin-left:1500px;" id="pswd" required placeholder="Password" name="pswd">
         <button type="submit" class="btn btn-sm w3-blue w3-round" style="margin-left:1500px;">Login</button>
       </form>
   <?php endif; ?>
       </div>
    </div>
   </div>
 </body>