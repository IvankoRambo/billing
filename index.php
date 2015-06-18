<?php

function page_index() {
    session_start();
    require('header.php');
    $db = getConnection(__DIR__.'/config/db.ini');
	
	$product_message = array(
		'data' => null
	);
	
    if (isset($_POST['add'])) {
        if(insertIntoProducts($db, $_POST['name'], $_POST['price'])){
        $product_message['data'] = 'New product was added successfully';
		$products = getAllProducts($db);
		$products = filterProductsKeys($products);
		$products_json = convertProductsInJSON($db, $products);
		$prod_response = sendData($db ,'products', $products_json, 'http://dev.school-server/billing_v1/get_test/test_get_producs.php');
		if($prod_response != 'File not found.'){
			insertIntoLogFile('products_response.log', $prod_response);
		}
		//sending product 
		//sendData()
		//adding success response into log file, if response is false than failed script listening
		}
		else $product_message['data'] = 'Product with such name alredy exists in the system';
    }

    $products = getAllProducts($db);
    if (!empty($_SESSION['isLogged'])) {
        ?>
       <div id="product_message"><?= $product_message['data']; ?></div>
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
                <?php for ($i = 0; $i < count($products); $i++) : ?>
                    <tr>
                        <td><?= $products[$i]['name'] ?></td>
                        <td><?= $products[$i]['price'] ?></td>
                        <td><a href="<?= "single_product.php?product_id={$products[$i]['id']}"; ?>" class="btn btn-info pull-right">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a></td>
                    </tr>


                <?php endfor; ?>
            </table>
        </form>
    <?php
    } else {
        echo '<div class="row center-row">
            <div class="center">
                <h1 align=center>Hi, please sign in to continue...</h1>
            </div>
        </div>';
    }

}


page_index();
require('footer.php');

