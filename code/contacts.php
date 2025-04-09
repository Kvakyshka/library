<?php session_start() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="библиотека, контакты, онлайн" />
    <meta name="description" content="Свяжитесь с нами для получения дополнительной информации" />
    <link rel="stylesheet" href="index.css" />
    <title>Контакты - Библиотека "Книги для всех"</title>
</head>
<body>
    <!-- Шапка сайта -->
    <div class="header">
        <div class="left-header">
            <a href="index.php">Главная</a>
            <a href="catalog.php">Каталог книг</a>
            <a href="events.php">События</a>
            <a href="contact.php">Контакты</a>
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

    <!-- Контент страницы -->
    <div class="content">
        <div class="container">
            <div class="contact-card">
                <h1>Контакты</h1>
                <p>Мы всегда рады помочь! Свяжитесь с нами, если у вас есть вопросы или предложения.</p>
                <h3>Немного информации:</h3>
                <p>Телефон: 8(800)000-00-00</p>
                <p>Электронная почта: keyboardgeeks@mail.com</p>
                <p>Адрес: Россия, Санкт-Петербург, Лучший офис, д. 1</p>
            </div>
            <div class="contact-card">
                <form method="post">
                    <h2>Связаться с нами</h2>
                    <div>
                        <label for="sendComm">
                            Оставьте сообщение:
                        </label>
                        <textarea id="sendComm" class="contacts__textarea" name="sendComm" cols="50" rows="5" placeholder="Введите ваше сообщение здесь..."></textarea>
                    </div>
                    <div>
                        <input class="button" type="submit" value="Отправить">
                    </div>
                </form>
                <?php
                if (isset($_POST["sendComm"])) {
                    // Отправка письма на указанный email
                    mail('semenova.vika19@yandex.ru', 'Сообщение от пользователя', $_POST["sendComm"]);
                    echo "<p>Спасибо за ваше сообщение! Мы свяжемся с вами в ближайшее время.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Подвал -->
    <div class="footer">
        <a href="about.php"><p>©2023, Библиотека "Книги для всех"</p></a>
    </div>
</body>
</html>
