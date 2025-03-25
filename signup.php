<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  <br>
  <?php include 'header.php' ?>
</head>
<body>
  <div class="w3-container">
    <h1>Please complete the Sign Up Sheet below to register</h1>
    <form name="register" action="registerAction.php" method="get">
      <div class="item">
        <label>Username</label>
        <input type="text" name="user" size="40" required/>
      </div>
        <div class="item">
        <label>First name</label>
        <input type="text" name="fname" size="40" required/>
      </div>
        <div class="item">
        <label>Last name</label>
        <input type="text" name="lname" size="40" required/>
      </div>
      <div class="item">
        <label for="pswd">Password</label>
        <input type="password" name="pswd" size="40" required/>
      </div>
      <div class="item">
        <label for="pswd">Retype Password</label>
        <input type="password" name="pswd2" size="40" required/> 
      </div>
      <div class="item">
          <label for="email">EMail</label>
        <input type="email" name="email" size="40" required/>
      </div>
        <div class="item">
        <label>Security Question: Favorite NFL Team?</label>
        <input type="text" name="fteam" size="40" required/>
      </div>
      <div class="item">
        <input type="submit" value="Submit" />
        <input type="reset" value="Reset" />
      </div>
    </form>
  </div>
  <br>
</body>
</html>