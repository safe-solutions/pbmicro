-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 06 2016 г., 16:19
-- Версия сервера: 5.1.73
-- Версия PHP: 5.4.40

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `pretty`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `article` text NOT NULL,
  `url` varchar(128) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `category_id`, `title`, `article`, `url`, `time`, `views`) VALUES
(1, 1, 1, 'Заголовок 1', 'Пример статьи 1', 'article1.html', '2015-06-30 09:53:34', 32),
(2, 0, 1, 'Заголовок 2', 'Это статья 2', 'article2.html', '2015-06-30 09:53:44', 107),
(3, 0, 1, 'Статья 3', 'Содержание 3 статьи', 'article3.html', '2015-06-30 17:08:03', 4),
(4, 0, 1, 'Article 4', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed semper metus ut lorem tempor mollis. Sed enim elit, aliquet in sem et, imperdiet sodales metus. Morbi pulvinar, libero eu faucibus accumsan, arcu dolor molestie ante, non porta lorem nunc a turpis. Cras euismod risus posuere tortor ullamcorper pulvinar ut nec nisi. Cras orci enim, varius at condimentum sit amet, elementum vitae urna. Vestibulum lobortis dolor in leo tincidunt placerat. Duis efficitur nibh ut elementum interdum.\n\nPellentesque porta ante eu vehicula consectetur. Praesent sit amet enim ac purus auctor laoreet. Aenean et sapien fermentum, viverra eros sed, sagittis est. Aenean suscipit libero non molestie fringilla. Praesent in lorem venenatis, interdum purus ut, interdum augue. Sed tincidunt, nibh id posuere aliquet, ante magna porta sapien, et auctor ligula mi dapibus leo. Suspendisse a risus faucibus, fermentum mi vel, laoreet ante. Sed bibendum tortor sit amet nisi vestibulum porta. Cras efficitur porttitor nulla, sit amet fermentum mi mattis quis. Morbi at rhoncus leo. Vivamus tristique non erat id aliquam. Maecenas sed lobortis tortor.\n\nVivamus eu purus nec orci faucibus tincidunt. Donec eleifend tellus vitae dui consectetur, eget porta arcu laoreet. Sed at odio eros. Aliquam ultrices vel dolor vulputate fermentum. Nulla luctus nibh id arcu aliquam ornare. Proin elementum quis arcu quis suscipit. Sed metus massa, bibendum nec est non, ornare semper mauris. In varius lobortis metus non accumsan. Nullam egestas eros venenatis magna tempor tristique. Phasellus eu nisl aliquet, elementum eros sed, tempus justo. Integer in ligula placerat, sagittis eros a, congue neque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas faucibus maximus urna eget vulputate. ', 'article4.html', '2015-07-01 09:30:12', 1),
(5, 0, 2, 'Статья 5', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed semper metus ut lorem tempor mollis. Sed enim elit, aliquet in sem et, imperdiet sodales metus. Morbi pulvinar, libero eu faucibus accumsan, arcu dolor molestie ante, non porta lorem nunc a turpis. Cras euismod risus posuere tortor ullamcorper pulvinar ut nec nisi. Cras orci enim, varius at condimentum sit amet, elementum vitae urna. Vestibulum lobortis dolor in leo tincidunt placerat. Duis efficitur nibh ut elementum interdum.\n\nPellentesque porta ante eu vehicula consectetur. Praesent sit amet enim ac purus auctor laoreet. Aenean et sapien fermentum, viverra eros sed, sagittis est. Aenean suscipit libero non molestie fringilla. Praesent in lorem venenatis, interdum purus ut, interdum augue. Sed tincidunt, nibh id posuere aliquet, ante magna porta sapien, et auctor ligula mi dapibus leo. Suspendisse a risus faucibus, fermentum mi vel, laoreet ante. Sed bibendum tortor sit amet nisi vestibulum porta. Cras efficitur porttitor nulla, sit amet fermentum mi mattis quis. Morbi at rhoncus leo. Vivamus tristique non erat id aliquam. Maecenas sed lobortis tortor.\n\nVivamus eu purus nec orci faucibus tincidunt. Donec eleifend tellus vitae dui consectetur, eget porta arcu laoreet. Sed at odio eros. Aliquam ultrices vel dolor vulputate fermentum. Nulla luctus nibh id arcu aliquam ornare. Proin elementum quis arcu quis suscipit. Sed metus massa, bibendum nec est non, ornare semper mauris. In varius lobortis metus non accumsan. Nullam egestas eros venenatis magna tempor tristique. Phasellus eu nisl aliquet, elementum eros sed, tempus justo. Integer in ligula placerat, sagittis eros a, congue neque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas faucibus maximus urna eget vulputate. ', 'article5.html', '2015-07-01 09:30:25', 9),
(6, 0, 2, '6 статья', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed semper metus ut lorem tempor mollis. Sed enim elit, aliquet in sem et, imperdiet sodales metus. Morbi pulvinar, libero eu faucibus accumsan, arcu dolor molestie ante, non porta lorem nunc a turpis. Cras euismod risus posuere tortor ullamcorper pulvinar ut nec nisi. Cras orci enim, varius at condimentum sit amet, elementum vitae urna. Vestibulum lobortis dolor in leo tincidunt placerat. Duis efficitur nibh ut elementum interdum.\n\nPellentesque porta ante eu vehicula consectetur. Praesent sit amet enim ac purus auctor laoreet. Aenean et sapien fermentum, viverra eros sed, sagittis est. Aenean suscipit libero non molestie fringilla. Praesent in lorem venenatis, interdum purus ut, interdum augue. Sed tincidunt, nibh id posuere aliquet, ante magna porta sapien, et auctor ligula mi dapibus leo. Suspendisse a risus faucibus, fermentum mi vel, laoreet ante. Sed bibendum tortor sit amet nisi vestibulum porta. Cras efficitur porttitor nulla, sit amet fermentum mi mattis quis. Morbi at rhoncus leo. Vivamus tristique non erat id aliquam. Maecenas sed lobortis tortor.\n\nVivamus eu purus nec orci faucibus tincidunt. Donec eleifend tellus vitae dui consectetur, eget porta arcu laoreet. Sed at odio eros. Aliquam ultrices vel dolor vulputate fermentum. Nulla luctus nibh id arcu aliquam ornare. Proin elementum quis arcu quis suscipit. Sed metus massa, bibendum nec est non, ornare semper mauris. In varius lobortis metus non accumsan. Nullam egestas eros venenatis magna tempor tristique. Phasellus eu nisl aliquet, elementum eros sed, tempus justo. Integer in ligula placerat, sagittis eros a, congue neque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas faucibus maximus urna eget vulputate. ', 'article6.html', '2015-07-01 09:30:31', 2),
(7, 0, 2, '7-я статья', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed semper metus ut lorem tempor mollis. Sed enim elit, aliquet in sem et, imperdiet sodales metus. Morbi pulvinar, libero eu faucibus accumsan, arcu dolor molestie ante, non porta lorem nunc a turpis. Cras euismod risus posuere tortor ullamcorper pulvinar ut nec nisi. Cras orci enim, varius at condimentum sit amet, elementum vitae urna. Vestibulum lobortis dolor in leo tincidunt placerat. Duis efficitur nibh ut elementum interdum.\n\nPellentesque porta ante eu vehicula consectetur. Praesent sit amet enim ac purus auctor laoreet. Aenean et sapien fermentum, viverra eros sed, sagittis est. Aenean suscipit libero non molestie fringilla. Praesent in lorem venenatis, interdum purus ut, interdum augue. Sed tincidunt, nibh id posuere aliquet, ante magna porta sapien, et auctor ligula mi dapibus leo. Suspendisse a risus faucibus, fermentum mi vel, laoreet ante. Sed bibendum tortor sit amet nisi vestibulum porta. Cras efficitur porttitor nulla, sit amet fermentum mi mattis quis. Morbi at rhoncus leo. Vivamus tristique non erat id aliquam. Maecenas sed lobortis tortor.\n\nVivamus eu purus nec orci faucibus tincidunt. Donec eleifend tellus vitae dui consectetur, eget porta arcu laoreet. Sed at odio eros. Aliquam ultrices vel dolor vulputate fermentum. Nulla luctus nibh id arcu aliquam ornare. Proin elementum quis arcu quis suscipit. Sed metus massa, bibendum nec est non, ornare semper mauris. In varius lobortis metus non accumsan. Nullam egestas eros venenatis magna tempor tristique. Phasellus eu nisl aliquet, elementum eros sed, tempus justo. Integer in ligula placerat, sagittis eros a, congue neque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas faucibus maximus urna eget vulputate. ', 'article7.html', '2015-07-01 09:30:39', 228),
(8, 0, 1, '8-я статья', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed semper metus ut lorem tempor mollis. Sed enim elit, aliquet in sem et, imperdiet sodales metus. Morbi pulvinar, libero eu faucibus accumsan, arcu dolor molestie ante, non porta lorem nunc a turpis. Cras euismod risus posuere tortor ullamcorper pulvinar ut nec nisi. Cras orci enim, varius at condimentum sit amet, elementum vitae urna. Vestibulum lobortis dolor in leo tincidunt placerat. Duis efficitur nibh ut elementum interdum.\n\nPellentesque porta ante eu vehicula consectetur. Praesent sit amet enim ac purus auctor laoreet. Aenean et sapien fermentum, viverra eros sed, sagittis est. Aenean suscipit libero non molestie fringilla. Praesent in lorem venenatis, interdum purus ut, interdum augue. Sed tincidunt, nibh id posuere aliquet, ante magna porta sapien, et auctor ligula mi dapibus leo. Suspendisse a risus faucibus, fermentum mi vel, laoreet ante. Sed bibendum tortor sit amet nisi vestibulum porta. Cras efficitur porttitor nulla, sit amet fermentum mi mattis quis. Morbi at rhoncus leo. Vivamus tristique non erat id aliquam. Maecenas sed lobortis tortor.\n\nVivamus eu purus nec orci faucibus tincidunt. Donec eleifend tellus vitae dui consectetur, eget porta arcu laoreet. Sed at odio eros. Aliquam ultrices vel dolor vulputate fermentum. Nulla luctus nibh id arcu aliquam ornare. Proin elementum quis arcu quis suscipit. Sed metus massa, bibendum nec est non, ornare semper mauris. In varius lobortis metus non accumsan. Nullam egestas eros venenatis magna tempor tristique. Phasellus eu nisl aliquet, elementum eros sed, tempus justo. Integer in ligula placerat, sagittis eros a, congue neque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas faucibus maximus urna eget vulputate. ', 'article8.html', '2015-07-01 09:30:39', 1),
(9, 0, 1, '9-я статья', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed semper metus ut lorem tempor mollis. Sed enim elit, aliquet in sem et, imperdiet sodales metus. Morbi pulvinar, libero eu faucibus accumsan, arcu dolor molestie ante, non porta lorem nunc a turpis. Cras euismod risus posuere tortor ullamcorper pulvinar ut nec nisi. Cras orci enim, varius at condimentum sit amet, elementum vitae urna. Vestibulum lobortis dolor in leo tincidunt placerat. Duis efficitur nibh ut elementum interdum.\n\nPellentesque porta ante eu vehicula consectetur. Praesent sit amet enim ac purus auctor laoreet. Aenean et sapien fermentum, viverra eros sed, sagittis est. Aenean suscipit libero non molestie fringilla. Praesent in lorem venenatis, interdum purus ut, interdum augue. Sed tincidunt, nibh id posuere aliquet, ante magna porta sapien, et auctor ligula mi dapibus leo. Suspendisse a risus faucibus, fermentum mi vel, laoreet ante. Sed bibendum tortor sit amet nisi vestibulum porta. Cras efficitur porttitor nulla, sit amet fermentum mi mattis quis. Morbi at rhoncus leo. Vivamus tristique non erat id aliquam. Maecenas sed lobortis tortor.\n\nVivamus eu purus nec orci faucibus tincidunt. Donec eleifend tellus vitae dui consectetur, eget porta arcu laoreet. Sed at odio eros. Aliquam ultrices vel dolor vulputate fermentum. Nulla luctus nibh id arcu aliquam ornare. Proin elementum quis arcu quis suscipit. Sed metus massa, bibendum nec est non, ornare semper mauris. In varius lobortis metus non accumsan. Nullam egestas eros venenatis magna tempor tristique. Phasellus eu nisl aliquet, elementum eros sed, tempus justo. Integer in ligula placerat, sagittis eros a, congue neque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas faucibus maximus urna eget vulputate. ', 'article9.html', '2015-07-01 09:30:39', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `url`, `title`) VALUES
(1, 'osnovnoe', 'Основное'),
(2, 'prettybits', 'PrettyBits');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `title`) VALUES
(1, 1, 'Комментарий к первой статье'),
(2, 1, 'Комментарий к первой статье 2'),
(3, 7, 'Комментарий к седьмой статье'),
(4, 2, 'Комментарий ко второй статье'),
(5, 1, 'Комментарий'),
(6, 5, 'Комментарий к пятой статье');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
