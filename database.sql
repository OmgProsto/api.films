-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 27 2021 г., 17:49
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `api_films`
--

-- --------------------------------------------------------

--
-- Структура таблицы `actors`
--

CREATE TABLE `actors` (
  `id_actor` int(11) NOT NULL,
  `actor` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `actors`
--

INSERT INTO `actors` (`id_actor`, `actor`) VALUES
(1, 'Бен Аффлек'),
(2, 'Роберт Паттин'),
(4, 'Том Круз'),
(5, 'Орландо Блум'),
(6, 'Хью Джекман'),
(7, 'Хит Леджер'),
(8, 'Брэд Питт'),
(9, 'Олег Попов');

-- --------------------------------------------------------

--
-- Структура таблицы `films`
--

CREATE TABLE `films` (
  `id_film` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL,
  `film` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `films`
--

INSERT INTO `films` (`id_film`, `id_genre`, `film`) VALUES
(1, 1, 'Игроки3'),
(2, 1, 'Гамлет'),
(3, 2, 'Большой куш'),
(4, 2, 'День радио'),
(5, 3, 'Из ада'),
(6, 3, 'Ничего себе'),
(9, 1, 'Аватар');

-- --------------------------------------------------------

--
-- Структура таблицы `film_actor_m2m`
--

CREATE TABLE `film_actor_m2m` (
  `id` int(11) NOT NULL,
  `id_actor` int(11) NOT NULL,
  `id_film` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `film_actor_m2m`
--

INSERT INTO `film_actor_m2m` (`id`, `id_actor`, `id_film`) VALUES
(1, 4, 4),
(2, 4, 1),
(4, 6, 5),
(7, 2, 3),
(8, 1, 1),
(9, 7, 6),
(10, 8, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

CREATE TABLE `genres` (
  `id_genre` int(11) NOT NULL,
  `genre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `genres`
--

INSERT INTO `genres` (`id_genre`, `genre`) VALUES
(1, 'Трагедия'),
(2, 'Комедия'),
(3, 'Детектив'),
(4, 'Документальный');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`id_actor`);

--
-- Индексы таблицы `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id_film`),
  ADD KEY `id_genre` (`id_genre`);

--
-- Индексы таблицы `film_actor_m2m`
--
ALTER TABLE `film_actor_m2m`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_actor` (`id_actor`),
  ADD KEY `id_film` (`id_film`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id_genre`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `actors`
--
ALTER TABLE `actors`
  MODIFY `id_actor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `films`
--
ALTER TABLE `films`
  MODIFY `id_film` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `film_actor_m2m`
--
ALTER TABLE `film_actor_m2m`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `films`
--
ALTER TABLE `films`
  ADD CONSTRAINT `films_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genres` (`id_genre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `film_actor_m2m`
--
ALTER TABLE `film_actor_m2m`
  ADD CONSTRAINT `film_actor_m2m_ibfk_1` FOREIGN KEY (`id_actor`) REFERENCES `actors` (`id_actor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `film_actor_m2m_ibfk_2` FOREIGN KEY (`id_film`) REFERENCES `films` (`id_film`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
