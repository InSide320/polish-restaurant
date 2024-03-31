<?php
$data = $_POST;

if (isset($data['send'])) {
    include_once 'orderAction.php';
    include_once 'productAction.php';
    include_once 'handleErrorMessage.php';
    include_once './../../config/DBHelper.php';

    $orderResult = setOrderToDB(
        $data['full-name'],
        $data['phone'], $data['email'],
        $data['total-amount'],
        $_SESSION['user_id'] ?? null
    );

    if ($orderResult) {
        $orderId = DBHelper::connectToDB()->insert_id; // Отримання ідентифікатора нового замовлення

        $productsToOrder = [];
        $countsToProduct = [];

        for ($i = 0, $iMax = count($data); $i < $iMax; $i++) {
            if (array_key_exists('product-id_' . $i, $data) && array_key_exists('count_' . $i, $data)) {
                $productsToOrder[] = getProductById((int)$data['product-id_' . $i]);
                $countsToProduct[] = (int)$data['count_' . $i];
            }
        }

        $i = 0;
        foreach ($productsToOrder as $item) {
            $detailsResult = DBHelper::insertOrderDetailsToDB(
                $orderId,
                $item['product_id'],
                $countsToProduct[$i],
                $countsToProduct[$i] * $item['price']
            );
            $i++;
        }

        if ($detailsResult) {
            flash("Замовлення успішно сформоване");
            $_SESSION['order'] = null;
        } else {
            flash("Помилка при додаванні деталей замовлення.");
        }
    } else {
        flash("Помилка при додаванні замовлення.");
    }

    header("Location: /");
}
