<?php session_start() ?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="библиотека, книги, онлайн каталог" />
    <meta name="description" content="Интернет-магазин и библиотека книг" />
    <link rel="stylesheet" href="index.css" />
    <title>Библиотека "Книги для всех"</title>
  </head>
  <body>
    <!-- Шапка сайта -->
    <header class="header">
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
    </header>
    
    <!-- Основной контент -->
    <main class="content">
      <h1>Добро пожаловать в библиотеку "Книги для всех"</h1>
      <p>Наши книги – это источник знаний и вдохновения для всех возрастов. Мы предоставляем широкий выбор произведений для любителей разных жанров.</p>
      <img src="библиотека.png" alt="Книги" class="main-image" />
      <a href="catalog.php"><button class="catalog-button">Перейти в каталог книг</button></a>
    </main>
    
    <!-- Подвал -->
    <footer class="footer">
      <a href="about.php"><p>©2025, Библиотека "Книги для всех"</p></a>
    </footer>
  </body>
</html>
