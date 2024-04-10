<?php
$data = $_POST;

if (isset($data['send'])) {
    include_once 'orderAction.php';
    include_once 'productAction.php';
    include_once 'handleErrorMessage.php';
    include_once './../../config/DBHelper.php';

    $orderResult = setOrderToDB(
        $data['full-name'],
        $data['phone'],
        $data['email'],
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

        $orderDetails = "";
        $totalPriceProduct = 0;
        $totalPrice = [];

        foreach ($productsToOrder as $item) {
            $totalPriceProduct = $countsToProduct[$i] * $item['price'];
            $totalPrice [] = $totalPriceProduct;
            $orderDetails .= "Product: {$item['product_name']} | Quantity: {$countsToProduct[$i]} | Price: {$totalPriceProduct} zł<br>";

            $detailsResult = DBHelper::insertOrderDetailsToDB(
                $orderId,
                $item['product_id'],
                $countsToProduct[$i],
                $countsToProduct[$i] * $item['price']
            );
            $i++;
        }

        if ($detailsResult) {
            include_once 'getUrl.php';
            include_once 'send.php';
            $sendUrl = url();
            $_SESSION['order'] = null;
            $sumPrice = array_sum($totalPrice);

            $mail = configureMailer("Zamówienie zostało przesłane do realizacji", "
            <div class='mail-message'>
                    <div class='wrap-mail-message'>
                        <a href=$sendUrl>
                            <img src=cid:logo width='200px' height='100px' alt='logo'>
                        </a>
                        <div class='mail-body'>
                            <p>Dziękuję za Twoje zamówienie. Szczegóły Twojego zamówienia:</p>
                            <p>$orderDetails</p>
                            <p>Całkowita cena: $sumPrice</p>
                            <p>Aby uzyskać więcej informacji, skontaktuj się z naszym menadżerem.</p>
                        </div>
                    </div>
                </div>
            ");
            try {
                $mail->addAddress($data["email"]);
                $mail->addEmbeddedImage('./../../assets/img/logo.png', 'logo', 'logo.png');
                $mail->send();
            } catch (\PHPMailer\PHPMailer\Exception $e) {
                flash("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
            flash("Замовлення успішно сформоване");
        } else {
            flash("Помилка при додаванні деталей замовлення.");
        }
    } else {
        flash("Помилка при додаванні замовлення.");
    }

    header("Location: /");
}
