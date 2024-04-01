<?php

$data = $_POST;
include_once 'handleErrorMessage.php';
include_once 'productAction.php';
include_once './../../config/DBHelper.php';

if (isset($data['send'])) {
    $productId = $data['product-id'];
    changeProductInfo($data['description'], $data['method-preparing'], $data['ingredients'], $productId)
        ? flash("Additional info product change") : flash("Something was wrong with change additional information");
    header("Location: /admin-menu/edit-product.php?product-id=$productId&send=");
}
