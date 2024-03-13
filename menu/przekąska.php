<?php
require './../header.php'; ?>

<section class="main-section mw-1320">
    <div class="menu-wrap-product">
        <?php
        require_once './../app/actions/productAction.php';
        require_once './../config/DBHelper.php';

        $category = 1;

        require_once './../parts/products.php' ?>
    </div>
</section>

<?php require './../footer.php'; ?>


