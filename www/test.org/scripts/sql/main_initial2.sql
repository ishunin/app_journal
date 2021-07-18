-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 25 2020 г., 21:41
-- Версия сервера: 8.0.21
-- Версия PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `main`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `ID` int NOT NULL,
  `id_rec` int NOT NULL,
  `id_user` int NOT NULL,
  `content` text NOT NULL,
  `importance` int NOT NULL,
  `keep` tinyint(1) DEFAULT NULL,
  `create_date` timestamp NOT NULL,
  `edit_date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `jobs`
--

CREATE TABLE `jobs` (
  `ID` int NOT NULL,
  `theme` text,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `id_user` int NOT NULL,
  `status` int NOT NULL,
  `importance` int NOT NULL,
  `keep` tinyint(1) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `edit_date` datetime NOT NULL,
  `type` int NOT NULL,
  `executor` int NOT NULL,
  `start_task` datetime NOT NULL,
  `end_task` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `list`
--

CREATE TABLE `list` (
  `ID` int NOT NULL,
  `id_rec` int NOT NULL,
  `id_shift` int NOT NULL,
  `jira_num` varchar(10) DEFAULT NULL,
  `content` text NOT NULL,
  `action` text,
  `id_user` int NOT NULL,
  `destination` varchar(60) DEFAULT NULL,
  `status` int NOT NULL,
  `importance` int NOT NULL,
  `keep` tinyint(1) DEFAULT NULL,
  `create_date` timestamp NOT NULL,
  `edit_date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `ID` int NOT NULL,
  `theme` text,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `id_user` int NOT NULL,
  `status` int NOT NULL,
  `importance` int NOT NULL,
  `keep` tinyint(1) DEFAULT NULL,
  `Create_date` datetime NOT NULL,
  `Edit_date` datetime NOT NULL,
  `type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `shift`
--

CREATE TABLE `shift` (
  `ID` int NOT NULL,
  `id_user` int NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shift`
--

INSERT INTO `shift` (`ID`, `id_user`, `status`, `create_date`, `end_date`) VALUES
(2, 1, 1, '2020-08-25 19:41:06', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID` int UNSIGNED NOT NULL,
  `users_login` varchar(30) NOT NULL,
  `users_password` varchar(32) NOT NULL,
  `users_hash` varchar(32) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `permissions` int NOT NULL,
  `deny` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `users_login`, `users_password`, `users_hash`, `first_name`, `last_name`, `permissions`, `deny`) VALUES
(2, 'n7701-00-020', 'admin', 'a4190f2f693b8d29ccbcc3c83fb996a3', 'Алексей', 'Марченко', 1, 0),
(3, 'n7701-00-421', 'admin', '8362bfd179e52280e9f2dcdb73785ded', 'Дмитрий', 'Ишунин', 1, 0),
(1, 'admin', 'admin', '6d0d6629f0e5cea5734ef421bfca5ca6', 'Администратор', 'Супер', 1, 0),
(4, 'n7701-00-195', 'admin', 'sd', 'Евгений', 'Погожин', 1, 0),
(5, 'n7701-00-465', 'admin', 'sd', 'Евгений', 'Марисов', 1, 0),
(6, 'n7701-00-465', 'admin', 'sd', 'Андрей', 'Пламенный', 1, 0),
(7, 'n7701-00-450', 'admin', 'asd', 'Артем', 'Безкоровальный', 1, 0),
(8, 'n7701-00-420', 'admin', 'asd', 'Рамиль', 'Габайдулин', 1, 0),
(9, 'n7701-00-048', 'admin', 'asd', 'Максим', 'Иванчук', 1, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `list`
--
ALTER TABLE `list`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `shift`
--
ALTER TABLE `shift`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
