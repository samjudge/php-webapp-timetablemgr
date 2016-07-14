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
			UPDATE shifts SET
			userId = $uId,
			startTime = '$start',
			endTime = '$end',
			date = '$date',
			shiftTitleId = $sTitleId
			WHERE shiftId = $sId"
	);
	//echo $shiftType;
	header("Location:ui.php");
	
?>