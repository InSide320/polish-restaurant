<?php

if (isset($_POST['remove-all-products'])) {
    $_SESSION['order'] = null;
    header('Location: /cart/orders');
}
