<?php
include './../header.php';
include_once './../config/DBHelper.php';

include_once './../app/actions/productAction.php';
?>
    <section class="main-section mw-1320">
        <div class="wrap-order">
            <?php
            $array = [];

            if ($_SESSION['order'] !== null) {
//                    $_SESSION['order'] = null;
                $arr = $_SESSION['order'];
                ?>
                <form>
                    <h1>Cart</h1>
                    <ul class="orders-list">
                        <?php
                        foreach ($arr as $item) :
                            $getProduct = getProductById($item['id']);
                            ?>
                            <li>
<!--                                <button>Remove --><?php //array_search() ?><!--</button>-->
                                <img src="<?= outputPhoto($getProduct['photo']) ?>" width="50" height="50"
                                     alt="product">
                                <span><?= $item['name'] ?></span>
                                <span><?= getCategoryById($getProduct['category_id'])['category_name'] ?></span>
                                <div class="wrap-order-price">
                                    <label for="count">count:</label>
                                    <input class="input" id="count" name="number" type="number"
                                           value="<?= $item['count'] ?>" min="1" max="10">
                                    <input type="hidden" class="price-product" value="<?= $getProduct['price'] ?>">
                                    <span class="price">
                                        <?= number_format($getProduct['price'] * $item['count'], 2, '.', '') ?>
                                        zł
                                    </span>
                                </div>
                            </li>
                        <?php
                        endforeach;
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
                        //                                                echo $totalPrice;
                        ?>
                            <input
                                    type="hidden"
                                    id="total-price"
                                    value="<?= $totalPrice ?>"
                            >
                    <span id="total-prices">
                        <?= $totalPrice ?>
                    </span>
                        zł
                </span>

                    <button class="button" style="width: 100px;" type="submit">Submit</button>
                </form>
            <?php } else {
                echo "Set order, pls";
            }
            ?>
        </div>
    </section>
    <script src="/assets/js/totalPrice.js"></script>
<?php
include './../footer.php';
