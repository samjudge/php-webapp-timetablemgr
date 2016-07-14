<?php

include(__DIR__."/dbConnect.php");
include(__DIR__."/loggedInCheck.php");

$uId = $_SESSION['userId'];

$connection = connectToServer("root","admin");

$uId = $_SESSION['userId'];
$mId = $_GET['messageId'];

$result = $connection->query("SELECT * FROM messages WHERE messageId = $mId");

if($result->num_rows == 0){
	header("Location: messages.php");
}

$messageBody;
$messageTitle;
$messageDate;

while($row = $result->fetch_assoc()){
	$locUId = $row["userId"];
	$messageBody = $row["messageBody"];
	$messageTitle = $row["messageTitle"];
	$messageDate = $row["dateSent"];
	$messageSender = $row["sender"];
	if ($locUId != $uId){
		header("Location: messages.php");
	} else {
		$connection->query("UPDATE messages SET isRead = 1 WHERE messageId = $mId");
	}
	
}



?>
<html>
	<head>
		<title>VSTT - Messages</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
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
				<li><a href="messages.php">Messages</a></li>
			</ul>
		</div>
		<div id="main-content">
			<div id="message">
				<?php
				echo "<h1>$messageTitle</h1>";
				echo "<span id='message-date-sent'>Sent : $messageDate</span><br/><br/>";
				echo "<span> From : $messageSender</span>";
				echo "<br/><br/><div id='message-content'>$messageBody</div>";
				?>
				<br/>
			</div>
			<span><a href="messages.php">[Back To Messages]</a></span>
		</div>
	</div>
	<div id="bottom-section">
		<br/>Produced for SAM CO., by sam.
	</div>
	

	
	</body>
</html>
