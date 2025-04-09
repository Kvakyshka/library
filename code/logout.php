<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Очистка всех данных сессии
$_SESSION = array();  // Очищаем все сессионные переменные
session_destroy();  // Закрываем сессию
header("Location: index.php");  // Перенаправляем на главную страницу
exit();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="библиотека, выход, онлайн" />
    <meta name="description" content="Выход из личного кабинета" />
    <link rel="stylesheet" href="styles/logout.css" />
    <title>Выход - Библиотека</title>
</head>
<body>
    <!-- Шапка сайта -->
    <div class="header">
        <div class="left-header">
            <a href="index.php">Библиотека "Книги для всех"</a>
            <a href="index.php">Главная</a>
            <a href="catalog.php">Каталог книг</a>
        </div>
        <div class="right-header">
            <a href="reg.php">Регистрация</a>
            <a href="login.php">Вход</a>
        </div>
    </div>

    <!-- Контент -->
    <div class="content">
        <h2>Выход</h2>
        <p>Вы успешно вышли из своей учетной записи.</p>
        <a href="index.php"><button class="catalog-button">Вернуться на главную</button></a>
    </div>

    <!-- Подвал -->
    <div class="footer">
        <p>©2025, Библиотека "Книги для всех"</p>
    </div>
</body>
</html>
