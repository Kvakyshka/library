<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM orders WHERE user_id='$user_id'";
$result = $conn->query($query);

echo "<h1>Ваши заказы</h1>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Заказ: " . $row['product_name'] . "<br>";
        echo "Статус: " . $row['status'] . "<br>";
    }
} else {
    echo "У вас нет заказов.";
}
?>
