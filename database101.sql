-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Апр 22 2025 г., 08:38
-- Версия сервера: 5.7.24
-- Версия PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `database101`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `address` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`ID`, `address`, `date`, `user_id`) VALUES
(1, 'Москва, ул. Тверская, д. 7, кв. 12', '2023-03-31 21:00:00', 1),
(2, 'Санкт-Петербург, ул. Невский, д. 35', '2023-04-01 21:00:00', 2),
(3, 'Новосибирск, пр. Карла Маркса, д. 12, офис 345', '2023-04-02 21:00:00', 3),
(4, 'Москва, ул. Тверская, д. 7, кв. 12', '2025-04-01 21:00:00', 6),
(5, 'Москва, ул. Тверская, д. 7, кв. 12', '2025-04-01 21:00:00', 6),
(6, 'dfvlkfmvlr', '2025-04-01 21:00:00', 6),
(7, '1', '2025-04-01 21:00:00', 6),
(8, '123', '2025-04-01 21:00:00', 7),
(9, '12', '2025-04-01 21:00:00', 5),
(10, '1234', '2025-04-01 21:00:00', 5),
(23, 'Москва, ул. Тверская, д. 7, кв. 12', '2025-04-02 21:00:00', 9),
(24, 'Москва, ул. Тверская, д. 7, кв. 12', '2025-04-04 21:00:00', 5),
(25, 'Москва, ул. Тверская, д. 7, кв. 12', '2025-04-05 21:00:00', 9),
(26, 'Москва, ул. Тверская, д. 7, кв. 12', '2025-04-05 21:00:00', 9),
(27, 'Москва, ул. Тверская, д. 7, кв. 12', '2025-04-08 21:00:00', 9);

-- --------------------------------------------------------

--
-- Структура таблицы `orders_books`
--

CREATE TABLE `orders_books` (
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders_books`
--

INSERT INTO `orders_books` (`order_id`, `book_id`, `count`) VALUES
(5, 10, 1),
(6, 9, 1),
(6, 14, 1),
(7, 27, 1),
(8, 32, 1),
(9, 10, 1),
(10, 9, 1),
(10, 18, 1),
(10, 29, 1),
(23, 10, 1),
(24, 16, 1),
(25, 9, 1),
(25, 16, 1),
(26, 9, 2),
(26, 14, 2),
(26, 16, 1),
(26, 18, 1),
(26, 35, 1),
(26, 36, 1),
(27, 16, 1),
(27, 18, 1),
(27, 27, 1),
(27, 35, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `registration_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `registrations`
--

INSERT INTO `registrations` (`id`, `user_id`, `event_name`, `registration_date`) VALUES
(1, 1, 'literary-meeting', '2025-04-05 10:46:35');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `reg_day` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `login`, `password`, `email`, `created_at`, `name`, `surname`, `number`, `reg_day`) VALUES
(1, 'us1', '1111', NULL, '2025-04-01 17:29:32', 'Вика', 'Фамилия', NULL, NULL),
(2, 'us2', '2222', NULL, '2025-04-01 17:29:32', 'Рома', 'Фамилия', NULL, NULL),
(3, 'us3', '3333', NULL, '2025-04-01 17:29:32', 'Лиза', 'Фамилия', NULL, NULL),
(4, 'zzz', '$2y$10$Re20hYs/ovxRpx3FpewqOerCrR8zYexWGZ7Lrm5mdA2TKV4LLiwJW', 'zzzz@mail.ru', '2025-04-02 15:09:25', 'яяяя', 'zzz', '89050000001', '2025-04-02'),
(5, '', '$2y$10$gxDo7O0XkYAHCiNpkVO.XOfjKpyBEXUOpu3BGz0Xf1KYq0FJgk.i.', '', '2025-04-02 15:12:38', '', '', '', '2025-04-02'),
(6, 'us6', '$2y$10$8bc0djogZ8aKjRgbde5J7.tppA2WxycKi.6FPWF4z9m9NWJSxCvTS', 'asagggs@mail.ru', '2025-04-02 15:16:53', 'Kates', 'Фамилияzz', '89050000002', '2025-04-02'),
(7, 'us7', '$2y$10$hzx8ImIFU3cc5RHmyV3NS.EbN766lrgIrnXjNQzoa.RI5z4ondQ/e', 'asasss@mail.ru', '2025-04-02 16:07:45', 'Роман', 'Фамилияzz', '89050000005', '2025-04-02'),
(8, 'us8', '$2y$10$q/iMLwomlDS7FWgsi5PQvePWfcmn9S.JM1IaJkTKPsur9rzdGG8AK', 'fvnvjssf@mail.ru', '2025-04-02 16:34:19', 'WOL', 'zzzz', '89050000000', '2025-04-02'),
(9, 'Kvakyshka', '$2y$10$jlY0gdXEuB.//XuqUR6u3uAzfmwGVyzZMba4MLaCBVrZ2/thaIKO6', 'semenova.vika19@yandex.ru', '2025-04-03 17:57:18', 'Виктория1', 'Айсувакова', '8905000000', '2025-04-03'),
(10, 'Rita', '$2y$10$6WUSTMHOuB./mocMH/qCjuwTOhiWe27XMHwOrGV8ZkKsbbgVcIQVW', 'Rita@mail.ru', '2025-04-05 06:29:53', 'Маргарита', 'Семенова', '8905053385571', '2025-04-05'),
(11, 'Roma', '$2y$10$sOJVaJ3pHGD8.Pq4ORH11OLHO/o9ritNfVb5ZPusEMA3HfmES2fde', 'ajsuvakoff@yandex.ru', '2025-04-05 08:01:43', 'Роман', 'Айсувакова', '89081117784', '2025-04-05'),
(12, 'Дмитрий12', '$2y$10$aDLXKhh2fq/CQ8xWTPK4Be9Ufkb559m3ixF..vPhZRYvtwGvoH1Lu', 'dima@mai.ru', '2025-04-09 14:05:35', 'Дмитрий', 'Семенов', '89050000012', '2025-04-09');

