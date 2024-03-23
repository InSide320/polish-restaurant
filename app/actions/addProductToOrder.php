<?php
require_once('./handleErrorMessage.php');

$data = $_POST;
if (isset($data['send'])) {
    $_SESSION['order'][] = [
        'id' => $data['product_id'],
        'count' => $data['count'],
        'name' => $data['product_name'],
    ];
    flash("Product $data[product_name] add to card");
    header("Location: /");
}
