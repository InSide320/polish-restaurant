<?php

require_once './app/actions/handleErrorMessage.php';
require_once './app/actions/userActions.php';
require_once './config/DBHelper.php';

$data = $_GET;


if ($_SESSION['user_id'] !== null) {
    header('Location: /');
}

if ($data['key'] === null) {
    header('Location: /');
}
$user = DBHelper::selectUserByChangeKey($data["key"]);

if ($user['change_key'] === null){
    header('Location: /');
}

if (isset($data["send"])) {
    if ($user !== null) {
        if ($data['newPassword'] === $data['passwordConfirm']) {
            $user["password"] = hashPassword($data['newPassword']);
            $user["change_key"] = null;
            if(DBHelper::updateUserPassword($user)){
                flash('Your password has been changed');
                header('Location: /my-account');
            } else {
                flash('Something went wrong, please try again the changed password');
            }
        } else {
            flash('Nowe hasło nie jest zgodne ze zduplikowanym hasłem');
        }
    }

}

?>

<section class="main-section mw-1320">
    <h2>Moje konto</h2>
    <?php flash(); ?>
    <div class="wrap-authorization">
        <form class="login-form" method="get">
            <input type="hidden" name="key" value="<?= $data['key'] ?>">

            <label for="new_password">Nowe hasło<span>*</span></label>
            <input type="password" id="new_password" name="newPassword" required minlength="4" autocomplete="on"
                   placeholder="Wpisz nowe hasło">
            <label for="password_confirm">Powtórz nowe hasło <span>*</span></label>
            <input type="password" id="password_confirm" name="passwordConfirm" required minlength="4" autocomplete="on"
                   placeholder="Potwierdź hasło">
            <button class="button" name="send">ZAPISZ</button>
        </form>
    </div>
</section>
