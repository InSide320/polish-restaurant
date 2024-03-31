<?php
$data = $_POST;
if (isset($data['send'])) {
    include_once 'userActions.php';
    include_once 'handleErrorMessage.php';
    include_once './../../config/DBHelper.php';

    setAdditionalInfUserById(
        $_SESSION['user_id'],
        $data['full-name'],
        $data['phone'],
        $data['city'],
        $data['address']
    ) ? flash("Additional information about your profile has been added") : flash('Something was wrong!');
    header("Location: /user-menu/add-personal-data");
}
