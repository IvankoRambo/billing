<?php
	require_once __DIR__ . '/../db_work.php';
	session_start();

	$db = getConnection(__DIR__.'/../config/db.ini');
	
	$data['name'] = ( isset($_POST['name']) ) ? $_POST['name'] : null;	
	$data['password'] = ( isset($_POST['password']) ) ? $_POST['password'] : null;
	
	$response = array(
	'data' => null,
	'success' => false
	);
	
	if(isset($_POST['button'])){
		
        if(!($data['name']) || !($data['password'])){
            $response['data'] = 'You have to fill all fields';
        }
	else{
		
		if(isRightPassword($db, $data['name'], $data['password'])){
			$response['data'] = 'You\'ve been successfully logged in,';
//			$_SESSION['name_'.$data['name']] = $data['name'];
			$_SESSION['name'] = $data['name'];
            $_SESSION['isLogged'] = true;
			$response['success'] = true;
		}
		else{
			$response['data'] = 'You typed the wrong password or name';
		}
		
	}
	
	}

	if(isset($_POST['exit'])) {
        session_destroy();
        $_SESSION = array();
    }

?>
    <body>
		
		<?php if(!isset($_SESSION['name'])) : ?>
        <form id="auth" method="POST" action=<?= $_SERVER["SCRIPT_NAME"] ?> >
            <span>Your name:</span><br />
            <input type="text" id="email" name="name" /><br>
            <span>Your password:</span><br />
            <input type="password" id="password" name="password" /><br />
            <button name="button">Log in</button>
        </form><br />
        <?php endif; ?>
        

        <?php if(isset($_SESSION['isLogged'])) : ?>
			<div id="message_log"><?= "Welcome " . $_SESSION['name'] ?></div>
		<?php endif; ?>
		
        <br />
        
        <?php if(!isset($_SESSION['name'])) : ?>
            <div id="message_log"><?= $response['data']; ?></div>
            <form method="POST" action="registration.php" >
                <button name="register">Register</button>
            </form>
        <?php endif; ?>
        
        
       	<?php if(/*isset($data['name']) &&*/ isset($_SESSION['name'])) : ?>
        <form id="exit" method="POST">
                <button name="exit">Exit</button>
        </form>
        <?php endif; ?>
  
       
    </body>
