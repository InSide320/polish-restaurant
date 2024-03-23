<?php include_once './../header.php'; ?>
<section class="main-section mw-1320">
    <h2>Moje konto</h2>
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
                        <input class="input" type="number" id="create-product-category" name="id_category" required>
                    </div>
                    <div>
                        <label for="create-product-description">Description:</label>
                        <input class="input" type="text" id="create-product-description" name="description">
                    </div>
                    <div>
                        <label for="create-product-price">Price:</label>
                        <input class="input" type="number" id="create-product-price" name="price" step="any">
                    </div>

                    <div>
                        <label for="create-product-photo">Photo:</label>
                        <input class="upload-file" type="file" id="create-product-photo" name="photo"
                               accept="image/png, image/jpeg">
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
