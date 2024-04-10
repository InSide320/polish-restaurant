<?php include_once './../header.php'; ?>
<section class="main-section mw-1320">
    <h2>Moje konto</h2>
    <div class="wrap-my-account">
        <?php $username = $_SESSION["username"]; ?>
        <?php include_once 'parts/managerMenuPart.php';
        include_once './../app/actions/orderAction.php';
        include_once './../app/actions/productAction.php';
        include_once './../app/actions/handleErrorMessage.php';
        include_once './../config/DBHelper.php';
        ?>
        <div class="wrap-account-information">
            <div class="account-information">
                <?php
                flash();

                // Пагінація
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $results_per_page = 10; // Кількість результатів на сторінці
                $offset = ($page - 1) * $results_per_page;

                $orderStatusNew = getStatusByOrderStatusId(1);

                $orders =
                    selectAllOrdersPaginationByCategoryId(
                        $offset,
                        $results_per_page,
                        $orderStatusNew['status_id']
                    );
                $total_pages =
                    ceil(selectTotalOrdersCountByCategoryId(
                            $orderStatusNew['status_id']) / $results_per_page
                    );


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
                        $orderStatusNew = getStatusByOrderStatusId($order['order_status_id'])['status_name'];
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
                                <?= $orderStatusNew ?>
                            </td>
                            <td>
                                <form method="get" action="change-order.php">
                                    <input type="hidden" name="order-id" value="<?= $order['id'] ?>">
                                    <button class="button" name="send" type="submit">Info</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Пагінація -->
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a class="button <?= $i == $page ? 'active' : '' ?>" href="?page=<?= $i ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once './../footer.php'; ?>
