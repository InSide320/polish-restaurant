<?php include 'header.php';
require_once 'app/actions/handleErrorMessage.php';
require_once 'app/actions/userActions.php';

if (checkAuth()) {
    include './user-menu/my-account.php';
} else {
    include "parts/login.php";
}


include 'footer.php';
