<?php
	require_once '/var/www/dev.school-server/www/billing_v1/db_work.php';
	session_start();
	$db = getConnection('/var/www/dev.school-server/www/billing_v1//config/db.ini');
	
	$data['name'] = ( isset($_POST['name']) ) ? $_POST['name'] : null;	
	$data['password'] = ( isset($_POST['password']) ) ? $_POST['password'] : null;
	
	$response = array(
	'data' => null,
	'success' => false
	);
	
	if(isset($_POST['button'])){
		
	if(!($data['name']) || !($data['password'])){
		$data['data'] = 'You have to fill all fields';	
	}
	else{
		
		if(isRightPassword($db, $data['name'], $data['password'])){
			$response['data'] = 'You\'ve been successfully logged in,';
			$_SESSION['name_'.$data['name']] = $data['name'];
			$response['success'] = true;
		}
		else{
			$response['data'] = 'You typed the wrong password';
		}
		
	}
	
	}

?>
    <body>
		
		<?php if(!$response['success']) : ?>
        <form id="auth" method="POST" action=<?= $_SERVER["SCRIPT_NAME"] ?> >
            <span>Your name:</span><br />
            <input type="text" id="email" name="name" /><br>
            <span>Your password:</span><br />
            <input type="password" id="password" name="password" /><br />
            <button name="button">Log in</button>
        </form><br />
        <?php endif; ?>
        
		<?php if(!empty($_POST)) : ?>
			<div id="message_log"><?= $response['data']; ?></div>
		<?php endif; ?>
		
        <br />
        
        
       	<?php if(isset($data['name']) && isset($_SESSION['name_'.$data['name']])) : ?>
        <form id="exit" method="POST">
                <button name="exit">Exit</button>
        </form>
        <?php endif; ?>
  
       
    </body>