-- --------------------------------------------------------

--
-- Структура таблицы `издательство`
--

CREATE TABLE `издательство` (
  `Код Издательства` int(11) NOT NULL,
  `Название` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `издательство-книга`
--

CREATE TABLE `издательство-книга` (
  `Код Издательства` int(11) DEFAULT NULL,
  `Код Книги` int(11) DEFAULT NULL,
  `Код Издательство-книга` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `книга`
--

CREATE TABLE `книга` (
  `Код книги` int(11) NOT NULL,
  `Код Библиотеки` int(11) DEFAULT NULL,
  `Название` varchar(255) DEFAULT NULL,
  `Год` datetime DEFAULT NULL,
  `Цена` decimal(10,2) DEFAULT NULL,
  `Сдана` tinyint(1) DEFAULT NULL,
  `Ссылка на электронную версию` varchar(255) DEFAULT NULL,
  `Обложка книги` longblob,
  `Код количество страниц` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `книга`
--

INSERT INTO `книга` (`Код книги`, `Код Библиотеки`, `Название`, `Год`, `Цена`, `Сдана`, `Ссылка на электронную версию`, `Обложка книги`, `Код количество страниц`) VALUES
(9, NULL, 'Война и мир', '1869-01-01 00:00:00', 500.00, NULL, NULL, NULL, NULL),
(10, NULL, 'Идиот', '1866-01-01 00:00:00', 400.00, NULL, NULL, NULL, NULL),
(14, NULL, 'Анна Каренина', '1877-01-01 00:00:00', 450.00, NULL, NULL, NULL, NULL),
(16, NULL, 'Вечер', '1966-01-01 00:00:00', 600.00, NULL, NULL, NULL, NULL),
(18, NULL, 'Моим стихам', '1949-01-01 00:00:00', 550.00, NULL, NULL, NULL, NULL),
(27, NULL, 'Обломов', '1997-01-01 00:00:00', 700.00, NULL, NULL, NULL, NULL),
(29, NULL, 'Детство', '1936-01-01 00:00:00', 650.00, NULL, NULL, NULL, NULL),
(32, NULL, 'Мужчина идет на Спорт', '1929-01-01 00:00:00', 400.00, NULL, NULL, NULL, NULL),
(33, NULL, 'Братья Карамазовы', '1880-01-01 00:00:00', 500.00, NULL, NULL, NULL, NULL),
(34, NULL, 'Отцы и дети', '1862-01-01 00:00:00', 400.00, NULL, NULL, NULL, NULL),
(35, NULL, 'Реквием', '1935-01-01 00:00:00', 300.00, NULL, NULL, NULL, NULL),
(36, NULL, 'После России', '1928-01-01 00:00:00', 350.00, NULL, NULL, NULL, NULL),
(37, NULL, 'Обломов', '1859-01-01 00:00:00', 550.00, NULL, NULL, NULL, NULL),
(38, NULL, 'Мать', '1906-01-01 00:00:00', 600.00, NULL, NULL, NULL, NULL),
(39, NULL, 'Письма о жизни', '1920-01-01 00:00:00', 450.00, NULL, NULL, NULL, NULL),
(40, NULL, 'Дворянское гнездо', '1859-01-01 00:00:00', 500.00, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `автор`
--

CREATE TABLE `автор` (
  `Код автор` int(11) NOT NULL,
  `Имя` varchar(255) DEFAULT NULL,
  `Фамилия` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `автор`
--

INSERT INTO `автор` (`Код автор`, `Имя`, `Фамилия`) VALUES
(1, 'Лев', 'Толстой'),
(2, 'Федор', 'Достоевский'),
(3, 'Александр', 'Тургенев'),
(4, 'Анна', 'Ахматова'),
(5, 'Марина', 'Цветаева'),
(6, 'Лев', 'Гончаров'),
(7, 'Максим', 'Горький'),
(8, 'Роман', 'Гончаров'),
(9, 'Иван', 'Иванов'),
(11, 'Алексей', 'Чехов'),
(12, 'Иван', 'Тургенев'),
(14, 'Дмитрий', 'Толстой');

-- --------------------------------------------------------

--
-- Структура таблицы `автор-книга`
--

CREATE TABLE `автор-книга` (
  `Код Автор-Книга` int(11) NOT NULL,
  `Код Автор` int(11) DEFAULT NULL,
  `Код Книга` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `автор-книга`
--

INSERT INTO `автор-книга` (`Код Автор-Книга`, `Код Автор`, `Код Книга`) VALUES
(1, 1, 9),
(2, 2, 10),
(3, 1, 14),
(4, 4, 16),
(5, 5, 18),
(6, 6, 27),
(7, 7, 29),
(8, 6, 32),
(9, 2, 33),
(10, 3, 34),
(11, 4, 35),
(12, 5, 36),
(13, 6, 37),
(14, 7, 38),
(15, 9, 39),
(17, 12, 40);

-- --------------------------------------------------------

--
-- Структура таблицы `библиотека`
--

CREATE TABLE `библиотека` (
  `Код библиотеки` int(11) NOT NULL,
  `Количество книг` int(11) DEFAULT NULL,
  `Время начала работы` datetime DEFAULT NULL,
  `Время окончания работы` datetime DEFAULT NULL,
  `Название` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `библиотека-читатель`
--

CREATE TABLE `библиотека-читатель` (
  `Код Библиотека-читатель` int(11) NOT NULL,
  `Код библиотеки` int(11) DEFAULT NULL,
  `Код читателя` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `жанр`
--

CREATE TABLE `жанр` (
  `Код жанра` int(11) NOT NULL,
  `Название жанра` varchar(255) DEFAULT NULL,
  `Описание жанра` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `жанр`
--

INSERT INTO `жанр` (`Код жанра`, `Название жанра`, `Описание жанра`) VALUES
(1, 'Фантастика', 'Жанр, включающий как научную, так и ненаучную фантазию, где часто присутствуют элементы футуризма и вымышленных технологий.'),
(2, 'Детектив', 'Жанр, фокусирующийся на расследовании преступлений, разгадывании тайн и раскрытии загадок.'),
(3, 'Роман', 'Жанр, характеризующийся подробным изображением человеческих взаимоотношений, социальных условий и личных драм.'),
(4, 'Триллер', 'Жанр, включающий элементы напряжения, страха, загадки, с фокусом на сюжете, где читатель испытывает тревогу и напряжение.'),
(5, 'Поэзия', 'Жанр, включающий литературные произведения в стихах, часто с акцентом на ритм, метафоры и эмоции.'),
(6, 'Боевик', 'Жанр, в основе которого лежат сцены интенсивного действия, боевых искусств и ярких схваток.'),
(7, 'Комедия', 'Жанр, предназначенный для того, чтобы развлекать и вызывать смех у аудитории, обычно с элементами юмора и сатиры.'),
(8, 'Фэнтези', 'Жанр, основанный на магии и вымышленных мирах, где часто присутствуют мифические существа и эпические приключения.'),
(9, 'Научная фантастика', 'Жанр, который включает в себя вымышленные, но научно обоснованные элементы, такие как путешествия во времени, космические исследования и футуристические технологии.'),
(10, 'Документальная литература', 'Жанр, включающий произведения, основанные на реальных событиях, фактах и исследованиях.'),
(11, 'Трагедия', 'Жанр, фокусирующийся на трагических событиях и судьбах персонажей, часто с катастрофическим финалом.'),
(12, 'Мистика', 'Жанр, в котором присутствуют элементы сверхъестественного, необъяснимого и мистического.'),
(13, 'Приключенческий', 'Жанр, который включает в себя сюжет, основанный на захватывающих приключениях, путешествиях и поисках.'),
(14, 'Исторический', 'Жанр, основанный на событиях прошлого, описывающий историю и личные судьбы людей в определенные исторические эпохи.');

-- --------------------------------------------------------

--
-- Структура таблицы `жанр-книга`
--

CREATE TABLE `жанр-книга` (
  `Код Жанра` int(11) DEFAULT NULL,
  `Код Книги` int(11) DEFAULT NULL,
  `Код Жанр-книга` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `жанр-книга`
--

INSERT INTO `жанр-книга` (`Код Жанра`, `Код Книги`, `Код Жанр-книга`) VALUES
(3, 9, 1),
(14, 9, 2),
(2, 10, 3),
(3, 10, 4),
(3, 14, 5),
(11, 14, 6),
(3, 16, 7),
(4, 16, 8),
(1, 18, 9),
(4, 18, 10),
(8, 27, 11),
(13, 27, 12),
(3, 29, 13),
(11, 29, 14),
(3, 32, 15),
(11, 32, 16),
(3, 33, 17),
(3, 34, 18),
(5, 35, 19),
(5, 36, 20),
(3, 37, 21),
(3, 38, 22),
(10, 39, 23),
(3, 40, 24);

-- --------------------------------------------------------

--
-- Структура таблицы `реквизиты`
--

CREATE TABLE `реквизиты` (
  `Код читателя` int(11) UNSIGNED NOT NULL,
  `Код книги` int(11) UNSIGNED NOT NULL,
  `Код автор` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `срок использования`
--

CREATE TABLE `срок использования` (
  `Код договора` int(11) NOT NULL,
  `Номер книги` int(11) DEFAULT NULL,
  `Номер читателя` int(11) DEFAULT NULL,
  `Дата выдачи` datetime DEFAULT NULL,
  `Дата возврата` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `читатель`
--

CREATE TABLE `читатель` (
  `Код читателя` int(11) NOT NULL,
  `Имя` varchar(255) NOT NULL,
  `Фамилия` varchar(255) DEFAULT NULL,
  `Отчество` varchar(255) DEFAULT NULL,
  `Номер телефона` int(11) DEFAULT NULL,
  `Номер читательского билета` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `orders_books`
--
ALTER TABLE `orders_books`
  ADD PRIMARY KEY (`order_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Индексы таблицы `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `издательство`
--
ALTER TABLE `издательство`
  ADD PRIMARY KEY (`Код Издательства`);

--
-- Индексы таблицы `издательство-книга`
--
ALTER TABLE `издательство-книга`
  ADD PRIMARY KEY (`Код Издательство-книга`),
  ADD KEY `fk_Издательство_Код_издательства` (`Код Издательства`),
  ADD KEY `fk_Издательство_Код_книги` (`Код Книги`);

--
-- Индексы таблицы `книга`
--
ALTER TABLE `книга`
  ADD PRIMARY KEY (`Код книги`),
  ADD KEY `Код книги` (`Код книги`),
  ADD KEY `Код книги_2` (`Код книги`),
  ADD KEY `fk_Код_библиотеки` (`Код Библиотеки`);

--
-- Индексы таблицы `автор`
--
ALTER TABLE `автор`
  ADD PRIMARY KEY (`Код автор`),
  ADD KEY `Код автор` (`Код автор`),
  ADD KEY `Код автор_2` (`Код автор`);

--
-- Индексы таблицы `автор-книга`
--
ALTER TABLE `автор-книга`
  ADD PRIMARY KEY (`Код Автор-Книга`);

--
-- Индексы таблицы `библиотека`
--
ALTER TABLE `библиотека`
  ADD PRIMARY KEY (`Код библиотеки`);

--
-- Индексы таблицы `библиотека-читатель`
--
ALTER TABLE `библиотека-читатель`
  ADD PRIMARY KEY (`Код Библиотека-читатель`),
  ADD KEY `fk_Библиотека_Код_библиотеки` (`Код библиотеки`),
  ADD KEY `fk_Читатель_Код_читателя` (`Код читателя`);

--
-- Индексы таблицы `жанр`
--
ALTER TABLE `жанр`
  ADD PRIMARY KEY (`Код жанра`);

--
-- Индексы таблицы `жанр-книга`
--
ALTER TABLE `жанр-книга`
  ADD PRIMARY KEY (`Код Жанр-книга`),
  ADD KEY `fk_Жанр_Код_жанра` (`Код Жанра`),
  ADD KEY `fk_Жанр_Код_книги` (`Код Книги`);

--
-- Индексы таблицы `реквизиты`
--
ALTER TABLE `реквизиты`
  ADD PRIMARY KEY (`Код читателя`,`Код книги`,`Код автор`);

--
-- Индексы таблицы `срок использования`
--
ALTER TABLE `срок использования`
  ADD PRIMARY KEY (`Код договора`);

--
-- Индексы таблицы `читатель`
--
ALTER TABLE `читатель`
  ADD PRIMARY KEY (`Код читателя`),
  ADD KEY `Код читателя` (`Код читателя`),
  ADD KEY `Код читателя_2` (`Код читателя`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `книга`
--
ALTER TABLE `книга`
  MODIFY `Код книги` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT для таблицы `автор`
--
ALTER TABLE `автор`
  MODIFY `Код автор` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `автор-книга`
--
ALTER TABLE `автор-книга`
  MODIFY `Код Автор-Книга` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `жанр`
--
ALTER TABLE `жанр`
  MODIFY `Код жанра` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `жанр-книга`
--
ALTER TABLE `жанр-книга`
  MODIFY `Код Жанр-книга` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`);

--
-- Ограничения внешнего ключа таблицы `orders_books`
--
ALTER TABLE `orders_books`
  ADD CONSTRAINT `orders_books_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`ID`),
  ADD CONSTRAINT `orders_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `книга` (`Код книги`);

--
-- Ограничения внешнего ключа таблицы `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`);

--
-- Ограничения внешнего ключа таблицы `издательство-книга`
--
ALTER TABLE `издательство-книга`
  ADD CONSTRAINT `fk_Издательство_Код_издательства` FOREIGN KEY (`Код Издательства`) REFERENCES `издательство` (`Код Издательства`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_Код_издательства_в_книге` FOREIGN KEY (`Код Издательства`) REFERENCES `издательство` (`Код Издательства`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `книга`
--
ALTER TABLE `книга`
  ADD CONSTRAINT `fk_Код_библиотеки` FOREIGN KEY (`Код Библиотеки`) REFERENCES `библиотека` (`Код библиотеки`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `библиотека-читатель`
--
ALTER TABLE `библиотека-читатель`
  ADD CONSTRAINT `fk_Библиотека_Код_библиотеки` FOREIGN KEY (`Код библиотеки`) REFERENCES `библиотека` (`Код библиотеки`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_Читатель_Код_читателя` FOREIGN KEY (`Код читателя`) REFERENCES `читатель` (`Код читателя`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `жанр-книга`
--
ALTER TABLE `жанр-книга`
  ADD CONSTRAINT `fk_Жанр_Код_жанра` FOREIGN KEY (`Код Жанра`) REFERENCES `жанр` (`Код жанра`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_Жанр_Код_книги` FOREIGN KEY (`Код Книги`) REFERENCES `книга` (`Код книги`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
