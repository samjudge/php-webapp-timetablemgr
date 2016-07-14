<?php

	include(__DIR__."/dbConnect.php");
	include(__DIR__."/loggedInCheck.php");
	
	$sId = $_GET["shiftId"];
	$connection = connectToServer("root","admin");
	$connection->query("
			DELETE FROM shifts WHERE shiftId = '$sId'"
	);
	//echo $shiftType;
	header("Location:ui.php");
	
?>