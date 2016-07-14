<?php

include(__DIR__."/dbConnect.php");
include(__DIR__."/loggedInCheck.php");

$senderId = $_SESSION['userId'];

$connection = connectToServer("root","admin");

$result = $connection->query("
		SELECT username FROM users
		WHERE userId = $senderId"
);

$row = $result->fetch_assoc();

$senderName = $row["username"];
$siteId = $_SESSION["siteId"];
?>
<html>
<head>
<title> VSTT - Send Message </title>
</head>
<body>
	<form method="POST" action="updateMessages.php">
		<input name="senderName" style="display:none" value="<?php echo $senderName ?>">
		<?php
				echo "<span>Recipient :
						</span><select name='recipientName' id='username'>";
				$result = $connection->query("
						SELECT username,userId
						FROM users WHERE siteId = $siteId"
				);
				while($row = $result->fetch_assoc()){
					$username = $row["username"];
					echo "<option value='$username'>$username</option>";
				}
				echo "</select>";
		?>
		<br/>Title:<br/><input name="title" type="text">
		<br/>Message:<br/><textarea name="messageBody" cols="40" rows="5"></textarea>
		<br/><input type="submit" value="Send Message">
	</form>
</body>
</html>