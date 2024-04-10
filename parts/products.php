<?php

function sortByPopularity($products)
{
    usort($products, function ($a, $b) {
        return $b['is_popular'] - $a['is_popular'];
    });
    return $products;
}

function sortByLatest($products)
{
    usort($products, function ($a, $b) {
        return strtotime($b['is_new']) - strtotime($a['is_new']);
    });
    return $products;
}

function sortByPriceLowToHigh($products)
{
    usort($products, function ($a, $b) {
        return $a['price'] - $b['price'];
    });
    return $products;
}

function sortByPriceHighToLow($products)
{
    usort($products, function ($a, $b) {
        return $b['price'] - $a['price'];
    });
    return $products;
}

$products = getAllProducts();

if (isset($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'popularity':
            $products = sortByPopularity($products);
            break;
        case 'latest':
            $products = sortByLatest($products);
            break;
        case 'price-low-to-high':
            $products = sortByPriceLowToHigh($products);
            break;
        case 'price-high-to-low':
            $products = sortByPriceHighToLow($products);
            break;
        default:
    }
}

flash();
?>

<h1 class="name-category"><?= $category !== 0 ? getCategoryById($category)['category_name'] : 'All categories' ?></h1>

<form class="form-filter" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
    <label for="sort">Sort by:</label>
    <select class="input" name="sort" id="sort">
        <option value="">Default Sorting</option>
        <option value="popularity">Popularity</option>
        <option value="latest">Latest</option>
        <option value="price-low-to-high">Price: Low to High</option>
        <option value="price-high-to-low">Price: High to Low</option>
    </select>
    <button type="submit" class="button">Sort</button>
</form>

<ul class="product__items">
    <?php foreach ($products as $product) {
        if ($category === 0 || (int)$product['category_id'] === $category) {
            ?>
            <li class="product__item">
                <a href="/parts/product?id=<?= $product['product_id'] ?>">
                    <img class="product-image" loading="lazy" src="<?= outputPhoto($product['photo']) ?>" width="350"
                         height="350" alt="">
                    <div class="product__description">
                        <div class="productSticker__flag">
                            <div class="productSticker-flag__item">
                                <?= $product['is_new'] ? "New" : ($product['is_popular'] ? "Popular" : "") ?>
                            </div>
                        </div>
                        <p><?= $product['product_name'] ?></p>
                        <p><?= $product['price'] ?> zł</p>
                    </div>
                </a>
            </li>
        <?php }
    } ?>

</ul>
