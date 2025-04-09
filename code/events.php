<?php 
session_start();

// Путь к файлам счетчиков
$counter_file = "events_counter.txt";
$unique_visitors_file = "unique_visitors.txt";

// Проверка наличия cookie для уникального пользователя
if (!isset($_COOKIE['unique_visitor'])) {
    // Устанавливаем cookie для уникального пользователя на 1 день
    setcookie('unique_visitor', 'true', time() + 86400, "/");  // 86400 секунд = 1 день
    
    // Получаем ID пользователя (если есть)
    $user_id = isset($_SESSION['auth']) ? $_SESSION['auth'] : 'guest';

    // Добавляем запись о новом уникальном посетителе в файл
    $visitor_data = $user_id . "\n";
    file_put_contents($unique_visitors_file, $visitor_data, FILE_APPEND);
}

// Читаем количество уникальных посетителей
$unique_visitor_count = count(file($unique_visitors_file));

// Увеличиваем счетчик для общего числа посещений
if (file_exists($counter_file)) {
    $current_count = file_get_contents($counter_file);
    $current_count++;
    file_put_contents($counter_file, $current_count);
} else {
    file_put_contents($counter_file, 1);
}

$visit_count = file_get_contents($counter_file);
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="библиотека, события, книги" />
    <meta name="description" content="События в библиотеке" />
    <link rel="stylesheet" href="index.css" />
    <title>События - Библиотека "Книги для всех"</title>
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
      <h1>События в библиотеке</h1>
      <p>У нас всегда много интересных мероприятий и событий! Следите за нашими новостями и присоединяйтесь к нам!</p>

      <!-- Список событий -->
      <div class="events">
        <h2>Предстоящие события:</h2>

        <ul>
          <!-- Литературная встреча -->
          <li>
            <strong>15 апреля 2025</strong> - Литературная встреча с автором новых книг!
            <p>Присоединяйтесь к нам на литературной встрече с известным автором, который представит свою новую книгу и поделится опытом написания.</p>
            <p><em>Не пропустите шанс задать вопросы и получить автограф!</em></p>
            <img src="event1.jpg" alt="Литературная встреча" style="width: 30%; height: 150px; border-radius: 8px; object-fit: cover">
          </li>

          <!-- Книжный фестиваль -->
          <li>
            <strong>22 апреля 2025</strong> - Книжный фестиваль на площади у библиотеки!
            <p>Вас ждут стенды с новинками литературы, встречи с авторами и интересные лекции на тему современного книгоиздания.</p>
            <p><em>Приходите всей семьей — будет интересно всем!</em></p>
            <img src="event2.jpg" alt="Книжный фестиваль" style="width: 30%; height: 150px; border-radius: 8px; object-fit: cover">
          </li>

          <!-- Курс по написанию собственных произведений -->
          <li>
            <strong>30 апреля 2025</strong> - Курс по написанию собственных произведений.
            <p>Этот курс предназначен для всех, кто мечтает стать писателем! Вас ждет практическое занятие по созданию своих первых произведений.</p>
            <p><em>Записывайтесь заранее, количество мест ограничено!</em></p>
            <img src="event3.jpg" alt="Курс по написанию произведений" style="width: 30%; height: 150px; border-radius: 8px; object-fit: cover">
          </li>

          <!-- Вечер поэзии -->
          <li>
            <strong>5 мая 2025</strong> - Вечер поэзии для всех желающих!
            <p>Этот вечер будет посвящен поэзии! Приглашаем всех желающих почитать стихи, услышать знаменитых поэтов и насладиться атмосферой искусства.</p>
            <p><em>Вход свободный, но количество мест ограничено!</em></p>
            <img src="event4.jpg" alt="Вечер поэзии" style="width: 30%; height: 150px; border-radius: 8px; object-fit: cover">
          </li>
        </ul>
      </div>

      <!-- Показываем количество уникальных пользователей -->
      <p>Количество уникальных пользователей, посетивших эту страницу: <?php echo $unique_visitor_count; ?></p>

    </main>
    
    <!-- Подвал -->
    <footer class="footer">
      <p>©2025, Библиотека "Книги для всех"</p>
    </footer>
  </body>
</html>
