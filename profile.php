<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
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
// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $con->prepare('SELECT txtPassword, txtEmail FROM tblUser WHERE tblUserid = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="stylesheet.css" rel="stylesheet" type="text/css">
	</head>
<ul>
    <li style="background-color: green; color: black;"><a href="index.php" class="nav-bar-item">Profile</a></li>
    <li><a href="index.php" class="nav-bar-item">Home</a></li>
    <li><a href="news.php" class="nav-bar-item">News</a></li>
	<?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		echo "<li><a href=\"tickets.php\" class=\"nav-bar-item\">Tickets</a></li>";
		echo "<li><a href=\"createticket.php\" class=\"nav-bar-item\">Create Ticket</a></li>";
		echo "<li ><a href=\"ticketview.php\" class=\"nav-bar-item\">Ticket View</a></li>";
        echo "<li style=\"float:right\"><a href=\"logout.php\" class=\"nav-bar-item\">Logout</a></li>";
    }
    else {
       echo "<li style=\"float:right\"><a href=\"login.php\" class=\"nav-bar-item\">Login</a></li>";
	   echo "<li style=\"float:right\"><a href=\"signup.php\" class=\"nav-bar-item\">Sign Up</a></li>";
    }
    ?>
</ul>
		</nav>
		<div class="profile_content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=$password?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>

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
			$stmt = $con->prepare("SELECT tblTicketId, intStatus, intUserOwnerId, txtSubject, dCreated FROM tblTicket where intUserOwnerId = ? and intStatus in (1,2,3) ORDER BY tblticketid ASC LIMIT ".$y.",1");
			$stmt->bind_param('i',$_SESSION['id']);
			$stmt->execute();
			$stmt->bind_result(${"ticketId".$y}, ${"status".$y}, ${"userowner".$y}, ${"subject".$y}, ${"created".$y});
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

<div class="content">
			
			<div class="profile_tickets">
				<h2>Open Tickets</h2>
				<p>Total Tickets: <?=$noTotal?></p>
				<p>Total Open Tickets: <?=$noOpen?></p>
				<p>Your open tickets are below:</p>
				<?php
				$x = 1; //used to repeat while statement
				$y = 0; //used to create variable names

				while($x <= $noOpen) {
					${"statusTxt".$y} ='';
					if (${"status".$y} == 1){
						${"statusTxt".$y} = 'Open';
					}
					else if (${"status".$y} == 2){
						${"statusTxt".$y} = 'Pending';
					}
					else if (${"status".$y} == 3){
						${"statusTxt".$y} = 'On Hold';
					}
					else {
						//ticket is closed, do not display
					}
					$ticketLink = ${"ticketId".$y};
					$ticketFolder = $_SESSION['id'];
				echo "<table>
				<tr>
					<td><a href=\"$ticketFolder/$ticketLink.php\">
					</a>${"subject".$y}</td>
					<td>${"statusTxt".$y} </td>
					<td>${"userownerName".$y} </td>
					<td>${"created".$y} </td>
				</tr>
				</table>";
				$y++;
				$x++;
				}
				?>
			</div>
		</div>

</html>

