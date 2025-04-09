<?php
session_start();
include("db_connect.php");

// Получаем список авторов для фильтрации
$sql_authors = "SELECT DISTINCT a.`Имя`, a.`Фамилия` 
                FROM `Автор` a 
                JOIN `Автор-книга` ak ON a.`Код автор` = ak.`Код Автор`";
$authors_result = $conn->query($sql_authors);

// Получаем список жанров для фильтрации
$sql_genres = "SELECT DISTINCT j.`Название жанра` 
               FROM `Жанр` j 
               JOIN `Жанр-Книга` jk ON j.`Код жанра` = jk.`Код Жанра`";
$genres_result = $conn->query($sql_genres);

// Обрабатываем фильтры из формы
$author_filter = isset($_GET['author']) ? $_GET['author'] : '';
$genre_filter = isset($_GET['genre']) ? $_GET['genre'] : '';
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Запрос для получения всех книг с учетом фильтров
$sql_books = "SELECT k.`Код книги`, k.`Название`, k.`Цена`, k.`Год`, a.`Имя`, a.`Фамилия`
              FROM `Книга` k
              LEFT JOIN `Автор-книга` ak ON k.`Код книги` = ak.`Код Книга`
              LEFT JOIN `Автор` a ON ak.`Код Автор` = a.`Код автор`";

// Применяем фильтр по автору
if ($author_filter) {
    $sql_books .= " WHERE CONCAT(a.`Имя`, ' ', a.`Фамилия`) LIKE '%$author_filter%'";
}

// Применяем фильтр по жанру
if ($genre_filter) {
    if ($author_filter) {
        $sql_books .= " AND k.`Код книги` IN (SELECT jk.`Код Книги` FROM `Жанр-Книга` jk 
                                               JOIN `Жанр` j ON jk.`Код жанра` = j.`Код жанра` 
                                               WHERE j.`Название жанра` = '$genre_filter')";
    } else {
        $sql_books .= " WHERE k.`Код книги` IN (SELECT jk.`Код Книги` FROM `Жанр-Книга` jk 
                                                JOIN `Жанр` j ON jk.`Код жанра` = j.`Код жанра` 
                                                WHERE j.`Название жанра` = '$genre_filter')";
    }
}

// Применяем поиск по названию книги
if ($search_query) {
    if ($author_filter || $genre_filter) {
        $sql_books .= " AND k.`Название` LIKE '%$search_query%'";
    } else {
        $sql_books .= " WHERE k.`Название` LIKE '%$search_query%'";
    }
}

$books_result = $conn->query($sql_books);

// Обработка добавления книг в корзину
if (isset($_POST['add_to_cart'])) {
    if (isset($_POST['books']) && is_array($_POST['books'])) {
        foreach ($_POST['books'] as $book_id) {
            // Если корзина еще не существует, создаем её
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
                $_SESSION['count'] = [];
            }
            // Добавляем книгу в корзину, если она еще не добавлена
            if (!in_array($book_id, $_SESSION['cart'])) {
                $_SESSION['cart'][] = $book_id;
                $_SESSION['count'][$book_id] = 1;  // Устанавливаем количество по умолчанию
            }
        }
    }
    // Перенаправление на страницу корзины
    header('Location: cart.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея книг</title>
    <link rel="stylesheet" href="catalog.css" />
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

<!-- Форма для фильтрации книг -->
<div class="search">
    <form action="catalog.php" method="get">
        <div>
            <label for="search">Поиск по названию:</label>
            <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search_query); ?>" />
        </div>
        <div>
            <label for="author">Фильтр по автору:</label>
            <select id="author" name="author">
                <option value="">Выберите автора</option>
                <?php while ($author = $authors_result->fetch_assoc()): ?>
                    <option value="<?php echo $author['Имя'] . ' ' . $author['Фамилия']; ?>"
                        <?php echo $author['Имя'] . ' ' . $author['Фамилия'] == $author_filter ? 'selected' : ''; ?>>
                        <?php echo $author['Имя'] . ' ' . $author['Фамилия']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div>
            <label for="genre">Фильтр по жанру:</label>
            <select id="genre" name="genre">
                <option value="">Выберите жанр</option>
                <?php while ($genre = $genres_result->fetch_assoc()): ?>
                    <option value="<?php echo $genre['Название жанра']; ?>"
                        <?php echo $genre['Название жанра'] == $genre_filter ? 'selected' : ''; ?>>
                        <?php echo $genre['Название жанра']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div>
            <button type="submit">Применить фильтры</button>
        </div>
    </form>
</div>

<!-- Галерея книг -->
<form action="catalog.php" method="post">
    <div class="gallery">
        <?php while ($book = $books_result->fetch_assoc()): ?>
            <?php
            $ID = $book['Код книги'];
            $name = $book['Название'];
            $author = $book['Имя'] . ' ' . $book['Фамилия'];
            $price = $book['Цена'];
            $path = "$ID.jpg";  // Путь к изображению книги
            ?>
            <div class="book-item">
                <input type="checkbox" name="books[]" value="<?php echo $ID; ?>" />
                <a href="details.php?ID=<?php echo $ID; ?>">
                    <img src="<?php echo $path; ?>" alt="Обложка книги">
                    <div class="book-title"><?php echo $name; ?></div>
                    <div class="book-author"><?php echo $author; ?></div>
                    <div class="book-price"><?php echo $price; ?> руб.</div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
    <button type="submit" name="add_to_cart" class="center-button">Добавить в корзину</button>
</form>

<!-- Подвал -->
<div class="footer">
    <p>©2025, Библиотека "Книги для всех"</p>
</div>

</body>
</html>

<?php
$conn->close();
?>
