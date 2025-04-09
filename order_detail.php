<?php
session_start();
include("db_connect.php");
/** @var mysqli $conn */

if (!isset($_GET['ID']) || empty($_GET['ID'])) {
    die("Ошибка: заказ не найден.");
}

// Получаем ID заказа из URL
$order_id = $_GET['ID'];

// Запрос для получения подробной информации о заказе, включая цену книги
$order_query = "SELECT o.ID, o.date, o.address, k.Название AS book_name, c.count, k.Цена AS book_price
                FROM orders o
                JOIN orders_books c ON o.ID = c.order_id
                JOIN Книга k ON c.book_id = k.`Код книги`
                WHERE o.ID = ?";
$stmt = $conn->prepare($order_query);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$order_details = $stmt->get_result();

// Проверка наличия заказа
if ($order_details->num_rows == 0) {
    die("Ошибка: заказ не найден.");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="библиотека, заказ, детали" />
    <meta name="description" content="Детали заказа" />
    <link rel="stylesheet" href="user.css" />
    <title>Подробности о заказе - Библиотека</title>
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
            <a href="cart.php">Корзина</a>
            <a href="user.php">Личный кабинет</a>
            <a href="logout.php">Выйти</a>
        </div>
    </div>

    <!-- Контент страницы -->
    <div class="content">
        <h1>Детали заказа</h1>

        <?php
        $total_price = 0;  // Переменная для общей стоимости заказа

        // Массив для хранения данных о заказе
        $order_info = $order_details->fetch_assoc();
        
        // Форматируем дату заказа
        $order_date = date('d-m-Y', strtotime($order_info['date']));

        // Добавляем 3 дня к дате заказа для расчета даты доставки
        $delivery_date = date('d-m-Y', strtotime($order_info['date'] . ' + 3 days'));

        // Получаем текущую дату
        $current_date = date('d-m-Y');  // Текущая дата в формате Y-m-d

        // Статус заказа
        if ($current_date < $delivery_date) {
            $status = "В пути";
        } else {
            $status = "Получен";
        }

        // Выводим информацию о заказе (только один раз)
        echo "<p><strong>Дата заказа:</strong> " . $order_date . "</p>";
        echo "<p><strong>Доставим:</strong> " . $delivery_date . "</p>";  // Дата доставки
        echo "<p><strong>Статус заказа:</strong> " . $status . "</p>";  // Статус заказа
        echo "<p><strong>Адрес доставки:</strong> " . $order_info['address'] . "</p>";

        echo "<h2>Книги в заказе:</h2>";
        echo "<table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Название книги</th>
                        <th>Количество</th>
                        <th>Цена</th>
                        <th>Общая стоимость</th>
                    </tr>
                </thead>
                <tbody>";

        // Переменная для отслеживания порядкового номера книги
        $book_number = 1;

        // Перебираем все книги в заказе
        do {
            // Для каждого заказа выводим информацию о книге
            $book_price = $order_info['book_price'];
            $book_count = $order_info['count'];
            $total_book_price = $book_price * $book_count;  // Общая стоимость книги

            $total_price += $total_book_price;  // Добавляем цену книги в общую сумму

            // Выводим строку с номером книги
            echo "<tr>
                    <td>" . $book_number . "</td> <!-- Порядковый номер книги -->
                    <td>" . $order_info['book_name'] . "</td>
                    <td>" . $book_count . "</td>
                    <td>" . $book_price . " руб.</td>
                    <td>" . $total_book_price . " руб.</td>
                  </tr>";

            // Увеличиваем номер книги
            $book_number++;

        } while ($order_info = $order_details->fetch_assoc());

        echo "</tbody></table>";

        // Выводим общую сумму заказа
        echo "<h3>Общая стоимость заказа: " . $total_price . " руб.</h3>";
        ?>

        <form action="user.php" method="get">
            <button type="submit">Назад</button>
        </form>

    </div>

    <!-- Подвал -->
    <div class="footer">
        <p>©2025, Библиотека "Книги для всех"</p>
    </div>
</body>
</html>

<?php
$conn->close();
?>
