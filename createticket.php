<?php

session_start();

?>

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
    <li><a href="tickets.php" class="nav-bar-item">Tickets</a></li>
    <li style=" background-color: green; color: black;"><a href="createticket.php" class="nav-bar-item">Create Ticket</a></li>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
      echo "<li><a href=\"ticketview.php\" class=\"nav-bar-item\">Ticket View</a></li>";
        echo "<li style=\"float:right\"><a href=\"logout.php\" class=\"nav-bar-item\">Logout</a></li>";
    }
    else {
       echo "<li style=\"float:right\"><a href=\"login.php\" class=\"nav-bar-item\">Login</a></li>";
	   echo "<li style=\"float:right\"><a href=\"signup.php\" class=\"nav-bar-item\">Sign Up</a></li>";
    }
    ?>
</ul>

    <form method="post">
        <createticketform>
        <h1>Create Ticket</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>
        <label for="subject"><b>Subject</b></label>
        <br>
        <input class="subject_enter" type="text" placeholder="Enter Subject" name="subject" required>
        <br>
        <label for="desc"><b>Description of Issue</b></label>
        <br>
        <textarea class="desc_enter" type="text" placeholder="Enter Ticket Description/Message" name="desc" required></textarea>
        <br>
        <label for="dDate"><b>Due Date</b></label>
        <br>
        <input for="dueDate" type="date" name="dueDate">
        <label>
        </label>
  
        <p>By creating a Ticket you agree to our <a href="termsandprivacy.php" style="color:dodgerblue" target="_blank">Terms & Privacy</a>.</p>
  
        <div class="clearfix">
          <button type="button" onclick="location.href='index.php'" class="cancelbtn">Cancel</button>
          <button type="submit" class="createticketbtn" name="createticketbtn">Submit</button>
        </createticketform>
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
    
    if ( !isset($_POST['subject'],$_POST['desc'], $_POST['dueDate']) ) {
      // Could not get the data that should have been sent.
      exit();
    }
    $subject = ($_POST['subject']);
    $desc = ($_POST['desc']);
    $date = ($_POST['dueDate']);
    $ddate=date("Y-m-d",strtotime($date));
    $id = ($_SESSION['id']);
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare("INSERT INTO tblTicket (txtSubject, dDue, intStatus, intUserOwnerId, dCreated, dUpdated, intRepId) VALUES ('$subject','$ddate',1,$id,'$ddate','$ddate',0)")){
      $stmt->execute();
      $stmt->close();
    }
?> 