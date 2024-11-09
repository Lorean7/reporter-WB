-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: mysql
-- Время создания: Ноя 09 2024 г., 12:12
-- Версия сервера: 8.4.3
-- Версия PHP: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `projectWB`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Reports`
--

CREATE TABLE `Reports` (
  `id` int NOT NULL,
  `date_create` date NOT NULL,
  `box_number` text NOT NULL,
  `product_count` int NOT NULL,
  `time_close` time NOT NULL,
  `worker` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Reports`
--

INSERT INTO `Reports` (`id`, `date_create`, `box_number`, `product_count`, `time_close`, `worker`, `comment`) VALUES
(227, '2024-11-10', '23', 23, '12:12:00', 'Liza 23', 'Liza test 23'),
(248, '2024-11-06', '1', 1, '00:00:00', 'Liza', 'Liza test'),
(257, '2024-11-10', '12', 13, '15:07:00', 'postman 2', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Reports`
--
ALTER TABLE `Reports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Reports`
--
ALTER TABLE `Reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
