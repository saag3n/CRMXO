<!DOCTYPE html>
<html>
<title>Sign Up - Register for CRMX0</title>
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
    <li style="float:right;"><a href="login.php" class="nav-bar-item">Login</a></li>
    <li style="float:right; background-color: green; color: black;"><a href="signup.php" class="nav-bar-item">Sign Up</a></li>
</ul>

    <form method="post">
      <div class="signupform">
        <signupform>
        <h1>Sign Up</h1>
        <p>Please fill in this form to create an account.</p>
        <label for="email"><b>Email</b></label>
        <br>
        <input class = "email_enter" type="text" placeholder="Enter Email" name="email" required>
        <br>
        <label for="username"><b>Username</b></label>
        <br>
        <input class = "username_enter" type="text" placeholder="Enter Username" name="username" required>
        <br>
        <label for="psw"><b>Password</b></label>
        <br>
        <input class = "psw_enter" type="password" placeholder="Enter Password" name="psw" required>
        <br>
        <label for="psw-repeat"><b>Repeat Password</b></label>
        <br>
        <input class = "pswrepeat_enter" type="password" placeholder="Repeat Password" name="psw-repeat" required>
        <label>
          <input type="checkbox" name="remember" style="margin-bottom:15px"> Remember me
        </label>
  
        <p>By creating an account you agree to our <a href="termsandprivacy.php" style="color:dodgerblue" target="_blank">Terms & Privacy</a>.</p>
  
        <div class="clearfix">
          <button type="button" onclick="location.href='index.php'" class="cancelbtn">Cancel</button>
          <button type="submit" class="signupbtn" name="signupbtn">Sign Up</button>
        </signupform>
      </div>
    </form>

</body>
</html>

<?php
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
    
    if ( !isset($_POST['email'],$_POST['username'], $_POST['psw']) ) {
      // Could not get the data that should have been sent.
      exit();
    }
    $username = ($_POST['username']);
    $email = ($_POST['email']);
    $psw = ($_POST['psw']);
    $encrypted_psw = crypt($psw, 'salt');
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare("INSERT INTO tblUser (txtUsername, txtEmail, txtPassword) VALUES ('$username','$email','$encrypted_psw')")){
      // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"

      $stmt->execute();
      // Store the result so we can check if the account exists in the database.
      $stmt->close();
    }
?>