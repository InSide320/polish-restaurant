<div class="wrap-product-order">
    <form method="post" action="./../app/actions/addProductToOrder">
        <div class="wrap-product-order-price">
            <label for="count">Ilość towaru</label>
            <input id="count" class="count input" type="number" name="count" min="1" value="1">
            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
            <input type="hidden" name="product_name" value="<?= $product['product_name'] ?>">
            <input type="hidden" class="price-product" value="<?= $product['price'] ?>">
            <span class="price"><?= $product['price'] ?>zł</span>
        </div>
        <button class="button" id="add-order" name="send">
            DODAJ DO KOSZYKA
        </button>
    </form>
</div>
