<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Tickets</title>
		<link href="stylesheet.css" rel="stylesheet" type="text/css">
	</head>
<ul>
    <li><a href="profile.php" class="nav-bar-item">Profile</a></li>
    <li><a href="index.php" class="nav-bar-item">Home</a></li>
    <li><a href="news.php" class="nav-bar-item">News</a></li>
	<?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo "<li><a href=\"tickets.php\" class=\"nav-bar-item\">Tickets</a></li>";
		echo "<li><a href=\"createticket.php\" class=\"nav-bar-item\">Create Ticket</a></li>";
        echo "<li style=\"background-color: green; color: black;\"><a href=\"ticketview.php\" class=\"nav-bar-item\">Ticket View</a></li>";
        echo "<li style=\"float:right\"><a href=\"logout.php\" class=\"nav-bar-item\">Logout</a></li>";
		echo "<div>
		<button class=\"searchbtn\" type=\"submit\"/>Search</button>
		  <input class=\"searchbar\" type=\"text\" placeholder=\"Search Tickets...\" name=\"search\">
		  
	  </div>";
    }
    else {
       echo "<li style=\"float:right\"><a href=\"login.php\" class=\"nav-bar-item\">Login</a></li>";
	   echo "<li style=\"float:right\"><a href=\"signup.php\" class=\"nav-bar-item\">Sign Up</a></li>";
    }
    ?>
</ul>


	<?php
		if (!isset($_SESSION['loggedin'])) {
			header('Location: index.php');
			exit;
		}
		$DATABASE_HOST = 'localhost';
		$DATABASE_USER = 'root';
		$DATABASE_PASS = '';
		$DATABASE_NAME = 'CRM_Test';
		$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
		if (mysqli_connect_errno()) {
			exit('Failed to connect to MySQL: ' . mysqli_connect_error());
		}
		$stmt = $con->prepare('SELECT COUNT(tblTicketId) FROM tblticket WHERE intUserOwnerId = ? and intStatus in (1,2,3)');
		$stmt->bind_param('i', $_SESSION['id']);
		$stmt->execute();
		$stmt->bind_result($noOpen);
		$stmt->fetch();
		$stmt->close();
		$stmt = $con->prepare('SELECT COUNT(tblTicketId) FROM tblticket WHERE intUserOwnerId = ?');
		$stmt->bind_param('i', $_SESSION['id']);
		$stmt->execute();
		$stmt->bind_result($noTotal);
		$stmt->fetch();
		$stmt->close();
		$y = 0;
		while ($y <= $noOpen) {
			$stmt = $con->prepare("SELECT tblTicketId, intStatus, intUserOwnerId FROM tblTicket where intUserOwnerId = ? and intStatus in (1,2,3) ORDER BY tblticketid ASC LIMIT ".$y.",1");
			$stmt->bind_param('i',$_SESSION['id']);
			$stmt->execute();
			$stmt->bind_result(${"ticketId".$y}, ${"status".$y}, ${"userowner".$y});
			$stmt->fetch();
			$stmt->close();
			$stmt = $con->prepare("SELECT txtUsername FROM tblUser where tblUserId = ?");
			$stmt->bind_param('i',$_SESSION['id']);
			$stmt->execute();
			$stmt->bind_result(${"userownerName".$y});
			$stmt->fetch();
			$stmt->close();
			$y++;
		}
	?>


</html>

