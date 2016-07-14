<?php
/////////////////////////////////////////////////////////////////////////////80
include(__DIR__."/dbConnect.php");

session_start();

session_unset();
$_SESSION = array();
session_destroy();

?>
<html>
<head>
	<title>VSTT - Logout</title>
</head>
<body>
	<span>You have been logged out.</span> <br/>
	<span><a href="login.php">Return to login</a></span>
</body>
</html>
