<?php

include(__DIR__."/dbConnect.php");
include(__DIR__."/loggedInCheck.php");

$connection = connectToServer("root","admin");

$sId = $_SESSION["siteId"];

$senderName = $_POST["senderName"];
$recipientName = $_POST["recipientName"];
$msgBody = $_POST["messageBody"];
$title = $_POST["title"];

$date = getdate();

$dd = (string)$date["mday"];
$mm = (string)$date["mon"];
$yyyy = (string)$date["year"];

if(strlen($dd) == 1){
	$dd = sprintf("%d%d","0",$dd);
}


if(strlen($mm) == 1){
	$mm = sprintf("%d%d","0",$mm);
}

$dateString = sprintf("%s-%s-%s",$yyyy,$mm,$dd);

$result = $connection->query("
		SELECT userId FROM users
		WHERE username = \"$recipientName\"
		AND siteId = $sId"
);
$row = $result->fetch_assoc();
$rUId = $row["userId"];

$result = $connection->query("
		INSERT INTO messages(userId,messageTitle,messageBody,dateSent,isRead,sender)
		VALUES ($rUId, \"$title\", \"$msgBody\", \"$dateString\", 0, \"$senderName\")"
);

header("Location:messages.php")


?>