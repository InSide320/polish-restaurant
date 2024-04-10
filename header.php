<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant</title>
    <link rel="stylesheet" href="/assets/style/style.css"/>
    <link rel="stylesheet" href="/assets/style/rtl.css"/>
    <script src="/assets/js/main.js"></script>
</head>
<body>
<div class="root">
    <header class="mw-1320">
        <div class="wrap-header">
            <nav class="nav-container">
                <?php include 'parts/mainMenu.php' ?>
            </nav>
        </div>
    </header>
    <?php
    $isOtherPage = str_contains($_SERVER['REQUEST_URI'], 'admin-menu')
        || str_contains($_SERVER['REQUEST_URI'], 'manager-menu')
        || str_contains($_SERVER['REQUEST_URI'], 'my-account')
        || str_contains($_SERVER['REQUEST_URI'], 'user-menu');
    if (!$isOtherPage):
        include_once 'app/actions/getUrl.php';
        include_once 'app/actions/productAction.php';
        include_once 'config/DBHelper.php';

        $before = "<span> > </span>";

        $urlPath = parse_url(getFullURL(), PHP_URL_PATH);
        $urlHasQuery = parse_url(getFullURL(), PHP_URL_QUERY) ?? false;
        $isProductPage = str_contains($urlPath, 'product');

        if ($isProductPage) :
            $arr = $urlHasQuery ? explode('=', $urlHasQuery) : false;
            $productIdHeader = $arr ? array_combine((array)$arr[0], (array)$arr[1]) : "";
            $productIdHeaderById = getProductById($productIdHeader['id']);
            $category = getCategoryById($productIdHeaderById['category_id']);
            ?>
            <div class="wrap-breadcrumbs">
                <a href="/">Home</a>
                <?= $before ?>
                <a href="/menu/<?= strtolower(str_replace(' ', '-', $category['category_name'])) ?>">
                    <?= $category['category_name'] ?>
                </a>
                <?= $before ?>
                <?= $productIdHeaderById['product_name'] ?>
            </div>
        <?php else:
            $requestURI = urldecode($_SERVER['REQUEST_URI']);
            $isPageOrders = str_contains($requestURI, 'orders');
            $pageCategoryOrOrders = $isPageOrders ? 'orders' : null;

            if (!$isPageOrders) {
                foreach (getAllCategories() as $item) {
                    $categoryNameInURL = strtolower(str_replace(' ', '-', $item['category_name']));
                    if (str_contains($requestURI, $categoryNameInURL)) {
                        $pageCategoryOrOrders = $item['category_name'];
                        break;
                    }
                }
            }

            if (isset($pageCategoryOrOrders)) {
                ?>
                <div class="wrap-breadcrumbs">
                    <a href="/">Home</a>
                    <?= $before ?>
                    <?= $pageCategoryOrOrders ?>
                </div>
            <?php }
        endif;
    endif; ?>
