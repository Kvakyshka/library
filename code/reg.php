<?php 
session_start();
include("db_connect.php");
/** @var mysqli $conn */

$reg_day = date('Y-m-d', time());
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из формы
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $password = $_POST['password'];

    // Проверка, существует ли уже пользователь с таким логином или email
    $query = "SELECT * FROM users WHERE login = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $login, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Если пользователь найден, выводим сообщение об ошибке
        $error_message = "Пользователь с таким логином или email уже существует.";
    } else {
        // Хэшируем пароль перед сохранением в базу данных
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Вставляем нового пользователя в базу данных
        $insert_query = "INSERT INTO users (name, surname, reg_day, number, email, login, password) 
                         VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($insert_query);
        $stmt_insert->bind_param('sssssss', $name, $surname, $reg_day, $number, $email, $login, $hashed_password);

        if ($stmt_insert->execute()) {
            // Успешная регистрация
            $_SESSION['auth'] = true;
            $_SESSION['ID'] = $conn->insert_id;  // Установите ID нового пользователя в сессию
            $_SESSION['login'] = $login;
            $_SESSION['cart'] = array();
            $_SESSION['count'] = array();
            header('Location: user.php');
            exit();
        } else {
            // Ошибка при вставке данных
            $error_message = "Ошибка регистрации, попробуйте позже.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="библиотека, регистрация, книги" />
    <meta name="description" content="Регистрация пользователя в интернет-библиотеке" />
    <link rel="stylesheet" href="index.css" />
    <title>Библиотека - Регистрация</title>
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

<!-- Форма регистрации -->
<div class="content">
    <form action="reg.php" method="post">
        <h2>Зарегистрироваться</h2>

        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" required /><br />

        <label for="surname">Фамилия:</label>
        <input type="text" id="surname" name="surname" required /><br />

        <label for="login">Логин:</label>
        <input type="text" id="login" name="login" required /><br />

        <label for="email">Почта:</label>
        <input type="email" id="email" name="email" required /><br />

        <label for="number">Номер:</label>
        <input type="tel" id="number" name="number" pattern="+7([0-9]{3})[0-9]{3}-[0-9]{2}-[0-9]{2}" required /><br />

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required /><br />

        <button type="submit" class="catalog-button">Зарегистрироваться</button>
        <a href="login.php"><p>Или войти</p></a>
    </form>
</div>

<!-- Подвал -->
<div class="footer">
    <p>©2025, Библиотека "Книги для всех"</p>
</div>

</body>
</html>
