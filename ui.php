<!DOCTYPE html>
<?php

	include(__DIR__."/dbConnect.php");
	include(__DIR__."/loggedInCheck.php");
	$connection = connectToServer("root","admin");
	$result = $connection->query("
			SELECT *
			FROM messages
			WHERE isRead = 0
	");
	
	$noUnreadMessages = $result->num_rows();
	
?>
<html>
<head>
	<title>VSTT - UI</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="display-timetables.js"></script>
</head>
<body>
	<span id="userId" style="display:none"><?php $userId = $_SESSION['userId']; echo "$userId"; ?></span>
	<span id="authLevel" style="display:none"><?php echo $_SESSION["mgr"]; ?></span>
	<div id="top-section">
		<span>Welcome, 
		<?php
		echo $_SESSION["username"];
		?>
		!</span>
		<a href="logout.php">Log out</a>
	</div>
	<div id="mid-section">
		<div id="navigation">
			<ul>
				<li><a href="ui.php">Timetable</a></li>
				<li><a href="messages.php">Messages <?php if($noUnreadMessages > 0) echo " ("+$noUnreadMessages+")";?></a></li>
			</ul>
		</div>
		<div id="main-content">
		</div>
	</div>
	<div id="bottom-section">
		<br/>Produced for SAM CO., by sam.
	</div>
</body>
</html>