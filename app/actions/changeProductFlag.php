<?php
// Включаємо файли, які можуть бути потрібні
include_once 'handleErrorMessage.php';
include_once 'productAction.php';
include_once './../../config/DBHelper.php';

// Перевіряємо, чи були надіслані дані форми
if (isset($_POST['send'])) {
    // Отримуємо дані з форми
    $idProduct = $_POST['product-id'];
    $flag = $_POST['flag'];

    // Викликаємо функцію для зміни прапорців продукту
    if ($flag === 'new') {
        $result = changeProductFlags(1, 0, $idProduct);
    } elseif ($flag === 'popular') {
        $result = changeProductFlags(0, 1, $idProduct);
    } else {
        $result = changeProductFlags(0, 0, $idProduct);
    }

    // Перевіряємо результат і виводимо повідомлення
    if ($result) {
        flash("Product flag change");
    } else {
        flash("Something was wrong");
    }

    // Перенаправляємо користувача назад на сторінку редагування продукту
    header("Location: /admin-menu/edit-product.php?product-id=$idProduct&send=");
}
