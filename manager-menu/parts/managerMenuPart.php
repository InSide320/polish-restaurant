<?php
include_once './../app/actions/orderAction.php';
include_once './../config/DBHelper.php';
$orders = getAllOrders();
//var_dump($orders);
$ordersStatusNew = [];
$ordersStatusProcessed = [];
$ordersStatusDelivered = [];
$ordersStatusSent = [];
$ordersStatusCanceled = [];

foreach ($orders as $order) {
    if ($order['order_status_id'] === 1) {
        $ordersStatusNew[] = $order['order_status_id'];
    } elseif ($order['order_status_id'] === 2) {
        $ordersStatusProcessed[] = $order['order_status_id'];
    } elseif ($order['order_status_id'] === 3) {
        $ordersStatusSent[] = $order['order_status_id'];
    } elseif ($order['order_status_id'] === 4) {
        $ordersStatusDelivered[] = $order['order_status_id'];
    } elseif ($order['order_status_id'] === 5) {
        $ordersStatusCanceled[] = $order['order_status_id'];
    }
}
?>
<div class="account-menu">
    <ul>
        <li>
            <a href="/my-account">
                <button class="button">Back to User</button>
            </a>
        </li>

        <li>
            <a href="/manager-menu/manager-panel">
                <button class="button <?= str_contains($_SERVER["REQUEST_URI"], 'manager-panel') ? 'active' : '' ?>">All
                    orders <span class="orders-length"><?= count($orders) ?></span></button>
            </a>
        </li>
        <li>
            <a href="/manager-menu/new-orders">
                <button class="button <?= str_contains($_SERVER["REQUEST_URI"], 'new-orders') ? 'active' : '' ?>">New
                    <span class="orders-length">
                        <?= count($ordersStatusNew) ?>
                    </span>
                </button>
            </a>
        </li>

        <li>
            <a href="/manager-menu/processed-orders">
                <button class="button <?= str_contains($_SERVER["REQUEST_URI"], 'processed-orders') ? 'active' : '' ?>">
                    Processed
                    <span class="orders-length">
                        <?= count($ordersStatusProcessed) ?>
                    </span>
                </button>
            </a>
        </li>
        <li>
            <a href="/manager-menu/delivered-orders">
                <button class="button <?= str_contains($_SERVER["REQUEST_URI"], 'delivered-orders') ? 'active' : '' ?>">
                    Delivered
                    <span class="orders-length">
                        <?= count($ordersStatusDelivered) ?>
                    </span>
                </button>
            </a>
        </li>

        <li>
            <a href="/manager-menu/sent-orders">
                <button class="button <?= str_contains($_SERVER["REQUEST_URI"], 'sent-orders') ? 'active' : '' ?>">Sent
                    <span class="orders-length">
                        <?= count($ordersStatusSent) ?>
                    </span>
                </button>
            </a>
        </li>

        <li>
            <a href="/manager-menu/canceled-orders">
                <button class="button <?= str_contains($_SERVER["REQUEST_URI"], 'canceled-orders') ? 'active' : '' ?>">
                    Canceled
                    <span class="orders-length">
                        <?= count($ordersStatusCanceled) ?>
                    </span>
                </button>
            </a>
        </li>

        <li>
            <form method="post" action="/app/actions/do_logout.php">
                <button class="button" type="submit">Logout</button>
            </form>
        </li>
    </ul>
</div>
