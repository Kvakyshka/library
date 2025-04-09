<?php
session_start();
include("db_connect.php");

// Обработка добавления книги в корзину
if (isset($_POST['add_to_cart'])) {
    $book_id = $_POST['book_id'];
    
    // Проверяем, существует ли корзина в сессии, если нет — создаем
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    if (!isset($_SESSION['count'])) {
        $_SESSION['count'] = array();
    }

    // Добавляем книгу в корзину (если она еще не добавлена)
    if (!in_array($book_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $book_id;
        $_SESSION['count'][$book_id] = 1; // Начальное количество книги
    } else {
        // Если книга уже есть, увеличиваем количество
        $_SESSION['count'][$book_id]++;
    }

    // Перенаправляем на страницу корзины или каталог
    header('Location: cart.php');
    exit();
}

if (!isset($_GET['ID']) || empty($_GET['ID'])) {
    die("Книга не найдена.");
}

$book_id = $_GET['ID'];

// Получаем подробную информацию о книге
$sql_book = "SELECT k.`Код книги`, k.`Название`, k.`Цена`, DATE_FORMAT(k.`Год`, '%d-%m-%Y') AS `Год`, a.`Имя`, a.`Фамилия`, j.`Название жанра`
             FROM `Книга` k
             LEFT JOIN `Автор-книга` ak ON k.`Код книги` = ak.`Код Книга`
             LEFT JOIN `Автор` a ON ak.`Код Автор` = a.`Код автор`
             LEFT JOIN `Жанр-Книга` jk ON k.`Код книги` = jk.`Код Книги`
             LEFT JOIN `Жанр` j ON jk.`Код жанра` = j.`Код жанра`
             WHERE k.`Код книги` = '$book_id'";


$book_result = $conn->query($sql_book);
if ($book_result && $book_result->num_rows > 0) {
    $book = $book_result->fetch_assoc();
} else {
    die("Книга не найдена.");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подробности о книге</title>
    <link rel="stylesheet" href="catalog.css">
</head>
<body>

<!-- Шапка сайта -->
<div class="header">
    <div class="left-header">
        <a href="index.php">Библиотека "Книги для всех"</a>
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

<!-- Подробности о книге -->
<div class="book-details">
    <h1><?php echo $book['Название']; ?></h1>
    <p><strong>Автор:</strong> <?php echo $book['Имя'] . ' ' . $book['Фамилия']; ?></p>
    <p><strong>Жанр:</strong> <?php echo $book['Название жанра']; ?></p>
    <p><strong>Год издания:</strong> <?php echo $book['Год']; ?></p>
    <p><strong>Цена:</strong> <?php echo $book['Цена']; ?> руб.</p>
    <img src="<?php echo $book['Код книги']; ?>.jpg" alt="Обложка книги">
    
    <!-- Форма для добавления книги в корзину -->
    <form action="details.php?ID=<?php echo $book['Код книги']; ?>" method="post">
        <input type="hidden" name="book_id" value="<?php echo $book['Код книги']; ?>">
        <input type="submit" name="add_to_cart" value="Добавить в корзину">
    </form>

    <form action="catalog.php" method="get">
        <button type="submit">Закрыть</button>
    </form>
</div>

<!-- Подвал -->
<div class="footer">
    <p>©2023, Библиотека "Книги для всех"</p>
</div>

</body>
</html>

<?php
$conn->close();
?>
