<?php

require_once 'configuration/conn.php';

use configuration\conn as constantToDB;

class DBHelper
{

    public static function connectToDB()
    {
        // Статичне зберігання з'єднання
        static $connection = null;

        // Перевіряємо, чи вже існує з'єднання
        if ($connection === null) {
            // Встановлюємо з'єднання з базою даних
            $connection = mysqli_connect(
                constantToDB\DB_HOST,
                constantToDB\DB_LOGIN,
                constantToDB\DB_PASS,
                constantToDB\DB_NAME
            );

            // Перевіряємо, чи вдалося підключитися до бази даних
            if (!$connection) {
                $msg = "Database connection failed: ";
                $msg .= mysqli_connect_error();
                $msg .= " : " . mysqli_connect_errno();
                exit($msg);
            }

            // Встановлюємо кодування для з'єднання
            mysqli_query($connection, 'set names UTF8MB4') or die ('Invalid query: ' . mysqli_error($connection));
        }

        // Повертаємо з'єднання
        return $connection;
    }

    private static function executeQuery($sql, $params): array
    {
        // Підготовка запиту
        $stmt = self::connectToDB()->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            return []; // Повертаємо порожній масив у випадку помилки
        }

        // Прив'язка параметрів до плейсхолдерів та їх типів
        if (!empty($params)) {
            $stmt->bind_param(...$params);
        }

        // Виконання запиту
        $stmt->execute();

        // Отримання результату запиту
        $result = $stmt->get_result();

        // Масив для збереження результатів
        $data = [];

        // Отримання всіх рядків з результату запиту та додавання їх до масиву
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Закриття запиту
        $stmt->close();

        return $data;
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

    public static function insertAdditionalInformationByIdToDB($id, $fullName, $phone, $city, $address): bool
    {
        $sql = "UPDATE users
            SET full_name_user = ?, phone = ?, city = ?, address = ?
            WHERE id = ?";

        // Підготовка запиту
        $stmt = self::connectToDB()->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            return false;
        }

        // Прив'язка параметрів до плейсхолдерів та їх типів
        $stmt->bind_param("ssssi", $fullName, $phone, $city, $address, $id);

        // Виконання запиту
        $result = $stmt->execute();

        // Закриття запиту
        $stmt->close();
        return $result;
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

    public static function selectAllProductsPaginated($offset, $limit)
    {
        // Підготовлений SQL запит з плейсхолдерами
        $sql = "SELECT * FROM products LIMIT ?, ?";

        // Підключення до бази даних
        $connection = self::connectToDB();

        // Підготовка запиту
        $stmt = $connection->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            die("Помилка підготовки запиту: " . $connection->error);
        }

        // Прив'язка параметрів до плейсхолдерів та їх типів
        $stmt->bind_param("ii", $offset, $limit);

        // Виконання запиту
        $stmt->execute();

        // Отримання результату запиту
        $result = $stmt->get_result();

        // Масив для зберігання результатів
        $products = array();

        // Отримання рядків з результату запиту
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        // Закриття запиту
        $stmt->close();

