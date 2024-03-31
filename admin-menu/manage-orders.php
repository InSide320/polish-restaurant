<?php include_once './../header.php'; ?>
<section class="main-section mw-1320">
    <h2>Moje konto</h2>
    <div class="wrap-my-account">
        <?php $username = $_SESSION["username"]; ?>
        <?php include_once 'parts/adminMenuPart.php';
        include_once './../app/actions/orderAction.php';
        include_once './../app/actions/productAction.php';
        include_once './../app/actions/handleErrorMessage.php';
        include_once './../config/DBHelper.php';
        ?>
        <div class="wrap-account-information">
            <div class="account-information">
                <?php
                flash();
                $orders = getAllOrders();
                ?>
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
                    foreach ($orders as $order):
                        $ordersDetails = getOrderDetailsById($order['id']); ?>
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
                            <td id="status-order">
                                <?= getStatusByOrderStatusId($order['order_status_id'])['status_name'] ?>
                            </td>
                            <td>
                                <form method="get" action="./change-order.php">
                                    <input type="hidden" name="order-id" value="<?= $order['id'] ?>">
                                    <button class="button" name="send" type="submit">Get full info</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                    endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php include_once './../footer.php'; ?>
