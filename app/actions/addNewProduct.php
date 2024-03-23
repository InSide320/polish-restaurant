<?php

$data = $_POST;
include_once './../../config/DBHelper.php';
include_once './productAction.php';

if (isset($data['send'])) {
    var_dump($data);

    $productName = $data['product-name'];
    $categoryId = $data['id_category'];
    $description = $data['description'];
    $price = $data['price'];
    $photoContent = addslashes(file_get_contents($_FILES['photo']['tmp_name']));

    var_dump($data);

    if (validateAndInsertProduct($productName, $categoryId, $description, $price, $photoContent)) {
        var_dump("Продукт успішно збережено.");
    } else {
        var_dump("Помилка при збереженні продукту.");
    }
} else {
    var_dump("Something was wrong!");
}
