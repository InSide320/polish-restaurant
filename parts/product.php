<?php
require_once './../app/actions/productAction.php';
require_once './../config/DBHelper.php';
include './../header.php';
$idProduct = explode(
    "=",
    parse_url('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], PHP_URL_QUERY))[1];
$product = getProductById($idProduct); ?>
<section class="main-section mw-1320">
    <div class="wrap-product">
        <img loading="lazy" src="/assets/img/Pierogi_z_serem-1-1024x1024.jpg" width="350"
             height="350" alt="">
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
            <p><?= $product['product_name'] ?></p>
            <p><?= $product['price'] ?> zl</p>
            <p><?= $product['category_id'] ?></p>
        </div>

    </div>
</section>
<?php include './../footer.php'; ?>
