<?php

$data = $_POST;
include_once './../../config/DBHelper.php';
include_once './productAction.php';
include_once 'handleErrorMessage.php';

if (isset($data['send'])) {
    var_dump($data);

    $productName = $data['product-name'];
    $categoryId = $data['id_category'];
    $description = $data['description'];
    $price = $data['price'];
    $photoContent = addslashes(file_get_contents($_FILES['photo']['tmp_name']));

    if (validateAndInsertProduct($productName, $categoryId, $description, $price, $photoContent)) {
        flash("Product was added");
    } else {
        flash("Помилка при збереженні продукту");

    }
} else {
    flash("Something was wrong!");
}

header("Location: /admin-menu/add-new-product");
