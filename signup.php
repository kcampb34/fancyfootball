<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <?php include 'header.php'; ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        /* Ensure the header stays centered and full-width */
        .header-container {
            text-align: center;
            width: 100%;
            padding-bottom: 20px;
        }

        /* Center the form on the screen */
        .form-container {
            width: 400px;
            text-align: left; /* Keep inputs left-aligned */
            margin: 0 auto; /* Center the form horizontally */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .item {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .success {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Header Section (Remains Centered) -->
    <div class="header-container">
        <h1>Please complete the Sign Up Sheet below to register</h1>
    </div>

    <!-- Signup Form (Centered) -->
    <div class="form-container">
        <form name="register" action="registerAction.php" method="get">
            <div class="item">
                <label>Username</label>
                <?php if (isset($_GET['error_user'])) echo "<p class='error'>" . htmlspecialchars($_GET['error_user']) . "</p>"; ?>
                <input type="text" name="user" required />
            </div>
            <div class="item">
                <label>First name</label>
                <input type="text" name="fname" required />
            </div>
            <div class="item">
                <label>Last name</label>
                <input type="text" name="lname" required />
            </div>
            <div class="item">
                <label for="pswd">Password</label>
                <?php if (isset($_GET['error_password'])) echo "<p class='error'>" . htmlspecialchars($_GET['error_password']) . "</p>"; ?>
                <input type="password" name="pswd" required />
            </div>
            <div class="item">
                <label for="pswd">Retype Password</label>
                <input type="password" name="pswd2" required />
            </div>
            <div class="item">
                <label for="email">Email</label>
                <?php if (isset($_GET['error_email'])) echo "<p class='error'>" . htmlspecialchars($_GET['error_email']) . "</p>"; ?>
                <input type="email" name="email" required />
            </div>
            <div class="item">
                <input type="submit" value="Submit" />
                <input type="reset" value="Reset" />
            </div>
        </form>

        <!-- Display global success message -->
        <?php if (isset($_GET['success'])) echo "<p class='success'>" . htmlspecialchars($_GET['success']) . "</p>"; ?>
    </div>

</body>
</html>
