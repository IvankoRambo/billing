<!DOCTYPE html>
<html lang="en">
<head>
    <link href="styles/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css" type="text/css">
    <meta charset="UTF-8">
    <title>Agent UI</title>
</head>
<body>
<div class="container-fluid">
<?php
require __DIR__ . '/db_work.php';
$db = getConnection(__DIR__.'/config/db.ini');

$data['name'] = ( isset($_POST['name']) ) ? $_POST['name'] : null;
$data['password'] = ( isset($_POST['password']) ) ? $_POST['password'] : null;

$response = array(
    'data' => null,
    'success' => false
);

if(isset($_POST['sign_in'])){
    if(isRightPassword($db, $data['name'], $data['password'])){
        $_SESSION['name'] = $data['name'];
        $_SESSION['isLogged'] = true;
    }
    else{
        echo 'Access denied!';
    }
}
?>

<div class="row">
    <div class="" id="top_panel">
        <?php if (!empty($_SESSION['isLogged'])): ?>
            <h4>Welcome <?=$_SESSION['name']?></a></h4>
            <a href="logout.php" class="btn btn-primary" role="button">Logout</a>
        <?php else: ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <p><input type="text" name="name" placeholder="login" required /></p>
                <p><input type="password" name="password" placeholder="password" required /></p>
                <input type="submit" name="sign_in" value="Sign in" class="btn btn-success"/>
                <a href="registration.php" class="btn btn-primary" role="button">Register</a>
            </form>
        <?php endif; ?>
    </div>
</div>