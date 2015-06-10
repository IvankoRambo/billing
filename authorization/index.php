<?php
	$path = dirname(__FILE__);

	define("ERR_AUTH_NAME_UNSET", "1");
	define("ERR_AUTH_PASSWORD_UNSET", "2");
	$error_messages = array (
		ERR_AUTH_NAME_UNSET => "Write name, please.",
		ERR_AUTH_PASSWORD_UNSET => "Write password, please");
	$errAuth = 0;
	if (isset($_POST)) {
		if (!isset($_POST['name'])) {

			$errAuth = $errAuth | ERR_AUTH_NAME_UNSET;
		}
		if (!isset($_POST['password'])) {
			$errAuth = $errAuth | ERR_AUTH_PASSWORD_UNSET;
		}

		if (!$errAuth) {
			require($path.'/../db_work.php');

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
	<?php if ($errAuth) : ?>
		<?php foreach ($error_messages as $key => $value) : 
				if (($key & $errAuth) != 0) : ?>

					<div><?=$value ?></div>

		<?php  	endif;
			  endforeach;?> 
	<?php endif;?>
</body>
</html>