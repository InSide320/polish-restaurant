<?php

function getAllProducts(): false|array|null
{
    return DBHelper::selectAllProducts();
}

function getProductById($id): array
{
    return DBHelper::selectProductById($id);
}

function getCategoryById($id): bool|array|null
{
    return DBHelper::selectCategoryById($id);
}

function validateAndInsertProduct($productName, $categoryId, $description, $price, $photoContent): bool
{
    // additional check here
    if (isValidProductData($productName, $categoryId, $description, $price, $photoContent)) {
        return DBHelper::insertProductToDB($productName, $categoryId, $description, $price, $photoContent);
    }

    return false;
}

function isValidProductData($productName, $categoryId, $description, $price, $photoContent): bool
{
    // Додаткові перевірки даних тут
    return !(empty($productName) || empty($categoryId) || empty($description) || empty($price) || empty($photoContent));
}

function outputPhoto($photo): string
{
    return "data:image/jpeg;base64,".base64_encode($photo);
}
