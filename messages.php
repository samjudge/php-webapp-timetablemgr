<?php

include(__DIR__."/dbConnect.php");
include(__DIR__."/loggedInCheck.php");

$uId = $_SESSION['userId'];

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
				<li><a href="messages.php">Messages<?php if($noUnreadMessages > 0) echo " ("+$noUnreadMessages+")";?></a></li>
			</ul>
		</div>
		<div id="main-content">
			<span><a href="sendMessage.php">Send a new message</a></span>
			<?php
			
			$result = $connection->query("
					SELECT * FROM messages
					WHERE userId = $uId"
			);
			
			$messageId;
			$messageTitle;
			$messageDate;
			$messageIsRead;
			echo "<ul>";
			if($result->num_rows == 0){
				echo "No messages";
			}
			while($row = $result->fetch_assoc()){
				$messageId = $row["messageId"];
				$messageTitle = $row["messageTitle"];
				$messageDate = $row["dateSent"];
				$messageIsRead = $row["isRead"];
				$messageSender = $row["sender"];
				if($messageIsRead == 0){
					echo "<b>";
				}
				echo "<li><a href='readMessage.php?messageId=$messageId'>
						$messageTitle</a> - Received @ $messageDate
						From $messageSender</li>";
				if($messageIsRead == 0){
					echo "</b>";
				}
			}
			echo "</ul>";
			?>
		</div>
	</div>
	<div id="bottom-section">
		<br/>Produced for SAM CO., by sam.
	</div>
	

	
	</body>
</html>
