<?php 
	$errAuth = 0;
	if (isset($_POST)) {
		if (isset($_POST['name']) && isset($_POST['password'])) {

		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Authorization page</title>
</head>
<body>
	<form method="Post">
		<span>Name:</span><br>
		<input type="edit" name="name" value="Princess"><br>
		<span>Password:</span><br>
		<input type="edit" name="password" value="my_little_pony"><br>
		<input type="submit" value="Login"> 
	</form>
</body>
</html>