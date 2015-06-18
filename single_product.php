<?php

require_once __DIR__.'/db_work.php';
require_once __DIR__.'/loggings.php';

$pause = 2;
$product_id = (int)$_GET['product_id'];
$db = getConnection($config_path);
$product_info = getProductsViaId($db, $product_id);

$response = array(
	'success' => false,
	'deleted' => false,
	'data' => null
);

if(isset($_POST['update'])){
	
	$data['name'] = ( isset($_POST['name']) ) ? $_POST['name'] : null;
	$data['price'] = ( isset($_POST['price']) ) ? $_POST['price'] : null;
	
	if(!$data['name'] || !$data['price']){
		$response['data'] = 'All fields are required to be filled';
	}
	else{
		
		if(($data['name'] == $product_info[0]['name']) && ($data['price'] == $product_info[0]['price'])){
			$response['data'] = 'You didn\'t arrange any changes';	
		}
		else{
			if(updateProduct($db, $product_id, $data['name'], $data['price'])){
				$response['success'] = true;
				$response['data'] = 'You have been successfully update product info';
				
			$products = getAllProducts($db);
			$products = filterProductsKeys($products);
			$products_json = convertProductsInJSON($db, $products);
			
			if(($prod_response = sendData($db ,'products', $products_json, 'http://127.0.0.1/billing/get_test/test_get_products.php')) && !preg_match('/not found/', $prod_response)){
				insertIntoLogFile('products_response.log', $prod_response, date("Y-m-d H:i:s"));
			}
				
			}
			else{
				$response['data'] = 'Product with such name already exists in the system';
			}
		}
		
	}
	
}

if(isset($_POST['delete'])){
	
	if(deleteProduct($db, $product_id)){
		$response['data'] = 'You have been successfully deleted product';
		$response['deleted'] = true;
		$response['success'] = true;
		
		$products = getAllProducts($db);
		$products = filterProductsKeys($products);
		$products_json = convertProductsInJSON($db, $products, date("Y-m-d H:i:s"));
			
			if(($prod_response = sendData($db ,'products', $products_json, 'http://127.0.0.1/billing/get_test/test_get_products.php')) && !preg_match('/not found/', $prod_response)){
				insertIntoLogFile('products_response.log', $prod_response);
			}
		
	}
	else{
		$response['data'] = 'Probably, the product was deleted by other agent before you';
	}
	
}


?>

<body>

<?php if(!$response['deleted']) : ?>
<form id="update_form" method="POST">
	<span>Name of Good</span><br />
	<?php if(!isset($_POST['name'])) : ?>
	<input type="text" name="name" value="<?= $product_info['0']['name']; ?>" /><br />
	<?php else : ?>
	<input type="text" name="name" value="<?= $_POST['name']; ?>" /><br />
	<?php endif; ?>
	<span>Price of Good</span><br />
	<?php if(!isset($_POST['price'])) : ?>
	<input type="text" name="price" value="<?= $product_info['0']['price']; ?>" /><br />
	<?php else : ?>
	<input type="text" name="price" value="<?= $_POST['price']; ?>" /><br />
	<?php endif; ?>
	<button name="update">Update</button>
</form>



<form id="delete_form" method="POST">
	<button name="delete">Delete</button>
</form>
<?php endif; ?>

<div id="message">
	<?php
		ob_start();
		echo $response['data'];
		ob_end_flush();
	?>
</div>

<?php if(!$response['deleted']) : ?>
	<form method="POST" action="index.php">
		<button>Back to the billing page</button>
	</form>
<?php endif; ?>


<?php

if($response['deleted'])	header('Refresh: '.$pause.'; URL=index.php');

?>

</body>

