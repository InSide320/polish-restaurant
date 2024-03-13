<?php
// Отримуємо дані з форми
//$productName = $_POST['product_name'];
//$categoryId = $_POST['category_id'];
//$description = $_POST['description'];
//$price = $_POST['price'];
//$photoContent = addslashes(file_get_contents($_FILES['photo']['tmp_name']));

if ($_POST['send']) {
    $productName = $_POST['product_name'];
    $categoryId = $_POST['category_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $photoContent = addslashes(file_get_contents($_FILES['photo']['tmp_name']));

    if (validateAndInsertProduct($productName, $categoryId, $description, $price, $photoContent)) {
        echo "Продукт успішно збережено.";
    } else {
        echo "Помилка при збереженні продукту.";
    }
}
