<?php
require('db_work.php');
$config_path = 'config/db.ini';
$db = getConnection($config_path);


if (isset($_POST['add'])) {
    insertIntoProducts($db, $_POST['name'], $_POST['price']);
    header("Location: index.php");
}

$products = getAllProducts($db);

?>
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

    <div class="row">
        <div class="add_product_form">
            <h4>Adding new product:</h4>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <p><input type="text" name="name" required placeholder="name"/>
                <input type="text" name="price" required placeholder="price"/>
                <input type="submit" name="add" value="Add" class="btn btn-primary btn-sm"/></p>
            </form>
        </div>
    </div>

    <table class="products_table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
    <?php foreach($products as $product) : ?>
        <tr>
            <td><?=$product['name']?></td>
            <td><?=$product['price']?></td>
            <td><button type="button" class="btn btn-info">
                    <span class="glyphicon glyphicon-pencil"></span>
                </button></td>
            <td><a href="#" class="btn btn-info">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a></td>
        </tr>
    <?php endforeach; ?>
    </table>




</div>
<?php
require('footer.php');