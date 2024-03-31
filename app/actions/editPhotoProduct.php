<?php

$data = $_POST;

if (isset($data['send'])) {
    include_once './../../config/DBHelper.php';
    include_once 'handleErrorMessage.php';
    include_once 'productAction.php';

    $idProduct = $data['product-id'];

    // Отримання файлу фото з форми
    $photoTmpName = $_FILES['photo']['tmp_name'];

    // Перевірка, чи файл було успішно завантажено
    if ($photoTmpName !== '') {
        // Зчитування вмісту файлу
        $photoContent = addslashes(file_get_contents($photoTmpName));

        // Оновлення фото продукту за його ідентифікатором
        $isUpdatedPhotoProduct = changeProductPhotoById($idProduct, $photoContent);

        if ($isUpdatedPhotoProduct) {
            flash("Photo has changed");
        } else {
            flash("Something was wrong with update photo");
        }
    } else {
        flash("Error: No photo uploaded");
    }

    header("Location: /admin-menu/edit-product.php?product-id=$idProduct&send=");
}

