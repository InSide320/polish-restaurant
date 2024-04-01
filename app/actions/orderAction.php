<?php

function setOrderToDB($fullName, $phone, $email, $totalAmount, $user = null): int
{
    return DBHelper::insertOrderToDB($user, $fullName, $phone, $email, $totalAmount);
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
