<?php

session_start();

?>


<!DOCTYPE html>
<html>
<title>News</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="stylesheet.css">
<link rel="icon" type="image/x-icon" href="/images/favicon.ico">
<body>

<!-- Navigation Bar -->

<ul>
    <li><a href="profile.php" class="nav-bar-item">Profile</a></li>
    <li><a href="index.php" class="nav-bar-item">Home</a></li>
    <li style=" background-color: green; color: black;"><a href="news.php" class="nav-bar-item">News</a></li>
	<?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo "<li><a href=\"tickets.php\" class=\"nav-bar-item\">Tickets</a></li>";
        echo "<li><a href=\"createticket.php\" class=\"nav-bar-item\">Create Ticket</a></li>";
        echo "<li><a href=\"ticketview.php\" class=\"nav-bar-item\">Ticket View</a></li>";
        echo "<li style=\"float:right\"><a href=\"logout.php\" class=\"nav-bar-item\">Logout</a></li>";
    }
    else {
       echo "<li style=\"float:right\"><a href=\"login.php\" class=\"nav-bar-item\">Login</a></li>";
	   echo "<li style=\"float:right\"><a href=\"signup.php\" class=\"nav-bar-item\">Sign Up</a></li>";
    }
    ?>
</ul>
 
</body>
</php>