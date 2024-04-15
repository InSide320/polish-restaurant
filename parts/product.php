<?php
require_once './../app/actions/productAction.php';
require_once './../config/DBHelper.php';
include './../header.php';
require_once './../app/actions/handleErrorMessage.php';
$idProduct = explode(
    "=",
    parse_url('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], PHP_URL_QUERY))[1];
$product = getProductById($idProduct); ?>
<section class="main-section mw-1320">
    <div class="wrap-product">
        <div class="wrap-product-image">
            <h1><?= $product['product_name'] ?></h1>
            <img class="product-image" loading="lazy" width="524"
                 height="524" alt="img" src="<?= outputPhoto($product['photo']) ?>"/>

            <?php include './addOrder.php' ?>
        </div>
        <div class="product__description">
            <div class="productSticker__flag">
                <?php
                if ((bool)$product['is_popular'] === true): echo "<div class=productSticker-flag__item>popular</div>";
                elseif ((bool)$product['is_new'] === true) : echo "<div class=productSticker-flag__item>new</div>";
                else: echo '';
                endif;
                ?>

            </div>
            <p class="product-name"><b><?= $product['product_name'] ?></b></p>
            <p><?= $product['description'] ?></p>
            <p><b>Sposób przygotowania:</b> <?= $product['method_preparing'] ?></p>
            <div><b>Składniki:</b>

                <?php
                $ingredients = !empty($product['ingredients']) ? explode(',', $product['ingredients']) : [];
                foreach ($ingredients as $ingredient): ?>
                    <ul>
                        <li style="list-style: inside ">
                            <?= $ingredient ?>
                        </li>
                    </ul>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>
<?php include './../footer.php'; ?>
