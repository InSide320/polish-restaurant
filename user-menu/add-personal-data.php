<?php include_once './../header.php'; ?>
<section class="main-section mw-1320" xmlns="http://www.w3.org/1999/html">
    <h2>Moje konto</h2>
    <div class="wrap-my-account">
        <?php $username = $_SESSION["username"]; ?>
        <?php include_once 'parts/userMenuPart.php';
        include_once './../app/actions/orderAction.php';
        include_once './../app/actions/handleErrorMessage.php';
        include_once './../config/DBHelper.php';
        ?>
        <div class="wrap-account-information">
            <div class="account-information">
                <?php flash(); ?>
                <h1>Add personal information:</h1>
                <form method="post" action="../app/actions/addAdditionalInfUser.php">
                    <div class="wrap-personal-information">
                        <span id="email">
                            Your email: <?= $_SESSION['email'] ?? '' ?>
                        </span>
                    </div>


                    <div class="wrap-personal-information">
                        <label for="full-name">Full name:<span style="color: #E01020;">*</span></label>
                        <input id="full-name"
                               class="input"
                               type="text"
                               value="<?= $_SESSION['fullName'] ?? '' ?>" name="full-name">
                    </div>

                    <div class="wrap-personal-information">
                        <label for="phone">Phone:<span style="color: #E01020;">*</span></label>
                        <input id="phone" name="phone" class="input"
                               type="tel"
                               maxlength="13"
                               value="<?= $_SESSION['phone'] ?? '' ?>"
                               required>
                    </div>
                    <div class="wrap-personal-information">
                        <label for="city">City:<span style="color: #E01020;">*</span></label>
                        <input id="city" name="city" class="input"
                               type="text"
                               value="<?= $_SESSION['address'] ?? '' ?>"
                               required>
                    </div>
                    <div class="wrap-personal-information">
                        <label for="address">Address:<span style="color: #E01020;">*</span></label>
                        <input id="address" name="address" class="input"
                               type="text"
                               value="<?= $_SESSION['address'] ?? '' ?>"
                               required>
                    </div>
                    <div class="wrap-personal-information">
                        <button type="submit" class="button" style="width: 100px;" name="send">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php include_once './../footer.php'; ?>
