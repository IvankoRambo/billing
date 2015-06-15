<?php
require('db_work.php');
$config_path = 'config/db.ini';
$db = getConnection($config_path);


if (isset($_POST['add'])) {
    insertIntoProducts($db, $_POST['name'], $_POST['price']);
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
            <form method="post">
                <p><input type="text" name="name" required placeholder="name"/>
                <input type="text" name="price" required placeholder="price"/>
                <input type="submit" name="add" value="Add" class="btn btn-primary btn-sm"/></p>
            </form>
        </div>
    </div>
    
	<form method="post">
    <table class="products_table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
    <?php for($i = 0; $i < count($products); $i++) : ?>
    	<?php $id = $products[$i]['id']; ?>
    	
    	
        <tr>
            <td><?=$products[$i]['name']?></td>
            <td><?=$products[$i]['price']?></td>
            <td><a href=<?= 'single_edit.php?product_id='.$id; ?> >
                    <span class="glyphicon glyphicon-pencil">EDIT</span>
                </a></td>
        </tr>
       
       
    <?php endfor; ?>
    </table>
	</form>


</div>
<?php
require('footer.php');