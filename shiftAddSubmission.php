<?php

	include(__DIR__."/dbConnect.php");
	include(__DIR__."/loggedInCheck.php");
	
	$sId = $_POST["shiftId"];
	$start = $_POST["start"];
	$end = $_POST["end"];
	$date = $_POST["date"];
	$shiftType = $_POST["shifttype"];
	$nShiftType = $shiftType;
	$connection = connectToServer("root","admin");
	$user = $_POST["username"];
	$nUser = $user;
	$siteId = $_SESSION['siteId'];
	$result = $connection->query("
			SELECT userId FROM users
			WHERE username = '$nUser' AND siteId = $siteId");
	$row = $result->fetch_assoc();
	$uId = $row["userId"];
	$result = $connection->query("
			SELECT shiftTitleId
			FROM shifttypes
			WHERE title = '$nShiftType'"
	);
	$row = $result->fetch_assoc();
	
	$sTitleId = $row["shiftTitleId"];
	

	$connection->query("
			INSERT INTO shifts(userId,startTime,endTime,date,shiftTitleId)
			VALUES ('$uId','$start','$end','$date','$sTitleId')"
	);
	
	//should use cURL, but not my server so doing it this way
	
	$senderName = "Automated";
	$recipientName = $_POST["recipientName"];
	$msgBody = "You have been assigned a shift on $date, from $start to $end doing $shiftType.";
	$title = "New Shift on $date";

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
			INSERT INTO messages(userId,messageTitle,messageBody,dateSent,isRead,sender)
			VALUES ($uId, \"$title\", \"$msgBody\", \"$dateString\", 0, \"$senderName\")"
	);
	
	
	//echo $shiftType;
	header("Location:ui.php");
	
?>