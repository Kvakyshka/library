<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("db_connect.php");
/** @var mysqli $conn */

// Проверяем, авторизован ли пользователь
if (empty($_SESSION['auth'])) {
    header("Location: login.php");
    exit();
}

// Получаем данные текущего пользователя
$user_id = $_SESSION['ID'];
$query = "SELECT * FROM users WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);  // Используем подготовленный запрос
$stmt->execute();
$result = $stmt->get_result();
$info = $result->fetch_assoc();

// Обрабатываем форму редактирования
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $password = $_POST['password'];

    // Хэшируем пароль, если он был изменен
    $hashed_password = $password ? password_hash($password, PASSWORD_DEFAULT) : $info['password'];  // Если пароль пустой, оставляем старый

    // Обновляем данные пользователя
    $update_query = "UPDATE users SET name = ?, surname = ?, login = ?, email = ?, number = ?, password = ? WHERE ID = ?";
    $stmt_update = $conn->prepare($update_query);
    $stmt_update->bind_param('ssssssi', $name, $surname, $login, $email, $number, $hashed_password, $user_id);

    if ($stmt_update->execute()) {
        // После успешного обновления перенаправляем на страницу личного кабинета
        header('Location: user.php');
        exit();
    } else {
        // Выводим ошибку при неудачном обновлении
        $error_message = "Ошибка при обновлении данных.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="библиотека, редактирование, личный кабинет" />
    <meta name="description" content="Редактирование данных пользователя" />
    <link rel="stylesheet" href="user.css" />
    <title>Редактирование данных</title>
</head>
<body>

<!-- Шапка сайта -->
<div class="header">
    <div class="left-header">
        <a href="index.php">Библиотека "Книги для всех"</a>
        <a href="index.php">Главная</a>
        <a href="catalog.php">Каталог книг</a>
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

<!-- Форма редактирования -->
<div class="content">
    <h2>Редактирование данных</h2>

    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="user_edit.php" method="post">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($info['name']); ?>" required /><br />

        <label for="surname">Фамилия:</label>
        <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($info['surname']); ?>" required /><br />

        <label for="login">Логин:</label>
        <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($info['login']); ?>" required /><br />

        <label for="email">Почта:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($info['email']); ?>" required /><br />

        <label for="number">Номер:</label>
        <input type="tel" id="number" name="number" value="<?php echo htmlspecialchars($info['number']); ?>" pattern="+7([0-9]{3})[0-9]{3}-[0-9]{2}-[0-9]{2}" required /><br />

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" placeholder="Введите новый пароль (если нужно)" /><br />

        <button type="submit" class="catalog-button">Сохранить</button>
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


