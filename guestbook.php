<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $user_id = $_SESSION['user_id'] ?? null;

    $query = "INSERT INTO guestbook (user_id, message) VALUES ('$user_id', '$message')";
    if ($conn->query($query)) {
        echo "Сообщение добавлено!";
    } else {
        echo "Ошибка: " . $conn->error;
    }
}

$query = "SELECT * FROM guestbook ORDER BY created_at DESC";
$result = $conn->query($query);

echo "<h1>Гостевая книга</h1>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Сообщение: " . $row['message'] . "<br>";
    }
} else {
    echo "Нет сообщений.";
}
?>

<form method="POST">
    <textarea name="message" required></textarea><br>
    <input type="submit" value="Отправить сообщение">
</form>
