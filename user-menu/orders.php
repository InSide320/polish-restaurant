<?php include_once './../header.php'; ?>
<section class="main-section mw-1320">
    <h2>Moje konto</h2>
    <div class="wrap-my-account">
        <?php $username = $_SESSION["username"]; ?>
        <?php include_once 'parts/userMenuPart.php';
        include_once './../app/actions/orderAction.php';
        include_once './../app/actions/productAction.php';
        include_once './../config/DBHelper.php';
        ?>
        <div class="wrap-account-information">
            <div class="account-information">
                <?php
                $orders = getOrdersByUserId($_SESSION['user_id']);
                ?>
                <table>
                    <thead>
                    <tr>
                        <td>Date</td>
                        <td>Product</td>
                        <td>Total</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($orders as $order):
                        $ordersDetails = getOrderDetailsById($order['id']); ?>
                        <tr>
                            <td class="table-date">
                                <?= $order['order_date'] ?>
                            </td>
                            <td class="product-table">
                                <table class="product-table" aria-hidden="true">
                                    <thead>
                                    <tr>
                                        <td>Photo</td>
                                        <td>Name</td>
                                        <td>Amount</td>
                                        <td>Price</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($ordersDetails as $detail) {
                                        $product = getProductById($detail['product_id']);
                                        ?>
                                        <tr>

                                            <td class="product-table-photo">
                                                <img src="<?= outputPhoto($product['photo']) ?>" width="50" height="50"
                                                     alt="product">
                                            </td>

                                            <td class="product-table-name">
                                                <?= $product['product_name'] ?>
                                            </td>
                                            <td class="product-table-quantity">
                                                <?= $detail['quantity'] ?>
                                            </td>
                                            <td class="product-table-price">
                                                <?= $detail['price'] ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </td>
                            <td><?= $order['total_amount'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php

                ?>
            </div>
        </div>
    </div>
</section>
<?php include_once './../footer.php'; ?>
