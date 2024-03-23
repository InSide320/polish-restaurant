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
            <img class="product-image" loading="lazy" width="524"
                 height="524" alt="img" src="<?=outputPhoto($product['photo']) ?>"/>

            <?php include './addOrder.php' ?>
        </div>
        <div class="product__description">
            <div class="productSticker__flag">
                <div class="productSticker-flag__item">
                    <?php
                    if ((bool)$product['is_popular'] === true): echo 'popular';
                    elseif ((bool)$product['is_new'] === true) : echo 'new';
                    else: echo '';
                    endif;
                    ?>
                </div>
            </div>
            <p class="product-name"><b><?= $product['product_name'] ?></b></p>
            <p><?= $product['description'] ?></p>
            <p><b>Sposób przygotowania:</b> <?= $product['method_preparing'] ?></p>
            <div><b>Składniki:</b>

                <?php
                $ingredients = explode(',', $product['ingredients']);
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
