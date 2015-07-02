<?php

require_once __DIR__ . '/db_work.php';

$db = getConnection(__DIR__.'/config/db.ini');

$data['user_name'] = ( isset($_POST['user_name']) ) ? $_POST['user_name'] : null;
$data['password'] = ( isset($_POST['password']) ) ? $_POST['password'] : null;

$response = array(
	'data' => null,
	'additional' => null,
	'success' => false
);

if(isset($_POST['sign_up'])) {
	if(insertNewAdmin($db, $data['user_name'], $data['password'])){
		$response['success'] = true;
		$response['data'] = 'You have been successfully registered';
	}
	else {
		$response['data'] = 'The user with such login is already exists';
	}

}

?>
<body>
	<?php if(!$response['success']) : ?>
		<div>Registration of a new user</div> <br />
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<span>Your name:</span><br />
		<input type="text" name="user_name" required  /><br />
		<span>Your password:</span><br />
		<input type="password" name="password" required /><br />
		<button name="sign_up">Register</button>
	</form>
	<?php endif; ?>
	
	<?php if(!empty($_POST)) : ?>
		<div id="reg_info"><?= $response['data']; ?></div>
	<?php endif; ?>
	
	<?php if($response['success']) : ?>
	<form method="POST">
        <a href="index.php">Go back</a>
	</form>
	<?php endif; ?>
	
	<br />

    <a href="index.php">Exit</a>
