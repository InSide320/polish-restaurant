<div class="burger-menu">
    <?php require_once 'burgerMenu.php' ?>
    <a href="/" class="logo"><h1>LOGO</h1></a>

    <?php require_once 'mainMenuElements.php'; ?>

    <div class="header-wrap-img">
        <a href="/my-account">
            <img src="/assets/img/icon-user.png" width="32" height="32" alt="">
        </a>
        <a href="/cart/orders">
            <img src="/assets/img/icon-shopping-bag.png" width="32" height="32" alt="">
            <div class="wrap-header-order-card">
                <?= isset($_SESSION['order']) ? count($_SESSION['order']) : 0 ?>
            </div>
        </a>
    </div>
</div>
