<?php

require_once __DIR__ . '/../db_work.php';

$db = getConnection(__DIR__.'/../config/db.ini');

$data['user_name'] = ( isset($_POST['user_name']) ) ? $_POST['user_name'] : null;
$data['password'] = ( isset($_POST['password']) ) ? $_POST['password'] : null;

$response = array(
	'data' => null,
	'additional' => null,
	'success' => false
);

if(isset($_POST['r_b'])) {
if(!$data['user_name'] || !$data['password']){
	$response['data'] = 'You ought to fill all fields!';	
}
else{
	if(insertNewAdmin($db, $data['user_name'], $data['password'])){
		$response['success'] = true;
		$response['data'] = 'You have been successfully registered';
	}
	else {
		$response['data'] = 'The user with such login is already exists';
	}
}

}


?>


<body>
	
	<?php if(!$response['success']) : ?>
		<div>Registation of a new user</div> <br />
	<form method="POST" action=<?= $_SERVER['SCRIPT_NAME'] ?> >
		<span>Your name:</span><br />
		<input type="text" name="user_name" required  /><br />
		<span>Your password:</span><br />
		<input type="password" name="password" required /><br />
		<button name="r_b">Register</button>
	</form>
	<?php endif; ?>
	
	<?php if(!empty($_POST)) : ?>
		<div id="reg_info"><?= $response['data']; ?></div>
	<?php endif; ?>
	
	<?php if($response['success']) : ?>
	<form method="POST">
        <a href="index_update.php">Go back</a>
	</form>
	<?php endif; ?>
	
	<br />

    <a href="index_update.php">Exit</a>
