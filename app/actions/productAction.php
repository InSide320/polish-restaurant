<?php


function getAllProducts(): false|array|null
{
    return DBHelper::selectAllProducts();
}

function getProductById($id): array
{
    return DBHelper::selectProductById($id);
}

function validateAndInsertProduct($productName, $categoryId, $description, $price, $photoContent): bool
{
    // Додаткові перевірки тут
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

