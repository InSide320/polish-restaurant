<?php
include './../../header.php';
$data = $_POST;

if ($data) {

    include_once 'productAction.php';
    include_once './../../config/DBHelper.php';
    $productsToOrder = [];
    $countsToProduct = [];

    for ($i = 0, $iMax = count($data); $i < $iMax; $i++) {
        if (array_key_exists('product-id_' . $i, $data) && array_key_exists('count_' . $i, $data)) {
            $productsToOrder[] = getProductById((int)$data['product-id_' . $i]);
            $countsToProduct[] = (int)$data['count_' . $i];
        }


    }
    ?>
    <section class="main-section mw-1320">
        <div class="wrap-order">
            <form class="order-form" method="post" action="insertOrderToDB.php">
                <h1>Set information to contact you:</h1>
                <div class="wrap-personal-information">
                    <label for="full-name">Full name:<span style="color: #E01020;">*</span></label>
                    <input id="full-name"
                           class="input"
                           type="text"
                           value="<?= $_SESSION['fullName'] ?? '' ?>" name="full-name">
                </div>

                <div class="wrap-personal-information">
                    <label for="email">Email:<span style="color: #E01020;">*</span></label>
                    <input id="email" name="email" class="input" type="text" value="<?= $_SESSION['email'] ?? '' ?>"
                           required>
                </div>

                <div class="wrap-personal-information">
                    <label for="phone">Phone:<span style="color: #E01020;">*</span></label>
                    <input id="phone" name="phone" class="input"
                           type="tel"
                           maxlength="13"
                           value="<?= $_SESSION['phone'] ?? '' ?>"
                           required>
                </div>

                <table>
                    <caption>
                        <h3>Your order:</h3>
                    </caption>
                    <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name product</th>
                        <th>Col-vo</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $totalPrice = 0;
                    $i = 0;
                    foreach ($productsToOrder as $item) :
                        ?>
                        <tr>
                            <th>

                                <img src="<?= outputPhoto($item['photo']) ?>" width="50" height="50"
                                     alt="product">
                            </th>
                            <th>
                                <span><?= $item['product_name'] ?></span>
                            </th>
                            <th>
                                <input type="hidden" name="product-id_<?= $i ?>"
                                       value="<?= $item['product_id']; ?>">

                                <input type="hidden" name="count_<?= $i ?>"
                                       value="<?= $countsToProduct[$i] ?>">

                                <span><?= $countsToProduct[$i] ?></span>
                            </th>
                            <th>
                            <span><?php
                                $productPriceOrder = $countsToProduct[$i] * $item['price'];
                                $totalPrice += $productPriceOrder;
                                echo $productPriceOrder . ' zł'; ?></span>
                            </th>
                        </tr>
                        <?php
                        $i++;
                    endforeach;
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th scope="row" colspan="3" style="text-align: end;">Total price:</th>
                        <td style="text-align: center;"><b>
                                <?= $totalPrice ?> zł</b>
                            <input type="hidden" name="total-amount" value="<?= $totalPrice ?>">
                        </td>
                    </tr>
                    </tfoot>
                </table>
                <button type="submit" class="button" name="send">Send</button>
            </form>
    </section>
    </div>
    <?php
}

include './../../footer.php';
