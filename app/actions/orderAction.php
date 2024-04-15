<?php

function setOrderToDB($fullName, $phone, $email, $totalAmount, $user = null): int
{
    $timestamp = new DateTime();
    $timestamp->modify('+1 hours');
    $timestampString = $timestamp->format('Y-m-d H:i:s');

    return DBHelper::insertOrderToDB($user, $fullName, $phone, $email, $timestampString, $totalAmount);
}

function setOrderDetailsToDB($orderId, $productId, $quantity, $price): bool
{
    return DBHelper::insertOrderDetailsToDB($orderId, $productId, $quantity, $price);
}

function getOrdersByUserId($id): array
{
    return DBHelper::selectOrdersByUserId($id);
}

function getAllOrders(): array
{
    return DBHelper::selectAllOrders();
}

function getOrderById($id): bool|array|null
{
    return DBHelper::selectOrderById($id);
}

function getOrderDetailsById($id): array
{
    return DBHelper::selectOrderDetailsById($id);
}

function getStatusByOrderStatusId($id): bool|array|null
{
    return DBHelper::selectOrderStatusById($id);
}

function getAllOrderStatuses(): ?array
{
    return DBHelper::selectAllOrderStatuses();
}

function changeOrderStatus($orderId, $newStatus): bool
{
    $statusId = DBHelper::selectOrderStatusByName($newStatus);
    return DBHelper::updateOrderStatus($orderId, $statusId['status_id']);
}

function selectAllOrdersPagination($offset, $limit): array
{
    return DBHelper::getAllOrdersPagination($offset, $limit);
}

function selectTotalOrdersCount()
{
    return DBHelper::getTotalOrdersCount();
}

function selectAllOrdersPaginationByCategoryId($offset, $limit, $categoryId): array
{
    return DBHelper::getAllOrdersPaginationByCategoryId($offset, $limit, $categoryId);
}

function selectTotalOrdersCountByCategoryId($categoryId)
{
    return DBHelper::getTotalOrdersCountByCategoryId($categoryId);
}
