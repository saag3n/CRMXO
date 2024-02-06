<!DOCTYPE html>
<html>
<title>Login</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="stylesheet.css" href="/images/favicon.ico">
<link rel="icon" type="image/x-icon" href="/images/favicon.ico">
<body>

<!-- Navigation Bar -->

<ul>
    <li><a href="profile.php" class="nav-bar-item">Profile</a></li>
    <li><a href="index.php" class="nav-bar-item">Home</a></li>
    <li><a href="news.php" class="nav-bar-item">News</a></li>
    <li style="float:right; background-color: green; color: black;"><a href="login.php" class="nav-bar-item">Login</a></li>
    <li style="float:right;"><a href="signup.php" class="nav-bar-item">Sign Up</a></li>
</ul>

<form action="login.php" method="post">
<loginform>
    <h1>Log In</h1>
    <hr>
    <label for="email"><b>Username</b></label>
    <br>
    <input class="username_enter" type="text" placeholder="Enter Username" name="username" required>
    <br>
    <label for="psw"><b>Password</b></label>
    <br>
    <input class="psw_enter" type="password" placeholder="Enter Password" name="psw" required>
    <br>
    <label>
      <input type="checkbox" name="remember" style="margin-bottom:15px"> Remember me
    </label>


    <div class="clearfix">
      <button type="button" onclick="location.href='index.php'" class="cancelbtn">Cancel</button>
      <button type="submit" class="loginbtn" name ="loginbtn">Log In</button>
    </loginform>
    </form>

    
</body>
</html>

    <?php
    session_start();
    // Change this to your connection info.
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'CRM_Test';
    // Try and connect using the info above.
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if ( mysqli_connect_errno() ) {
      // If there is an error with the connection, stop the script and display the error.
      exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    
    if ( !isset($_POST['username'], $_POST['psw']) ) {
      // Could not get the data that should have been sent.
      exit('<br></br>Please fill both the username and password fields!');
    }
    
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare('SELECT tblUserID, txtPassword FROM tblUser WHERE txtUsername = ?')) {
      // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
      $stmt->bind_param('s', $_POST['username']);
      $stmt->execute();
      // Store the result so we can check if the account exists in the database.
      $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();
            // Account exists, now we verify the password.
            // Note: remember to use password_hash in your registration file to store the hashed passwords.
            if (password_verify($_POST['psw'], $password)) {
                // Verification success! User has logged-in!
                // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                header('Location: index.php');
            } else {
                // Incorrect password
                echo 'Incorrect username and/or password!';
            }
        } else {
            // Incorrect username
            echo 'Incorrect username and/or password!';
        }
    
      $stmt->close();
    }

?>

