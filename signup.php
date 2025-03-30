<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <br>
    <?php include 'header.php'; ?>
    <style>
        .error { color: red; font-weight: bold; }
        .success { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <div class="w3-container">
        <h1>Please complete the Sign Up Sheet below to register</h1>

        <form name="register" action="registerAction.php" method="get">
            <div class="item">
                <label>Username</label>
                <?php if (isset($_GET['error_user'])) echo "<p class='error'>" . htmlspecialchars($_GET['error_user']) . "</p>"; ?>
                <input type="text" name="user" size="40" required />
            </div>
            <div class="item">
                <label>First name</label>
                <input type="text" name="fname" size="40" required />
            </div>
            <div class="item">
                <label>Last name</label>
                <input type="text" name="lname" size="40" required />
            </div>
            <div class="item">
                <label for="pswd">Password</label>
                <?php if (isset($_GET['error_password'])) echo "<p class='error'>" . htmlspecialchars($_GET['error_password']) . "</p>"; ?>
                <input type="password" name="pswd" size="40" required />
            </div>
            <div class="item">
                <label for="pswd">Retype Password</label>
                <input type="password" name="pswd2" size="40" required />
            </div>
            <div class="item">
                <label for="email">Email</label>
                <?php if (isset($_GET['error_email'])) echo "<p class='error'>" . htmlspecialchars($_GET['error_email']) . "</p>"; ?>
                <input type="email" name="email" size="40" required />
            </div>
            <div class="item">
                <input type="submit" value="Submit" />
                <input type="reset" value="Reset" />
            </div>
        </form>

        <!-- Display global success message -->
        <?php if (isset($_GET['success'])) echo "<p class='success'>" . htmlspecialchars($_GET['success']) . "</p>"; ?>
    </div>
    <br>
</body>
</html>
