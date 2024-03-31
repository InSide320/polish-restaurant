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
                                           value="<?= $product['product_name'] ?>">
                                </div>
                            </td>
                            <td>
                                <div class="wrap-changed-field">
                                    <label for="category_name">Change category: </label>
                                    <?php
                                    $allCategories = getAllCategories();
                                    $categoryProduct = getCategoryById($product['category_id'])['category_name']; ?>
                                    <select name="category_name"
                                            id="category_name" class="input">
                                        <?php foreach ($allCategories as $item): ?>
                                            <option name="category_name" value="<?= $item['category_name'] ?>"
                                                <?= $item['category_name'] === $categoryProduct ? 'selected' : '' ?>>
                                                <?= $item['category_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td class="product-table-price">
                                <label>
                                    <input class="input" type="number" value="<?= $product['price'] ?>">
                                </label>
                            </td>
                            <td>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <form method="post" class="change-photo" action="./../app/actions/editPhotoProduct"
                          enctype="multipart/form-data">
                        <input type="hidden" name="product-id" value="<?= $product['product_id'] ?>">
                        <label for="create-product-photo">Photo:</label>
                        <input class="upload-file" type="file" id="create-product-photo" name="photo"
                               accept="image/png, image/jpeg" required>
                        <button class="button" name="send" type="submit">Set new photo</button>
                    </form>
                    <form>

                        <label for="description">Set description</label>
                        <textarea class="input" id="description" name="description">
                            <?= $product['description'] ?>
                        </textarea>
                        <label for="method_preparing">Set method preparing</label>
                        <textarea class="input" id="method_preparing" name="method_preparing">
                            <?= $product['method_preparing'] ?>
                        </textarea>
                        <label for="ingredients">Set ingredients</label>
                        <textarea class="input" id="ingredients" name="ingredients">
                            <?= $product['ingredients'] ?>
                        </textarea>

                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php include_once './../footer.php'; ?>

