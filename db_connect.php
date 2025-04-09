<?php
$servername = "localhost"; // Сервер базы данных
$username = "root"; // Имя пользователя администратора
$password = "root"; // Ваш пароль для root (если пустой, оставьте "")
$dbname = "database101"; // Имя вашей базы данных

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
