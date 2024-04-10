<?php
$data = $_POST;

if (isset($data['send'])) {
    include_once 'handleErrorMessage.php';
    include_once 'orderAction.php';
    include_once './../../config/DBHelper.php';
    $status = $data['status-order'];
    $id = $data['order-id'];
    $isUpdateStatus = changeOrderStatus($id, $status);
    if ($isUpdateStatus) {
        flash("Order status changed in order №: $id to: '$status''");
    } else {
        flash("Something is wrong with the update status with order №: $id");
    }
    header('Location: /manager-menu/manager-panel');
}
