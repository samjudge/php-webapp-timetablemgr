<?php
/////////////////////////////////////////////////////////////////////////////80
function connectToServer($username,$password){
	$servername = 'p:localhost';
	$connection = new mysqli($servername, $username, $password, "timetables");
	return $connection;
}

?>