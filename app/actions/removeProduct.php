<?php
$data = $_POST;

if (isset($data['send'])) {
    include_once './../../config/DBHelper.php';
    include_once 'handleErrorMessage.php';
    include_once 'productAction.php';
    $idProduct = $data['product-id'];
    $isDeleteProduct = removeProductById($idProduct);

    if ($isDeleteProduct) {
        flash("The product has been removed: $idProduct");
    } else {
        flash("Something is wrong with removing a product by ID: $idProduct");
    }
    header("Location: /admin-menu/manage-products");
}
