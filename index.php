<?php




function page_index() {
    session_start();
    require('header.php');
    $db = getConnection(__DIR__.'/config/db.ini');

    if (isset($_POST['add'])) {
        insertIntoProducts($db, $_POST['name'], $_POST['price']);
    }

    $products = getAllProducts($db);
    if (!empty($_SESSION['isLogged'])) {
        ?>
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









