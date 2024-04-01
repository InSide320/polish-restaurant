<?php

$data = $_POST;
include_once 'handleErrorMessage.php';
include_once 'productAction.php';
include_once './../../config/DBHelper.php';

if (isset($data['send'])) {
    $productId = $data['product-id'];
    $allCategories = getAllCategories();
    $idCategoryProduct = 1;
    foreach ($allCategories as $category) {
        if ($category['category_name'] === $data['category-name']) {
            $idCategoryProduct = $category['category_id'];
        }
    }

    changeProductMainDetails($data['product-name'], $idCategoryProduct, $data['price'], $productId)
        ? flash("Main product information change") : flash("Something was wrong with change main information");
    header("Location: /admin-menu/edit-product.php?product-id=$productId&send=");
}
