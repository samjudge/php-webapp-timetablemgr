<?php
/////////////////////////////////////////////////////////////////////////////80
	include(__DIR__."/dbConnect.php");
	include(__DIR__."/loggedInCheck.php");
	
	
	$connection = connectToServer("root","admin");
	$xml = new SimpleXMLElement('<xml/>');
	
	//echo $connection==false?"0":"1";
	
	$siteId =  $_SESSION['siteId'];
	
	$result = $connection->query(
			"SELECT * FROM users WHERE siteId = $siteId"
	);
	
	//echo $result==false?"0":"1";
	
	while($row = $result->fetch_assoc()){
		$userNode = $xml->addChild("user");
		$username = $row["username"];
		$userId = $row["userId"];
		$userNode->addAttribute("username",$username);
		$userNode->addAttribute("userId",$userId);
		$resultShifts = $connection->query(
				"SELECT `shifts`.`date`,
						`shifts`.`startTime`,
						`shifts`.`endTime`,
						`users`.`userId`,
						`shifts`.`shiftTitleId`,
						`shifts`.`shiftId`
				FROM `shifts` INNER JOIN `users`
				ON `shifts`.`userId` = `users`.`userId`
				WHERE `shifts`.`userId` = $userId"
		);
		while($shiftRow = $resultShifts->fetch_assoc()){
			$shiftNode = $userNode->addChild("shift");
			$shiftDate = $shiftRow["date"];
			$shiftStart = $shiftRow["startTime"];
			$shiftEnd = $shiftRow["endTime"];
			$shiftId = $shiftRow["shiftId"];
			$shiftNode->addAttribute("date",$shiftDate);
			$shiftNode->addAttribute("startTime",$shiftStart);
			$shiftNode->addAttribute("endTime",$shiftEnd);
			$shiftNode->addAttribute("shiftId",$shiftId);
			$titleId = $shiftRow['shiftTitleId'];
			$shiftNameResult = $connection->query("
					SELECT title FROM shifttypes
					WHERE shiftTitleId = $titleId"
			);
			while($shiftNameRow = $shiftNameResult->fetch_assoc()){
				$shiftNode->addAttribute("shiftName",$shiftNameRow["title"]);
			}
		}
	}
	
	Header('Content-type: text/xml');
	print($xml->asXML());
	
?>