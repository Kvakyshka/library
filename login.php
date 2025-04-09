<?php 
session_start();
include("db_connect.php");

/** @var mysqli $conn */

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Проверка, был ли отправлен запрос
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];
    
    // Подготовленный запрос для безопасного извлечения пользователя
    $query = "SELECT users.ID, users.password FROM users WHERE users.login = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $login);  // Связываем переменную $login с параметром запроса
    $stmt->execute();
    $result = $stmt->get_result();

    // Если пользователь найден, проверяем пароль
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Проверка пароля
        if (password_verify($password, $user['password'])) {
            // Успешная авторизация
            $_SESSION['ID'] = $user['ID'];
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $login;
            $_SESSION['cart'] = array();
            $_SESSION['count'] = array();
            header('Location: user.php');  // Перенаправляем на страницу личного кабинета
            exit();
        } else {
            // Неверный пароль
            $error_message = "Неверный логин или пароль.";
        }
    } else {
        // Если пользователь не найден
        $error_message = "Неверный логин или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="онлайн библиотека, книги, вход, регистрация" />
    <meta name="description" content="Интернет-библиотека для чтения книг" />
    <link rel="stylesheet" href="index.css" />
    <title>Библиотека - Вход</title>
</head>
<body>

<!-- Шапка сайта -->
<div class="header">
    <div class="left-header">
        <a href="index.php">Главная</a>
        <a href="catalog.php">Каталог книг</a>
        <a href="events.php">События</a>
        <a href="contacts.php">Контакты</a>
    </div>
    <?php if (empty($_SESSION['auth'])): ?>
        <div class="right-header">

            <a href="reg.php">Регистрация</a>
            <a href="login.php">Вход</a>
    <a href="cart.php">Корзина</a>
        </div>
    <?php else: ?>
        <div class="right-header">
            <a href="cart.php">Корзина</a>
            <a href="user.php">Личный кабинет</a>
            <a href="logout.php">Выйти</a>
        </div>
    <?php endif; ?>
</div>

<!-- Форма входа -->
<div class="content">
    <form action="login.php" method="post">
        <h2>Войти в Личный кабинет</h2>
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <label for="login">Логин:</label>
        <input type="text" id="login" name="login" required /><br />

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required /><br />

        <button type="submit" class="catalog-button">Войти</button>
        <a href="reg.php"><p>Или зарегистрируйтесь</p></a>
    </form>
</div>

<!-- Подвал -->
<div class="footer">
    <p>©2025, Библиотека "Книги для всех"</p>
</div>

</body>
</html>
