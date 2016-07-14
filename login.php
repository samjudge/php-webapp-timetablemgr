<!DOCTYPE html>
<?php
/////////////////////////////////////////////////////////////////////////////80
//hack-y code all over this page and site to follow, so hold onto your hat :)
//(also I use 80+1,2 or 3 in some places, so yeah. So don't even bother reading
//in terminal)
/////////////////////////////////////////////////////////////////////////////80
	include(__DIR__."/dbConnect.php");
	
	session_start();
	
	$errorMsg = false;
	
	if(isset($_POST['username']) && isset($_POST['password'])){
		$connection = connectToServer("root","admin");
		if($connection){
			$results = $connection->query(
				"SELECT * FROM `timetables`.`users`"
			);
			while($row = $results->fetch_assoc()){
				if ($row['username'] == $_POST['username']
						&& $row['password'] == $_POST['password']){
					$_SESSION['loggedIn'] = true;
					$_SESSION['userId'] = $row['userId'];
					$_SESSION['siteId'] = $row['siteId'];
					$_SESSION['username'] = $_POST['username'];
					if ($row['authlevel'] == 'admin') $_SESSION["admin"] = true;
					if ($row['authlevel'] == 'mgr') $_SESSION["mgr"] = true;
					header("Location: ui.php");
				}
			}
			$errorMsg = true;
		}
	}
?>
<html>
<head>
	<title>VSTT - Login</title>
</head>
<body>
	<form id="login-form" action="login.php" method="POST">
		<?php
		if ($errorMsg){
			echo '<span style="color:#FF0000">Your credentials are incorrect</span><br/>';
		}
		?>
		<span>Username</span><input name="username" type="text"><br/>
		<span>Password</span><input name="password" type="password"><br/>
		<input type="submit" value="Login"><br/>
	</form>
</body>
</html>