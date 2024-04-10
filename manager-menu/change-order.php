<?php
include_once './../header.php';

$data = $_GET;

?>

<section class="main-section mw-1320">
    <h2>Moje konto</h2>
    <div class="wrap-my-account">
        <?php
        include_once 'parts/managerMenuPart.php';
        include_once './../app/actions/orderAction.php';
        include_once './../app/actions/productAction.php';
        include_once './../config/DBHelper.php';
        ?>
        <div class="wrap-account-information">
            <div class="account-information">
                <?php if (isset($data['send'])) : ?>
                    <form method="post" action="./../app/actions/changeOrderStatus.php">

                        <table>
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Date</th>
                                <th>User contact</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $order = getOrderById((int)$data['order-id']);
                            $ordersDetails = getOrderDetailsById($order['id']);
                            ?>
                            <tr>
                                <td>
                                    <?= $order['id'] ?>
                                </td>
                                <td class="table-date">
                                    <?= $order['order_date'] ?>
                                </td>
                                <td>
                                    <ul>
                                        <li>
                                            <?= $order['email'] ?>
                                        </li>
                                        <li>
                                            <?= $order['phone'] ?>
                                        </li>
                                        <li>
                                            <?= $order['full_name_user'] ?>
                                        </li>
                                    </ul>
                                </td>
                                <td><?= $order['total_amount'] ?></td>
                                <td>
                                    <div class="wrap-status-select">
                                        <label for="status-order">Select status: </label>
                                        <?php
                                        $allOrderStatusesName = getAllOrderStatuses();
                                        $statusOrder = getStatusByOrderStatusId($order['order_status_id'])['status_name'] ?>
                                        <select name="status-order"
                                                id="status-order" class="input">
                                            <?php foreach ($allOrderStatusesName as $item): ?>
                                                <option name="status_order" value="<?= $item['status_name'] ?>"
                                                    <?= $item['status_name'] === $statusOrder ? 'selected' : '' ?>>
                                                    <?= $item['status_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input type="hidden" name="order-id" value="<?= $order['id'] ?>">
                                    <button class="button" name="send" type="submit">Save</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                    <?php ?>
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
                <?php
                endif; ?>
            </div>
        </div>
    </div>
</section>
<?php include_once './../footer.php'; ?>

