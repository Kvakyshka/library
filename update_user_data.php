<?php
session_start();
include("db_connect.php");

if (empty($_SESSION['auth'])) {
    echo "Ошибка: не авторизован.";
    exit();
}

$user_id = $_SESSION['ID'];
$field = $_POST['field_name'];
$value = $_POST['new_value'];

// Защита от SQL инъекций
$field = mysqli_real_escape_string($conn, $field);
$value = mysqli_real_escape_string($conn, $value);

// Если меняется пароль, захешируем его
if ($field == 'password' && !empty($value)) {
    $value = password_hash($value, PASSWORD_BCRYPT);
}

$update_query = "UPDATE users SET $field = ? WHERE ID = ?";
$stmt = $conn->prepare($update_query);
$stmt->bind_param('si', $value, $user_id);

if ($stmt->execute()) {
    echo "Данные успешно обновлены.";
} else {
    echo "Ошибка при обновлении данных: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
