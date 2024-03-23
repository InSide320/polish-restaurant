<?php

$products = getAllProducts();
shuffle($products);
flash();
?>
<ul class="product__items">
    <?php foreach ($products as $product) {
        if ($category === 0 || (int)$product['category_id'] === $category) {
            ?>
            <li class="product__item">
                <a href="/parts/product?id=<?= $product['product_id'] ?>">
                    <img class="product-image" loading="lazy" src="<?=outputPhoto($product['photo']) ?>" width="350"
                         height="350" alt="">
                    <div class="product__description">
                        <div class="productSticker__flag">
                            <div class="productSticker-flag__item">
                                Popular
                            </div>
                        </div>
                        <p><?= $product['product_name'] ?></p>
                        <p><?= $product['price'] ?></p>
                    </div>
                </a>
            </li>
        <?php }
    } ?>

</ul>
