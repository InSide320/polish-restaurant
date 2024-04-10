<?php include_once './../header.php'; ?>
<section class="main-section mw-1320">
    <h2>Moje konto</h2>
    <div class="wrap-my-account">
        <?php
        $username = $_SESSION["username"];
        include_once 'parts/adminMenuPart.php';
        include_once './../app/actions/orderAction.php';
        include_once './../app/actions/productAction.php';
        include_once './../app/actions/handleErrorMessage.php';
        include_once './../config/DBHelper.php';

        // Параметри пагінації
        $records_per_page = 10;
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($current_page - 1) * $records_per_page;

        ?>
        <div class="wrap-account-information">
            <div class="account-information">

                <h1>Manage product</h1>

                <?php flash(); ?>

                <table class="product-table" aria-hidden="true">
                    <thead>
                    <tr>
                        <td>№</td>
                        <td>Photo</td>
                        <td>Name</td>
                        <td>Category</td>
                        <td>Price</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Отримання продуктів з пагінацією
                    $products = getAllProductsPaginated($offset, $records_per_page);
                    foreach ($products as $item) {
                        ?>
                        <tr>
                            <td>
                                <?= $item['product_id'] ?>
                            </td>
                            <td class="product-table-photo">
                                <img src="<?= outputPhoto($item['photo']) ?>" width="50" height="50"
                                     alt="product">
                            </td>

                            <td class="product-table-name">
                                <?= $item['product_name'] ?>
                            </td>
                            <td class="product-table-quantity">
                                <?= getCategoryById($item['category_id'])['category_name'] ?>
                            </td>
                            <td class="product-table-price">
                                <?= $item['price'] ?>
                            </td>
                            <td>
                                <form method="get" action="./edit-product.php">
                                    <input type="hidden" name="product-id" value="<?= $item['product_id'] ?>">
                                    <button class="button" name="send" type="submit">Edit</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>

                <?php
                // Відображення посилань на інші сторінки
                $total_records = countAllProducts();
                $total_pages = ceil($total_records / $records_per_page);
                include "./../app/actions/getUrl.php";
                $parseUrl = parse_url(getFullURL(), PHP_URL_QUERY);
                $isFirstPage = $parseUrl === null ? 'active' : '';
                $activePageId = $isFirstPage === '' ? explode('=', $parseUrl)[1] : '';

                echo "<div class='pagination'>";
                for ($i = 1; $i <= $total_pages; $i++) {
                    $buttonClass = ($isFirstPage !== '' && $i === 1) || ((int)$activePageId === $i) ? ' active' : '';
                    echo "<a class='button$buttonClass' href='?page=$i'>$i</a> ";
                }
                echo "</div>";
                ?>
            </div>
        </div>
    </div>
</section>
<?php include_once './../footer.php'; ?>
