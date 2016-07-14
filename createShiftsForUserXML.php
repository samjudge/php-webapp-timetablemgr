<?php
/////////////////////////////////////////////////////////////////////////////80
	include(__DIR__."/dbConnect.php");
	include(__DIR__."/loggedInCheck.php");
	
	
	$connection = connectToServer("root","admin");
	$xml = new SimpleXMLElement('<xml/>');

	$result = $connection->query(
			"SELECT * FROM users WHERE $_SESSION['userId'] = userId"
	);
	
	while($row = $result->fetch_assoc()){
		$userNode = $xml->addChild("user");
		$username = $row["username"];
		$userId = $row["userId"];
		$userNode->addAttribute("username",$username);
		$resultShifts = $connection->query(
				"SELECT `shifts`.`date`,
						`shifts`.`startTime`,
						`shifts`.`endTime`
				FROM `shifts` INNER JOIN `users`
				ON `shifts`.`userId` = `users`.`userId`
				WHERE `shifts`.`userId` = $userId"
		);
		while($shiftRow = $resultShifts->fetch_assoc()){
			$shiftNode = $userNode->addChild("shift");
			$shiftDate = $shiftRow["date"];
			$shiftStart = $shiftRow["startTime"];
			$shiftEnd = $shiftRow["endTime"];
			$shiftNode->addAttribute("date",$shiftDate);
			$shiftNode->addAttribute("startTime",$shiftStart);
			$shiftNode->addAttribute("endTime",$shiftEnd);
		}
	}
	
	Header('Content-type: text/xml');
	print($xml->asXML());

?>