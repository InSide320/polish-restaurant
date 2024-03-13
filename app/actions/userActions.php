<?php

use Random\RandomException;

function checkAuth(): bool
{
    return (bool)($_SESSION['user_id'] ?? false);
}

/**
 * @throws RandomException
 */
function generatePassword($length = 12): string
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $password;
}

function hashPassword($password): string
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function generateUsernameFromEmail($email): array|string|null
{

    require_once './../../config/DBHelper.php';

    // Selection of the local part
    $username = explode('@', $email)[0];

    // Replacing dots with dashes
    $username = str_replace('.', '-', $username);

    // Removing special characters
    $username = preg_replace('/[^a-zA-Z0-9-_]/', '', $username);

    if (strlen($username) > 16) {
        $username = substr($username, 0, 16);
    }

    // Adding a suffix if username already exists
    $i = 1;
    while (DBHelper::usernameExists($username)) {
        $username .= $i++;
    }

    return $username;
}

function saveUserToDB($username, $email, $password): void
{
    $hash_pass = hashPassword($password);
    DBHelper::insertUserToDB($username, $email, $hash_pass);
}

