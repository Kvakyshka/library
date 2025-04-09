<?php
session_start();
include("db_connect.php");

// Если корзина пуста
if (empty($_SESSION['cart'])) {
    echo "<!DOCTYPE html>";
    echo "<html lang='ru'>";
    echo "<head>";
    echo "<meta charset='UTF-8' />";
    echo "<meta http-equiv='X-UA-Compatible' content='IE=edge' />";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0' />";
    echo "<link rel='stylesheet' href='index.css' />";
    echo "<title>Корзина пуста</title>";
    echo "</head>";
    echo "<body>";

    // Шапка сайта
    echo "<div class='header'>
            <div class='left-header'>
                <a href='index.php'>Главная</a>
                <a href='catalog.php'>Каталог книг</a>
                <a href='events.php'>События</a>
                <a href='contacts.php'>Контакты</a>
            </div>";
    if (empty($_SESSION['auth'])) {
        echo "<div class='right-header'>
                <a href='reg.php'>Регистрация</a>
                <a href='login.php'>Вход</a>
              </div>";
    } else {
        echo "<div class='right-header'>
                <a href='cart.php'>Корзина</a>
                <a href='user.php'>Личный кабинет</a>
                <a href='logout.php'>Выйти</a>
              </div>";
    }
    echo "</div>";

    // Контент страницы
    echo "<div class='content'>
            <div class='empty-cart-message'>Ваша корзина пуста! <a href='catalog.php' class='catalog-button'>Добавить книгу</a></div>
          </div>";

    // Подвал
    echo "<div class='footer'>
            <p>©2023, Библиотека \"Книги для всех\"</p>
          </div>";

    echo "</body>";
    echo "</html>";

    exit();
}

// Инициализация массива $_SESSION['count'] если он не существует
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = array();
}

// Обработка удаления книги из корзины
if (isset($_POST['delete'])) {
    $book_id_to_delete = (int) $_POST['delete'];  // ID книги для удаления

    // Удаляем книгу из корзины
    $key = array_search($book_id_to_delete, $_SESSION['cart']);
    if ($key !== false) {
        unset($_SESSION['cart'][$key]);
        unset($_SESSION['count'][$book_id_to_delete]);  // Удаляем количество книги из массива
    }

    // Перенаправляем на страницу корзины после удаления
    header('Location: cart.php');
    exit();
}

// Преобразуем все элементы массива в целые числа
$book_ids = array_map('intval', $_SESSION['cart']);
if (count($book_ids) > 0) {
    $book_ids_imploded = implode(',', $book_ids);
    $query = "SELECT * FROM `Книга` WHERE `Код книги` IN ($book_ids_imploded)";
    $info = $conn->query($query);
} else {
    // Если корзина пуста, выводим сообщение или делаем перенаправление
    echo "Корзина пуста";
    exit();
}

$reg_day = date('Y-m-d', time());
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="библиотека, книги, корзина" />
    <meta name="description" content="Корзина книг - интернет-библиотека" />
    <link rel="stylesheet" href="user.css" /> <!-- Подключаем cart.css -->
    <title>Библиотека - Корзина</title>
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
        </div>
    <?php else: ?>
        <div class="right-header">
            <a href="cart.php">Корзина</a>
            <a href="user.php">Личный кабинет</a>
            <a href="logout.php">Выйти</a>
        </div>
    <?php endif; ?>
</div>

<!-- Контент корзины -->
<div class="content">
    <h1>Ваша корзина</h1>
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Название книги</th>
            <th>Количество</th>
            <th>Цена</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total_price = 0;  // Переменная для общей суммы
        $counter = 1;  // Порядковый номер книги в корзине

        if ($info->num_rows > 0) {
            while ($raw = $info->fetch_assoc()) {
                $book_id = $raw['Код книги'];
                $book_name = $raw['Название'];
                $book_price = $raw['Цена'];

                // Если в $_SESSION['count'] нет данных для этой книги, присваиваем количество 1
                if (!isset($_SESSION['count'][$book_id])) {
                    $_SESSION['count'][$book_id] = 1;  // Начальное количество книги
                }
                
                $book_count = $_SESSION['count'][$book_id]; // Количество книг в корзине

                // Считаем общую сумму заказа
                $total_price += $book_price * $book_count;

                echo "<tr>
                        <td>$counter</td>  <!-- Порядковый номер книги -->
                        <td>$book_name</td>
                        <td>$book_count</td>
                        <td>$book_price руб.</td>
                        <td>
                            <form action='cart.php' method='post'>
                                <button type='submit' name='delete' value='$book_id' class='delete'>Удалить</button>
                            </form>
                        </td>
                    </tr>";

                $counter++;  // Увеличиваем счетчик для следующей книги
            }
        } else {
            echo "<tr><td colspan='5'>Корзина пуста</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Общая сумма заказа -->
    <h3>Общая сумма: <?php echo $total_price; ?> руб.</h3>

    <!-- Форма для оформления заказа -->
    <form action="cart.php" method="post">
        <h2>Оформить заказ</h2>
        <label for="address">Адрес:</label>
        <input type="text" id="address" name="address" required /><br />

        <button type="submit" class="order">Оформить заказ</button>
    </form>

    <?php
    // Обработка оформления заказа
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['address'])) {
        // Данные текущего пользователя
        $data = mysqli_fetch_assoc($conn->query("SELECT * FROM users WHERE login = '$_SESSION[login]'"));

        // Вставляем новый заказ в таблицу orders
        $address = $_POST['address'];
        if ($conn->query("INSERT INTO orders (address, date, user_id) 
                          VALUES ('$address', '$reg_day', '$data[ID]')")) {

            // Получаем ID последнего заказа
            $order_id = mysqli_fetch_assoc($conn->query("SELECT ID FROM orders ORDER BY ID DESC LIMIT 1"))['ID'];

            // Добавляем книги в таблицу orders_books
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $book_id) {
                    // Если книга есть в корзине
                    if (isset($_SESSION['count'][$book_id])) {
                        $book_count = $_SESSION['count'][$book_id];
                        $conn->query("INSERT INTO orders_books (`order_id`, `book_id`, `count`) 
                                      VALUES ($order_id, $book_id, $book_count)");
                    }
                }
            } else {
                echo "Корзина пуста, невозможно оформить заказ.";
                exit();
            }

            // Очищаем корзину после оформления
            $_SESSION['cart'] = array();
            $_SESSION['count'] = array();

            // Перенаправляем на страницу пользователя
            header('Location: user.php');
            exit();
        } else {
            echo "<p>Ошибка оформления заказа, попробуйте снова.</p>";
        }
    }
    ?>
</div>

<!-- Подвал -->
<div class="footer">
    <p>©2023, Библиотека "Книги для всех"</p>
</div>

</body>
</html>