        return $products;
    }

    public static function countAllProductsIntoDB()
    {
        // Підготовлений SQL запит
        $sql = "SELECT COUNT(*) as total FROM products";

        // Підключення до бази даних
        $connection = self::connectToDB();

        // Виконання запиту
        $result = $connection->query($sql);

        // Перевірка наявності результату запиту
        if (!$result) {
            die("Помилка виконання запиту: " . $connection->error);
        }

        // Отримання рядка з результату запиту
        $row = $result->fetch_assoc();

        // Закриття результату запиту
        $result->close();

        // Повернення загальної кількості продуктів
        return $row['total'];
    }


    public static function selectProductById($id): array
    {
        $sql = "select * from products where product_id = '$id'";
        $stmt = mysqli_query(self::connectToDB(), $sql);

        $result = $stmt->fetch_assoc();

        $stmt->close();
        return $result;
    }

    public static function updateProductPhotoById($productId, $newPhotoUrl)
    {
        $sql = "UPDATE products SET photo = '$newPhotoUrl' WHERE product_id = $productId";

        // Підключення до бази даних
        $connection = self::connectToDB();

        $stmt = mysqli_query($connection, $sql);

        if ($stmt === false) {
            die("Помилка підготовки запиту: " . $connection->error);
        }

        return $stmt;
    }

    public static function updateProductInfo($description, $methodPreparing, $ingredients, $productId): bool
    {
        // Підготовлений SQL запит з плейсхолдерами
        $sql = "UPDATE products
            SET description = ?, method_preparing = ?, ingredients = ?
            WHERE product_id = ?";

        // Підготовка запиту
        $stmt = self::connectToDB()->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            return false;
        }

        // Прив'язка параметрів до плейсхолдерів та їх типів
        $stmt->bind_param("sssi", $description, $methodPreparing, $ingredients, $productId);

        // Виконання запиту
        $result = $stmt->execute();

        // Закриття запиту
        $stmt->close();

        return $result;
    }

    public static function updateProductFlags($isNew, $isPopular, $productId): bool
    {
        // Підготовлений SQL запит з плейсхолдерами
        $sql = "UPDATE products
            SET is_new = ?, is_popular = ?
            WHERE product_id = ?";

        // Підготовка запиту
        $stmt = self::connectToDB()->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            return false;
        }

        // Прив'язка параметрів до плейсхолдерів та їх типів
        $stmt->bind_param("iii", $isNew, $isPopular, $productId);

        // Виконання запиту
        $result = $stmt->execute();

        // Закриття запиту
        $stmt->close();

        return $result;
    }

    public static function updateProductMainDetails($name, $category, $price, $productId): bool
    {
        // Підготовлений SQL запит з плейсхолдерами
        $sql = "UPDATE products
            SET product_name = ?, category_id = ?, price = ?
            WHERE product_id = ?";

        // Підготовка запиту
        $stmt = self::connectToDB()->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            return false;
        }

        // Прив'язка параметрів до плейсхолдерів та їх типів
        $stmt->bind_param("sidi", $name, $category, $price, $productId);

        // Виконання запиту
        $result = $stmt->execute();

        // Закриття запиту
        $stmt->close();

        return $result;
    }

    public static function deleteProductById($productId)
    {
        // Підготовлений SQL запит з плейсхолдером
        $sql = "DELETE FROM products WHERE product_id = ?";

        // Підключення до бази даних
        $connection = self::connectToDB();

        // Підготовка запиту
        $stmt = $connection->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            die("Помилка підготовки запиту: " . $connection->error);
        }

        // Прив'язка параметра до плейсхолдера та його типу
        $stmt->bind_param("i", $productId);

        // Виконання запиту
        $result = $stmt->execute();

        // Закриття запиту
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

        $sql = "INSERT INTO products (
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

    public static function insertOrderToDB($user, $fullName, $phone, $email, $orderDate, $totalAmount): int
    {
        // Підготовлений SQL запит з плейсхолдерами
        $sql = "INSERT INTO orders (
                    user_id,
                    full_name_user,
                    phone,
                    email,
                    order_date,
                    total_amount
                    ) VALUES (?, ?, ?, ?, ?, ?)";

        // Підготовка запиту
        $stmt = self::connectToDB()->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            return -1; // Повертаємо -1 у випадку помилки
        }

        // Прив'язка параметрів до плейсхолдерів та їх типів
        $stmt->bind_param("issssd", $user, $fullName, $phone, $email, $orderDate, $totalAmount);

        // Виконання запиту
        $stmt->execute();

        // Отримання ідентифікатора нового замовлення
        $orderId = self::connectToDB()->insert_id;

        // Закриття запиту
        $stmt->close();

        return $orderId; // Повертаємо ідентифікатор нового замовлення
    }


    public static function selectOrderById($orderId): bool|array|null
    {
        // Підготовлений SQL запит з плейсхолдером
        $sql = "SELECT * FROM orders WHERE id = ?";

        // Підготовка запиту
        $stmt = self::connectToDB()->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            return false;
        }

        // Прив'язка параметру до плейсхолдера та його типу
        $stmt->bind_param("i", $orderId);

        // Виконання запиту
        $stmt->execute();

        // Отримання результату запиту
        $result = $stmt->get_result();

        // Отримання рядка з результату запиту
        $order = $result->fetch_assoc();

        // Закриття запиту
        $stmt->close();

        return $order;
    }

    public static function selectAllOrderStatuses(): ?array
    {
        // Підготовлений SQL запит
        $sql = "SELECT * FROM orderstatuses";

        // Виконання запиту і отримання результатів
        $result = mysqli_query(self::connectToDB(), $sql);

        // Перевірка наявності результатів
        if (!$result) {
            return null;
        }

        // Масив для зберігання всіх статусів
        $statuses = array();

        // Перебір рядків результату запиту і додавання їх до масиву
        while ($row = mysqli_fetch_assoc($result)) {
            $statuses[] = $row;
        }

        // Звільнення результату запиту
        mysqli_free_result($result);

        return $statuses;
    }

    public static function selectOrderStatusByName($statusName): bool|array|null
    {
        // Підготовлений SQL запит з плейсхолдером
        $sql = "SELECT * FROM orderstatuses WHERE status_name = ?";

        // Підготовка запиту
        $stmt = self::connectToDB()->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            return null;
        }

        // Прив'язка параметра до плейсхолдера та його типу
        $stmt->bind_param("s", $statusName);

        // Виконання запиту
        $stmt->execute();

        // Отримання результату запиту
        $result = $stmt->get_result();

        // Отримання рядка з результату запиту
        $row = $result->fetch_assoc();

        // Закриття запиту
        $stmt->close();

        return $row;
    }

    public static function updateOrderStatus($orderId, $newStatusId): bool
    {
        // Підготовлений SQL запит з плейсхолдерами
        $sql = "UPDATE orders SET order_status_id = ? WHERE id = ?";

        // Підготовка запиту
        $stmt = self::connectToDB()->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            return false;
        }

        // Прив'язка параметрів до плейсхолдерів та їх типів
        $stmt->bind_param("ii", $newStatusId, $orderId);

        // Виконання запиту
        $result = $stmt->execute();

        // Закриття запиту
        $stmt->close();

        return $result;
    }

    public static function insertOrderDetailsToDB($orderId, $productId, $quantity, $price): bool
    {
        // Підготовлений SQL запит з плейсхолдерами
        $sql = "INSERT INTO orderdetails (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";

        // Підготовка запиту
        $stmt = self::connectToDB()->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            return false;
        }

        // Прив'язка параметрів до плейсхолдерів та їх типів
        $stmt->bind_param("iiid", $orderId, $productId, $quantity, $price);

        // Виконання запиту
        $result = $stmt->execute();

        // Закриття запиту
        $stmt->close();

        return $result;
    }

    public static function selectOrdersByUserId($userId): array
    {
        $sql = "SELECT * FROM orders WHERE user_id = ?";
        return self::executeQuery($sql, ["i", $userId]);
    }

    public static function selectAllOrders(): array
    {
        $sql = "SELECT * FROM orders";
        return self::executeQuery($sql, []);
    }

    public static function selectOrderDetailsById($orderId): array
    {
        $sql = "SELECT * FROM orderdetails WHERE order_id = ?";
        return self::executeQuery($sql, ["i", $orderId]);
    }

    public static function selectOrderStatusById($id): bool|array|null
    {
        // Підготовлений SQL запит з плейсхолдером
        $sql = "SELECT * FROM orderstatuses WHERE status_id = ?";

        // Підготовка запиту
        $stmt = self::connectToDB()->prepare($sql);

        // Перевірка наявності помилок у підготовці запиту
        if ($stmt === false) {
            return null;
        }

        // Прив'язка параметра до плейсхолдера та його типу
        $stmt->bind_param("i", $id);

        // Виконання запиту
        $stmt->execute();

        // Отримання результату запиту
        $result = $stmt->get_result();

        // Отримання рядка з результату запиту
        $row = $result->fetch_assoc();

        // Закриття запиту
        $stmt->close();

        return $row;
    }

    /**
     * Отримати пагіновану вибірку замовлень з бази даних.
     *
     * @param int $offset Зміщення (скільки рядків пропустити)
     * @param int $limit Кількість замовлень, які потрібно отримати
     * @return array Замовлення з бази даних
     */
    public static function getAllOrdersPagination(int $offset, int $limit): array
    {
        $db = self::connectToDB();
        $stmt = $db->prepare("SELECT * FROM orders LIMIT ?, ?");
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $orders;
    }

    public static function getTotalOrdersCount()
    {
        $db = self::connectToDB();
        $result = $db->query("SELECT COUNT(*) AS total FROM orders");
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public static function getAllOrdersPaginationByCategoryId(int $offset, int $limit, int $statusIdCategory): array
    {
        $db = self::connectToDB();
        $stmt = $db->prepare("SELECT * FROM orders where order_status_id = ? LIMIT ?, ?");
        $stmt->bind_param("iii", $statusIdCategory, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $orders;
    }

    public static function getTotalOrdersCountByCategoryId($statusIdCategory)
    {
        $db = self::connectToDB();
        $result = $db->query("SELECT COUNT(*) AS total FROM orders where order_status_id = $statusIdCategory;");
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}
