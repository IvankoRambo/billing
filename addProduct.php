<?php
require('db_work.php');

$config_path = 'config/db.ini';
$db = getConnection($config_path);

/**
 * @param pdo $db
 * @param string $name
 * @param float $price
 */
function addProduct($db, $name, $price) {
    $query = $db->prepare("INSERT INTO products(name, price)
		VALUES(:name, :price)");
    $query->execute(array(
        "name" => $name,
        "price" => $price));
}

//addProduct($db, 'windows', 100);

//var_dump(getAllProducts($db));

if (isset($_POST['add'])) {
    addProduct($db, $_POST['name'], $_POST['price']);
//    header("Location: index.php");
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add new product</title>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <p><input type="text" name="name" required placeholder="name"/></p>
        <p><input type="text" name="price" required placeholder="price"/></p>
        <p><input type="submit" name="add" value="add" class="btn btn-primary center-block"/></p>
    </form>
</body>
</html>



