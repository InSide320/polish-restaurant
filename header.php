<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant</title>
    <link rel="stylesheet" href="/assets/style/style.css"/>
</head>
<body>
<div class="root">
<header class="mw-1320">
    <div class="wrap-header">
        <nav>
            <div class="burger-menu">
                <input id="menu-toggle" type="checkbox"/>
                <label class='menu-button-container' for="menu-toggle">
                    <span class='menu-button'></span>
                </label>
                <a href="/"><h1>LOGO</h1></a>
                <?php require_once 'parts/main-menu.php'; ?>
                <div class="header-wrap-img">
                    <a href="/my-account.php">
                        <img src="/assets/img/icon-user.png" width="32" height="32" alt="">
                    </a>
                    <a href="#">
                        <img src="/assets/img/icon-shopping-bag.png" width="32" height="32" alt="">
                    </a>
                </div>
            </div>
        </nav>
    </div>
</header>
