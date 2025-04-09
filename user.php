<?php
session_start();
include("db_connect.php");

if (empty($_SESSION['auth'])) {
    echo "Ошибка: не авторизован.";
    exit();
}

$user_id = $_SESSION['ID'];
$query = "SELECT * FROM users WHERE ID = '$user_id'";
$data = mysqli_fetch_assoc($conn->query($query));

if (!$data) {
    echo "Ошибка: пользователь не найден.";
    die();
}

$orders_query = "SELECT * FROM orders WHERE user_id = '$user_id'";
$orders = $conn->query($orders_query);

if (!$orders) {
    echo "Ошибка запроса на заказы: " . $conn->error;
    die();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="библиотека, личный кабинет" />
    <meta name="description" content="Личный кабинет пользователя" />
    <link rel="stylesheet" href="user.css" />
    <title>Библиотека - Личный кабинет</title>
   <script>
    // Функция для отображения формы редактирования данных на месте
    function editData(field) {
        const cell = document.getElementById(field + '_value');
        const currentValue = field === 'password' ? '' : cell.innerText.trim(); // Сохраняем текущее значение

        // Заменяем текст на поле ввода
        const input = document.createElement('input');
        input.type = 'text';
        input.value = currentValue;
        cell.innerHTML = '';  // Очищаем ячейку
        cell.appendChild(input);  // Вставляем поле ввода

        // Устанавливаем фокус на поле ввода
        input.focus();

        // Создаем кнопку "Сохранить"
        const saveButton = document.createElement('button');
        saveButton.innerText = 'Сохранить';
        saveButton.onclick = function () {
            const newValue = input.value.trim();
            updateData(field, newValue);  // Вызываем функцию для обновления данных на сервере
            cell.innerHTML = newValue; // Вставляем новое значение в ячейку
            saveButton.style.display = 'none'; // Скрываем кнопку "Сохранить"
        };

        // Вставляем кнопку "Сохранить" в ячейку рядом с полем ввода
        cell.appendChild(saveButton);

        // При нажатии Enter сразу сохраняем данные
        input.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                const newValue = input.value.trim();
                updateData(field, newValue);  // Обновляем данные на сервере
                cell.innerHTML = newValue; // Вставляем новое значение в ячейку
                saveButton.style.display = 'none'; // Скрываем кнопку "Сохранить"
            }
        });

        // При потере фокуса (blur), сохраняем изменения
        input.addEventListener('blur', function() {
            const newValue = input.value.trim();
            updateData(field, newValue);  // Вызываем функцию для обновления данных на сервере
            cell.innerHTML = newValue; // Вставляем новое значение в ячейку
            saveButton.style.display = 'none'; // Скрываем кнопку "Сохранить"
        });
    }

    // Функция для обновления данных на сервере
    function updateData(field, newValue) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_user_data.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('field_name=' + field + '&new_value=' + encodeURIComponent(newValue));

        // Обработчик ответа сервера
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Данные успешно обновлены');
            } else {
                console.log('Ошибка при обновлении данных');
            }
        };
    }
</script>


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
        </div>
    <?php else: ?>
        <div class="right-header">
            <a href="cart.php">Корзина</a>
            <a href="user.php">Личный кабинет</a>
            <a href="logout.php">Выйти</a>
        </div>
    <?php endif; ?>
</div>

<!-- Контент личного кабинета -->
<div class="content">
    <h1>Личный кабинет</h1>
    
    <!-- Информация о пользователе -->
    <h2>Информация о пользователе</h2>

    <!-- Таблица с данными -->
   <table id="infoTable">
    <thead>
        <tr>
            <th>Поле</th>
            <th>Значение</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Имя</td>
            <td id="name_value"><?php echo $data['name']; ?></td>
            <td>
                <button onclick="editData('name')">Изменить</button>
                <!-- Кнопка "Сохранить" будет добавлена динамически -->
            </td>
        </tr>
        <tr>
            <td>Фамилия</td>
            <td id="surname_value"><?php echo $data['surname']; ?></td>
            <td>
                <button onclick="editData('surname')">Изменить</button>
                <!-- Кнопка "Сохранить" будет добавлена динамически -->
            </td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td id="number_value"><?php echo $data['number'] ? $data['number'] : 'Не указан'; ?></td>
            <td>
                <button onclick="editData('number')">Изменить</button>
                <!-- Кнопка "Сохранить" будет добавлена динамически -->
            </td>
        </tr>
        <tr>
            <td>Почта</td>
            <td id="email_value"><?php echo $data['email'] ? $data['email'] : 'Не указана'; ?></td>
            <td>
                <button onclick="editData('email')">Изменить</button>
                <!-- Кнопка "Сохранить" будет добавлена динамически -->
            </td>
        </tr>
        <tr>
            <td>Логин</td>
            <td id="login_value"><?php echo $data['login']; ?></td>
            <td>
                <button onclick="editData('login')">Изменить</button>
                <!-- Кнопка "Сохранить" будет добавлена динамически -->
            </td>
        </tr>
        <tr>
            <td>Дата регистрации</td>
            <td id="created_at_value"><?php echo date('d-m-Y', strtotime($data['created_at'])); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Пароль</td>
            <td id="password_value">******</td>
            <td>
                <button onclick="editData('password')">Изменить</button>
                <!-- Кнопка "Сохранить" будет добавлена динамически -->
            </td>
        </tr>
    </tbody>
</table>


    <!-- История заказов -->
    <h1>Заказы</h1>
    <table>
        <thead>
            <tr>
                <th>Номер заказа</th>
                <th>Дата заказа</th>
                <th>Адрес</th>
                <th>Подробнее</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $order_number = 1;
            while ($order = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $order_number; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($order['date'])); ?></td>
                    <td><?php echo $order['address']; ?></td>
                    <td>
                        <form action="order_detail.php" method="get">
                            <button type="submit">Подробнее</button>
                            <input name="ID" value="<?php echo $order['ID']; ?>" hidden>
                        </form>
                    </td>
                </tr>
                <?php $order_number++; ?>
            <?php endwhile; ?>
        </tbody>
    </table>
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
