<?php
session_start();
include("db_connect.php");

// Проверка, что книга добавляется
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Если корзина еще не существует в сессии, создаем её
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
        $_SESSION['count'] = [];
    }

    // Добавляем книгу в корзину, если она еще не добавлена
    if (!in_array($book_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $book_id;
        $_SESSION['count'][$book_id] = 1;  // Устанавливаем количество по умолчанию 1
    }

    // Перенаправление на страницу корзины
    header('Location: cart.php');
    exit();
}
?>
