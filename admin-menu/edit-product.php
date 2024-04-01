<?php include_once './../header.php'; ?>
<section class="main-section mw-1320">
    <h2>Moje konto</h2>
    <div class="wrap-my-account">
        <?php
        include_once 'parts/adminMenuPart.php';
        include_once './../app/actions/productAction.php';
        include_once './../app/actions/handleErrorMessage.php';
        include_once './../config/DBHelper.php';
        ?>
        <div class="wrap-account-information">
            <div class="account-information">
                <?php
                $data = $_GET;
                if (isset($data['send'])) :
                    flash();
                    $product = getProductById($data['product-id']);
                    ?>
                    <form method="post" action="./../app/actions/removeProduct.php">
                        <input type="hidden" name="product-id" value="<?= $product['product_id'] ?>">
                        <button class="button" name="send" type="submit">Remove product</button>
                    </form>
                    <form method="post" class="product-change-main-info"
                          action="./../app/actions/editMainInfoProduct.php">
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
                            <tr>
                                <td>
                                    <input type="hidden" name="product-id" value="<?= $product['product_id'] ?>">
                                    <?= $product['product_id'] ?>
                                </td>
                                <td class="product-table-photo">
                                    <img src="<?= outputPhoto($product['photo']) ?>" width="50" height="50"
                                         alt="product">
                                </td>

                                <td>
                                    <div class="wrap-changed-field">
                                        <label for="change-name">Change name:</label>
                                        <input class="input" id="change-name"
                                               type="text"
                                               name="product-name"
                                               value="<?= $product['product_name'] ?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="wrap-changed-field">
                                        <label for="category_name">Change category: </label>
                                        <?php
                                        $allCategories = getAllCategories();
                                        $categoryProduct = getCategoryById($product['category_id'])['category_name']; ?>
                                        <select name="category-name"
                                                id="category_name" class="input">
                                            <?php foreach ($allCategories as $item): ?>
                                                <option name="category-name" value="<?= $item['category_name'] ?>"
                                                    <?= $item['category_name'] === $categoryProduct ? 'selected' : '' ?>>
                                                    <?= $item['category_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </td>
                                <td class="product-table-price">
                                    <label>
                                        <input class="input" type="number" name="price"
                                               value="<?= $product['price'] ?>">
                                    </label>
                                </td>
                                <td>
                                    <button class="button" name="send" type="submit">Save</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>

                    <form class="change-product-flag form-change-product" method="post"
                          action="./../app/actions/changeProductFlag.php">
                        <?php $productFlag =
                            $product['is_new'] ? "New" : ($product['is_popular'] ? "Popular" : "None") ?>
                        <input type="hidden" name="product-id" value="<?= $product['product_id'] ?>">
                        <fieldset>
                            <legend>Select what product flag:</legend>

                            <div class="wrap-radio-product-flag">
                                <input type="radio" id="none" name="flag"
                                       value="none" <?= $productFlag === 'None' ? 'checked' : '' ?>/>
                                <label for="none">None</label>
                            </div>

                            <div class="wrap-radio-product-flag">
                                <input type="radio" id="new" name="flag" value="new"
                                    <?= $productFlag === 'New' ? 'checked' : '' ?> />
                                <label for="new">New</label>
                            </div>

                            <div class="wrap-radio-product-flag">
                                <input type="radio" id="popular" name="flag"
                                       value="popular" <?= $productFlag === 'Popular' ? 'checked' : '' ?>/>
                                <label for="popular">Popular</label>
                            </div>
                        </fieldset>

                        <button type="submit" class="button" name="send">Change flag</button>
                    </form>

                    <form method="post" class="change-photo form-change-product"
                          action="./../app/actions/editPhotoProduct"
                          enctype="multipart/form-data">
                        <input type="hidden" name="product-id" value="<?= $product['product_id'] ?>">
                        <label for="create-product-photo">Photo:</label>
                        <input class="upload-file" type="file" id="create-product-photo" name="photo"
                               accept="image/png, image/jpeg" required>
                        <button class="button" name="send" type="submit">Set new photo</button>
                    </form>
                    <form method="post" class="change-additional-info form-change-product"
                          action="./../app/actions/changeProductAdditionalInfo.php">
                        <input type="hidden" name="product-id" value="<?= $product['product_id'] ?>">

                        <label for="description">Set description:</label>
                        <textarea id="description" name="description">
                            <?= htmlspecialchars($product['description']) ?>
                        </textarea>
                        <label for="method_preparing">Set method preparing:</label>
                        <textarea id="method_preparing" name="method-preparing">
                            <?= htmlspecialchars($product['method_preparing']) ?>
                        </textarea>
                        <label for="ingredients">Set ingredients:</label>
                        <textarea id="ingredients" name="ingredients">
                            <?= htmlspecialchars($product['ingredients']) ?>
                        </textarea>
                        <button class="button" name="send" type="submit">Change additional info</button>

                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<script>
    const ingredientsTextarea = document.getElementById('ingredients');

    ingredientsTextarea.addEventListener('keydown', (event) => {
        if (event.key === ' ') {
            const currentPosition = ingredientsTextarea.selectionStart;
            const currentValue = ingredientsTextarea.value;
            const newValue = `${currentValue.slice(0, currentPosition)},${currentValue.slice(currentPosition)}`;

            ingredientsTextarea.value = newValue;
            event.preventDefault();
            ingredientsTextarea.setSelectionRange(currentPosition + 1, currentPosition + 1);
        }
    });

</script>
<?php include_once './../footer.php'; ?>

