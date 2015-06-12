<?php

require_once '/var/www/dev.school-server/www/billing_v1/db_work.php';

$db = getConnection('/var/www/dev.school-server/www/billing_v1/config/db.ini');

$data['user_name'] = ( isset($_POST['user_name']) ) ? $_POST['user_name'] : null;
$data['password'] = ( isset($_POST['password']) ) ? $_POST['password'] : null;

$response = array(
	'data' => null,
	'additional' => null,
	'success' => false
);

if(isset($_POST)){
if(!$data['user_name'] || !$data['password']){
	$response['data'] = 'You ought to fill all fields!';	
}
else{
	$user_data = getUserInfo($db, $data['email']);
	if(empty($user_data)){
		$response['success'] = true;
		createUser($db, $data['user_name'], $data['email'], $data['password'], date('Y-m-d H:i:s'), (int)$data['is_active']);
		$response['data'] = 'You have been successfully registered';
		$diff_info = registration_difference($db, 'name1', 'name2', 'minute_diff');
		$response['additional'] = ( $diff_info['0']['minute_diff'] == 0 ) ? 'The previous user registered less than minute ago. We a pretty popular now.' : "The previous user registered {$diff_info['0']['minute_diff']} minutes ago";
	}
	else{
		$response['data'] = 'User with such email already exists in the system';
	}
}

}

?>


<body>
	
	<?php if(!$response['success']) : ?>
		<div>Registation of a new user</div> <br />
	<form method="POST" action=<?= $_SERVER['SCRIPT_NAME'] ?> >
		<span>Your name:</span><br />
		<input type="text" name="user_name"  /><br />
		<span>Your password:</span><br />
		<input type="text" name="password" /><br />
		<button name="r_b">Register</button>
	</form>
	<?php endif; ?>
	
	<?php if(!empty($_POST)) : ?>
		<div id="reg_info"><?= $response['data']; ?></div>
	<?php endif; ?>
	
	<?php if($response['success']) : ?>
	<form method="POST">
		<button name="b_b">Back to the registation</button>
	</form>
	<?php endif; ?>
	
	<br />
	
	
	<form id="exit" method="POST" action="auth.php">
        <button name="exit">Exit</button>
    </form>
	