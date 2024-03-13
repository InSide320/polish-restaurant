<?php

$products = getAllProducts();
shuffle($products);
?>
<ul class="product__items">
    <?php foreach ($products as $product) {
        if ($category === 0 || (int)$product['category_id'] === $category) {
            ?>
            <li class="product__item">
                <a href="/parts/product?id=<?= $product['product_id'] ?>">
                    <img loading="lazy" src="/assets/img/Pierogi_z_serem-1-1024x1024.jpg" width="350"
                         height="350" alt="">
                    <div class="product__description">
                        <div class="productSticker__flag">
                            <div class="productSticker-flag__item">
                                Popular
                            </div>
                        </div>
                        <p><?= $product['product_name'] ?></p>
                        <p><?= $product['price'] ?> zl</p>
                        <p><?= $product['category_id'] ?></p>
                    </div>
                </a>
            </li>
        <?php }
    } ?>

</ul>
