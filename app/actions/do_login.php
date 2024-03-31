<?php
require_once './../../config/DBHelper.php';
require_once 'handleErrorMessage.php';


if ($_POST['email'] !== '') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $isExistUser = mysqli_query(DBHelper::connectToDB(), "SELECT * FROM users WHERE email = '$email'");
    $fetchArrayQuery = mysqli_fetch_array($isExistUser);
    if (!is_null($fetchArrayQuery)) {
        if (DBHelper::checkPassword($email, $password)) {
            $_SESSION['user_id'] = $fetchArrayQuery['id'];
            $_SESSION['username'] = $fetchArrayQuery['username'];
            $_SESSION['email'] = $fetchArrayQuery['email'];
            $_SESSION['role'] = $fetchArrayQuery['role'];
            header('Location: /my-account');
        } else {
            flash('Niepoprawny Hasło');
        }
    } else {

        flash('Niepoprawny adres email');
    }
} else {
    flash('Pleas input your email and password');
}
include './../../my-account.php';
