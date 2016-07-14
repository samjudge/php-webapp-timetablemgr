<?php
	include(__DIR__."/dbConnect.php");
	include(__DIR__."/loggedInCheck.php");
	
	$startTime = "00:00:00";
	$endTime = "00:00:00";
	$shiftName = "";
	$uId = $_GET["userId"];
	$date = $_GET["date"];
	$connection = connectToServer("root","admin");
	$siteId = $_SESSION["siteId"];
?>

<html>
<head>
	<title>VSTT - New Shift</title>
	<script language="javascript" type="text/javascript" src="datetimepicker.js"></script>
	<script language="javascript" type="text/javascript" src="addEditInputValidation.js"></script>
</head>
<body>
	
	<form method="POST" onsubmit="return(formValidation());" action="shiftAddSubmission.php">
		<input name="userId" style="visibility:hidden" value="<?php echo $uId ?>">
		<br/>
		<?php
			echo "Staff Name : <select name='username' id='username'>";
			$result = $connection->query("SELECT username,userId FROM
					users WHERE siteId = $siteId"
			);
			while($row = $result->fetch_assoc()){
				$username = $row["username"];
				if ($row["userId"] == $uId){
					echo "<option value='$username' selected>$username</option>";
				} else {
					echo "<option value='$username'>$username</option>";
				}
			}
			echo "</select>";
		?>
		<br/>
		<br/>
		<?php
			echo "Shift Type : <select name='shifttype' id='type'>";
			$result = $connection->query("SELECT title FROM shifttypes");
			while($row = $result->fetch_assoc()){
				$title = $row["title"];
				if ($row["title"] == $shiftName){
					echo "<option value='$title' selected>$title</option>";				
				} else {
					echo "<option value='$title'>$title</option>";
				}
			}
			echo "</select>";
		?>
		<br/>
		<br/>
		Date : <input name="date" id="date" type="text" size="25" value="<?php echo $date?>"><a href="javascript:NewCal('date','yyyymmdd')"><img src="cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
		<span id="dateError" style="color:#FF0000"></span>
		<br/>
		<br/>
		Start Time : <input id="start" name="start" type="text" value="<?php echo $startTime ?>">
		<span id="sTimeError" style="color:#FF0000"></span>
		<br/>
		<br/>
		End Time : <input id="end" name="end" type="text" value="<?php echo $endTime ?>">
		<span id="eTimeError" style="color:#FF0000"></span>
		<br/>
		<br/>
		<input type="submit" value="Commit Change">
	</form>
</body>
</html>