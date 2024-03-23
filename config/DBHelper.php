<?php

require_once 'configuration/conn.php';

use configuration\conn as constantToDB;

class DBHelper
{
    public static function connectToDB()
    {
        $db = mysqli_connect(
            constantToDB\DB_HOST,
            constantToDB\DB_LOGIN,
            constantToDB\DB_PASS,
            constantToDB\DB_NAME
        );
        if (mysqli_connect_errno()) {
            $msg = "Database connection failed: ";
            $msg .= mysqli_connect_error();
            $msg .= " : " . mysqli_connect_errno();
            exit($msg);
        }

        mysqli_query($db, 'set names UTF8MB4') or die ('Invalid query: ' . mysqli_error($db));
        return $db;
    }

    public static function insertUserToDB($generatedUsername, $userEmail, $hashedPassword): void
    {
        $sql = "INSERT INTO users (
                   username, email, password
                   )VALUES (
                            '$generatedUsername', '$userEmail', '$hashedPassword'
                            )";

        mysqli_query(self::connectToDB(), $sql);
    }

    public static function userUpdatePassword($userEmail, $newPassword)
    {
        $sql = "";
        mysqli_query(self::connectToDB(), $sql);
    }

    public static function checkPassword($email, $password): bool
    {
        $stmt = mysqli_query(self::connectToDB(), "select * from users where email='$email'");
        $isVerify = password_verify($password, mysqli_fetch_array($stmt)['password']);

        $stmt->close();
        if ($isVerify) {
            return true;
        }

        return false;
    }

    public static function updateUserChangeKey($email, $change_key): void
    {
        $sql = "UPDATE users set change_key = '$change_key' where email = '$email'";
        mysqli_query(self::connectToDB(), $sql);
    }

    public static function updateUserPassword($user): bool
    {
        $sql = "Update users set password = '$user[password]', change_key = '$user[change_key]' 
             where email = '$user[email]'";
        return (bool)mysqli_query(self::connectToDB(), $sql);
    }


    public static function selectUserByChangeKey($changeKey): false|array|null
    {
        $sql = "select * from users where change_key = '$changeKey'";
        $stmt = mysqli_query(self::connectToDB(), $sql);
        $result = mysqli_fetch_array($stmt);
        $stmt->close();
        return $result;
    }

    public static function usernameExists(array|string|null $username): false|array|null
    {

        // Запит SQL
        $sql = "SELECT username FROM users WHERE username = '$username'";

        // Підготовка запиту
        $stmt = mysqli_query(self::connectToDB(), $sql);


        // Отримання результату
        $row = mysqli_fetch_assoc($stmt);

        // Закриття з'єднання
        $stmt->close();

        return $row;
    }

    public static function userExistsWithEmail($email): false|array|null
    {
        // Запит SQL
        $sql = "SELECT email FROM users WHERE email = '$email'";

        // Підготовка запиту
        $stmt = mysqli_query(self::connectToDB(), $sql);


        $row = mysqli_fetch_assoc($stmt);

        // Закриття з'єднання
        $stmt->close();

        return $row;
    }

    public static function selectAllProducts(): array
    {
        $sql = "select * from products";
        $stmt = mysqli_query(self::connectToDB(), $sql);

        $result = $stmt->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        return $result;
    }

    public static function selectProductById($id): array
    {
        $sql = "select * from products where product_id = '$id'";
        $stmt = mysqli_query(self::connectToDB(), $sql);

        $result = $stmt->fetch_assoc();

        $stmt->close();
        return $result;
    }

    public static function selectAllCategories(): array
    {
        $sql = "select * from categories";
        $stmt = mysqli_query(self::connectToDB(), $sql);

        $result = $stmt->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        return $result;
    }

    public static function selectCategoryById($id): bool|array|null
    {
        $sql = "select * from categories where category_id = '$id'";
        $stmt = mysqli_query(self::connectToDB(), $sql);

        $result = $stmt->fetch_assoc();

        $stmt->close();
        return $result;
    }

    public static function insertProductToDB(
        $productName, $categoryId, $description, $price, $photoContent): bool
    {
        $productName = mysqli_real_escape_string(self::connectToDB(), $productName);
        $description = mysqli_real_escape_string(self::connectToDB(), $description);

        $sql = "INSERT INTO Products (
                      product_name,
                      category_id,
                      description,
                      price,photo)
                VALUES('$productName',
                       $categoryId,
                       '$description',
                       $price,
                       '$photoContent')";

        $result = mysqli_query(self::connectToDB(), $sql);

        return $result !== false;
    }

}
