<?php include_once './../header.php'; ?>
<section class="main-section mw-1320">
    <h2>Moje konto</h2>
    <?php
    include_once './../app/actions/handleErrorMessage.php';
    flash(); ?>
    <div class="wrap-my-account">
        <?php include './parts/adminMenuPart.php' ?>
        <div class="wrap-account-information">
            <div class="admin-information">
                <form method="post" action="./../app/actions/addNewProduct" enctype="multipart/form-data">
                    <div>
                        <label for="create-product-name">Name product:</label>
                        <input class="input" type="text" id="create-product-name" name="product-name" required>
                    </div>
                    <div>
                        <label for="create-product-category">Category:</label>
                        <input class="input" type="number" id="create-product-category"
                               name="id_category" min="1" max="5" value="1" required>
                    </div>
                    <div>
                        <label for="create-product-description">Description:</label>
                        <input class="input" type="text" id="create-product-descriptio" name="description" required>
                    </div>
                    <div>
                        <label for="create-product-price">Price:</label>
                        <input class="input" type="number" value="0.00" min="0" id="create-product-price" name="price"
                               step="any" required>
                    </div>

                    <div>
                        <label for="create-product-photo">Photo:</label>
                        <input class="upload-file" type="file" id="create-product-photo" name="photo"
                               accept="image/png, image/jpeg" required>
                    </div>
                    <button class="button" name="send" style="background-color: #333; color: white; width: 150px;"
                            type="submit">Add
                        new product
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php include_once './../footer.php'; ?>
