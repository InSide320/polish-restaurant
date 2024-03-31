<?php
include './../header.php';
include_once './../config/DBHelper.php';

include_once './../app/actions/productAction.php';
?>
    <section class="main-section mw-1320">
        <div class="wrap-order">
            <?php
            $array = [];
            if (isset($_SESSION['order'])) {
                $arr = $_SESSION['order'];
                ?>
                <form class="order-form" method="post" action="../app/actions/addPersonalInformationToOrder.php">
                    <h1>Cart</h1>
                    <ul class="orders-list">
                        <?php

                        for ($i = 0, $iMax = count($arr); $i < $iMax; $i++) :
                            $getProduct = getProductById($arr[$i]['id']);
                            ?>
                            <li>
                                <input type="hidden" name="product-id_<?= $i ?>"
                                       value="
                                       <?= $getProduct['product_id']; ?>">

                                <img src="<?= outputPhoto($getProduct['photo']) ?>" width="50" height="50"
                                     alt="product">
                                <span><?= $arr[$i]['name'] ?></span>
                                <span><?= getCategoryById($getProduct['category_id'])['category_name'] ?></span>
                                <div class="wrap-order-price">
                                    <label for="count">count:</label>
                                    <input class="input" id="count" name="count_<?= $i ?>" type="number"
                                           value="<?php echo $arr[$i]['count']; ?>" min="1" max="10">

                                    <input type="hidden" class="price-product" value="<?= $getProduct['price'] ?>">

                                    <span class="price">
                                        <?= number_format($getProduct['price'] * $arr[$i]['count'], 2, '.', '') ?>
                                        zł
                                    </span>
                                </div>
                            </li>
                        <?php
                        endfor;
                        ?>
                    </ul>
                    <span id="total">Total price:
                        <?php
                        $totalPrice = 0;
                        foreach ($arr as $item) {
                            $getProduct = getProductById($item['id']);
                            $totalPrice += (double)$getProduct['price'] * $item['count'];
                        }
                        $totalPrice = number_format($totalPrice, 2, '.', '');
                        ?>
                        <span id="total-prices">
                            <?= $totalPrice ?>
                        </span>
                            zł
                    </span>

                    <div class="wrap-button-order">
                        <button class="button" type="submit" name="send">Submit</button>
                    </div>
                </form>
                <form class="remove-item-from-order" method="post" action="removeItemFromOrder.php">
                    <button type="submit" name="remove-all-products" class="button">
                        Remove all product
                    </button>
                </form>
            <?php } else { ?>
                <div class="wrap-empty-order">
                    <span>Set order, pls</span>
                    <button class="button" id="redirectToShop">Go to shop</button>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
    <script src="/assets/js/totalPrice.js"></script>
<?php
include './../footer.php';
