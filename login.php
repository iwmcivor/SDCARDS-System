<?php require('header.php'); 
session_start();
if(isset($_SESSION['user']))
	header("Location: http://students.engr.scu.edu/~ravila/upload.php");
?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<link href="style.css" rel="stylesheet" type="text/css">
        </head>
	<body>
		<div class="bar">
			Welcome to SDCARDS
			<!--small img on left edge of bar
			navigation imagebuttons on right side of bar-->
		</div>
		<!--large logo image-->
		<div class="tile-container">
			<div class="tile">
				<div>
					<h1>Login</h1>
				</div>
				<form name="auth" action="auth.php" method="post">
				<div>
					<input type="text" id="tbUsername" name="username" placeholder="Username" />
				</div>
				<div>
					<input type="password" id="tbPassword" name="password" placeholder="Password" />
				</div>
				<div>
					<input type="submit" value="Login" />
				</div>
				</form>
			</div>
		</div>
	</body>
</html>
