-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Сен 22 2018 г., 12:56
-- Версия сервера: 5.7.22-cll-lve
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `crobrand_maktab`
--

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_banner`
--

CREATE TABLE `mktb_banner` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `position` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `images` text NOT NULL,
  `sort_number` int(11) NOT NULL,
  `name` text NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_brand`
--

CREATE TABLE `mktb_brand` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `images` text NOT NULL,
  `sort_number` int(11) NOT NULL,
  `name` text NOT NULL,
  `descr` text NOT NULL,
  `descr_full` text NOT NULL,
  `meta_t` text NOT NULL,
  `meta_d` text NOT NULL,
  `meta_k` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_category`
--

CREATE TABLE `mktb_category` (
  `id` int(11) NOT NULL,
  `parent_category_id` int(11) NOT NULL,
  `category_type_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `category_show_in` tinyint(2) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `images` text NOT NULL,
  `sort_number` int(11) NOT NULL,
  `name` text NOT NULL,
  `descr` text NOT NULL,
  `descr_full` text NOT NULL,
  `meta_t` text NOT NULL,
  `meta_d` text NOT NULL,
  `meta_k` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_category_name`
--

CREATE TABLE `mktb_category_name` (
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `lang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_category_search`
--

CREATE TABLE `mktb_category_search` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `search_text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_contact`
--

CREATE TABLE `mktb_contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` tinyint(2) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_file`
--

CREATE TABLE `mktb_file` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `sort_number` int(11) NOT NULL,
  `name` text NOT NULL,
  `mime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_file`
--

INSERT INTO `mktb_file` (`id`, `path`, `sort_number`, `name`, `mime`) VALUES
(11, 'common/file.jpg', 0, 'bg_home.jpg', 'image/jpeg');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_file_name`
--

CREATE TABLE `mktb_file_name` (
  `file_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `lang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_file_name`
--

INSERT INTO `mktb_file_name` (`file_id`, `name`, `lang_id`) VALUES
(11, '', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_filter`
--

CREATE TABLE `mktb_filter` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_filter_to_category`
--

CREATE TABLE `mktb_filter_to_category` (
  `filter_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_filter_to_product`
--

CREATE TABLE `mktb_filter_to_product` (
  `filter_value_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_filter_value`
--

CREATE TABLE `mktb_filter_value` (
  `id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `sort_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_group`
--

CREATE TABLE `mktb_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_year` smallint(4) NOT NULL,
  `end_year` smallint(4) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mktb_group`
--

INSERT INTO `mktb_group` (`id`, `name`, `start_year`, `end_year`, `status`, `created_at`, `updated_at`) VALUES
(1, 'А', 2017, 2028, 1, 1534588350, 1534589180),
(2, 'Б', 2017, 2028, 1, 1534588442, 1534589330),
(3, 'А', 2016, 2027, 1, 1534591092, 1534591092),
(4, 'А', 2006, 2017, 1, 1534591603, 1534591603),
(6, 'Б', 2016, 2027, 1, 1534591976, 1534591993),
(7, '1 A', 2018, 2029, 1, 1537527038, 1537527038);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_lang`
--

CREATE TABLE `mktb_lang` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lang_prefix` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `main` tinyint(1) NOT NULL,
  `sort_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_lang`
--

INSERT INTO `mktb_lang` (`id`, `name`, `lang_prefix`, `icon`, `status`, `main`, `sort_number`) VALUES
(1, 'Русский', 'ru', 'lang/ru.jpg', 1, 1, 1),
(2, 'English', 'en', 'lang/en.jpg', 0, 0, 3),
(3, 'Казахский', 'kz', 'lang/kz.jpg', 0, 0, 4),
(4, 'O\'zbek', 'uz', 'lang/uz.jpg', 0, 0, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_lesson`
--

CREATE TABLE `mktb_lesson` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `hometask` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mktb_lesson`
--

INSERT INTO `mktb_lesson` (`id`, `subject_id`, `group_id`, `teacher_id`, `start_time`, `end_time`, `hometask`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 11, 1536472801, 0, 'Упражнение 14, стр.10', 1535367039, 1536997130),
(2, 2, 3, 11, 1536404401, 0, 'Упражнение 15, стр.14', 1535367599, 1536997116),
(4, 1, 3, 11, 1536299101, 0, '', 1535373444, 1536997108),
(6, 1, 3, 11, 1536210001, 0, 'Упражнение 11, стр.8', 1535520182, 1536997077),
(7, 2, 6, 11, 1535903341, 0, '', 1535903352, 1535903352),
(8, 1, 1, 40, 1537525621, 0, '5 dars', 1537525700, 1537525700),
(9, 1, 3, 42, 1537526521, 0, '15 chi dars, 20 bet', 1537526563, 1537526563),
(10, 1, 3, 42, 1537526701, 0, 'gullar mavzusi', 1537526769, 1537526769);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_module`
--

CREATE TABLE `mktb_module` (
  `id` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `access` int(11) NOT NULL,
  `sort_order` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `show_menu` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_module`
--

INSERT INTO `mktb_module` (`id`, `alias`, `name`, `access`, `sort_order`, `status`, `show_menu`) VALUES
(1, 'category', 'Категории', 2, 10, 0, 0),
(2, 'product', 'Товары', 2, 20, 0, 0),
(3, 'page', 'Страницы', 1, 30, 1, 1),
(4, 'user', 'Пользователи', 2, 92, 1, 1),
(5, 'configuration', 'Настройки', 2, 301, 1, 0),
(6, 'blog', 'Блог', 3, 50, 0, 0),
(9, 'chapter', 'Главы', 3, 25, 0, 0),
(10, 'music', 'Песни', 3, 60, 0, 0),
(11, 'clip', 'Клипы', 3, 70, 0, 0),
(12, 'slider', 'Слайдер', 2, 100, 1, 0),
(13, 'lexicon', 'Словарь', 3, 90, 0, 0),
(14, 'illustrationbook', 'Иллюстрации', 3, 95, 0, 0),
(15, 'symphony', 'Симфония', 3, 85, 0, 0),
(16, 'news', 'Новости', 3, 51, 0, 0),
(17, 'project', 'Проекты', 3, 10, 0, 0),
(18, 'gallery', 'Галерея', 3, 80, 1, 0),
(19, 'language', 'Языки', 1, 300, 1, 0),
(20, 'brand', 'Производители', 2, 25, 0, 0),
(21, 'order', 'Заказы', 3, 27, 0, 0),
(22, 'article', 'Статьи', 3, 52, 0, 0),
(23, 'event', 'События', 3, 50, 0, 0),
(24, 'menu_item', 'Меню', 2, 40, 0, 0),
(25, 'home', 'Главная', 3, 0, 1, 0),
(26, 'usercontract', 'Контракты', 3, 60, 0, 0),
(27, 'stats', 'Статистика', 3, 80, 1, 0),
(28, 'filter', 'Фильтр', 3, 90, 0, 0),
(29, 'review', 'Отзывы', 3, 28, 0, 0),
(30, 'video', 'Видеоролики', 3, 55, 0, 0),
(31, 'banner', 'Баннеры', 3, 60, 0, 0),
(32, 'contact', 'Контакты', 3, 60, 1, 0),
(33, 'teacher', 'Учители', 3, 90, 1, 1),
(34, 'student', 'Студенты', 3, 91, 1, 1),
(35, 'group', 'Группы', 3, 80, 1, 1),
(36, 'subject', 'Предметы', 3, 81, 1, 1),
(37, 'study-period', 'Учебные периоды', 3, 83, 1, 1),
(38, 'user-request', 'Запросы', 3, 95, 1, 1),
(39, 'lesson', 'Уроки', 3, 85, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_module_to_usergroup`
--

CREATE TABLE `mktb_module_to_usergroup` (
  `module_id` int(11) NOT NULL,
  `usergroup_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_option`
--

CREATE TABLE `mktb_option` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `comment` varchar(255) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_option`
--

INSERT INTO `mktb_option` (`id`, `name`, `content`, `comment`, `visible`) VALUES
(1, 'default_controller', 'home', 'Страница по умолчанию', 0),
(2, 'default_action', 'index', 'Функция по умолчанию', 0),
(3, 'theme', 'maktab', 'Тема', 1),
(4, 'theme_admin', 'default', '', 0),
(5, 'phone1', '+998 00 006 1881', 'Телефон 1', 1),
(6, 'phone2', '+998 01 006 1881', 'Телефон 2', 1),
(7, 'fax', '123', 'Факс', 1),
(8, 'contact_mail', 'info@domain.uz', 'Контактный e-mail', 1),
(9, 'address', 'г. Ташкент, ул. Шота Руставели, 1', 'Адрес', 1),
(10, 'contact_name', 'Админ', 'Контактное лицо', 1),
(11, 'maintainance', '0', 'Режим обслуживания', 0),
(12, 'robot_mail', 'no-reply@domain.uz', 'E-mail робота', 1),
(13, 'robot_name', 'Robot', 'Имя робота', 0),
(14, 'supplier', 'OOO &quot;Maktab&quot;', 'Название фирмы', 1),
(15, 'mfo', '01234', 'МФО', 1),
(16, 'inn', '123456789', 'ИНН', 1),
(17, 'okonx', '12345', 'ОКОНХ', 1),
(18, 'checking_account', '1234567890123456', 'Расчетный счет', 1),
(19, 'bank_name', 'ЧАББ ОПЕРУ &quot;Траст Банк&quot;', 'Банк', 1),
(20, 'chief_director', '1', 'Руководитель', 1),
(21, 'chief_accountant', '1', 'Гл. бухгалтер', 1),
(22, 'icon_small_w', '120', 'Ширина маленькой иконки (px)', 1),
(23, 'icon_small_h', '76', 'Высота маленькой иконки (px)', 1),
(24, 'icon_medium_w', '300', 'Ширина средней иконки (px)', 1),
(25, 'icon_medium_h', '190', 'Высота средней иконки (px)', 1),
(26, 'store_name', 'Maktab', 'Название магазина', 1),
(27, 'icon_product_w', '300', 'Ширина иконки на стр товара', 1),
(28, 'icon_product_h', '190', 'Высота иконки на стр товара', 1),
(29, 'icon_category_h', '300', 'Высота иконки категории (px)', 1),
(30, 'icon_category_w', '407', 'Ширина иконки категории (px)', 1),
(31, 'icon_large_w', '920', 'Ширина большой иконки (px)', 1),
(32, 'icon_large_h', '452', 'Высота большой иконки (px)', 1),
(33, 'exchange', '1', 'Курс у.е.', 1),
(34, 'currency', 'rub', 'Валюта магазина', 1),
(35, 'icon_product_large_h', '620', 'Высота большой иконки товара', 1),
(36, 'icon_product_large_w', '620', 'Ширина большой иконки товара', 1),
(37, 'phone3', '+998 02 006 1881', 'Телефон 3', 1),
(38, 'icon_brand_w', '200', 'Ширина логотипа бренда', 1),
(39, 'icon_brand_h', '80', 'Высота логотипа бренда', 1),
(40, 'SOCIAL_TWITTER', '#', 'Ссылка Twitter', 1),
(41, 'SOCIAL_FACEBOOK', '#', 'Ссылка Facebook', 1),
(42, 'SOCIAL_VKONTAKTE', '#', 'Ссылка Vkontakte', 1),
(43, 'SOCIAL_ODNOKLASSNIKI', '#', 'Ссылка Odnoklassniki', 1),
(44, 'SOCIAL_YOUTUBE', '#', 'Ссылка Youtube', 1),
(45, 'icon_product_small_w', '194', 'Ширина маленькой иконки товара', 1),
(46, 'icon_product_small_h', '129', 'Высота маленькой иконки товара', 1),
(47, 'counters', '', 'Счетчики', 1),
(48, 'price_decimals', '2', 'Десятичных знаков цены', 1),
(49, 'price_decimal_separator', ',', 'Разделитель десятичных знаков', 1),
(50, 'price_thousand_separator', 'NULL', 'Разделитель тысячных знаков', 1),
(51, 'google_maps_api_key', '1', 'Ключ для карт Google', 1),
(52, 'map_lat', '1', 'Координаты карты (широта)', 1),
(53, 'map_lng', '1', 'Координаты карты (долгота)', 1),
(54, 'study_start_month', '9', 'Месяц начало учёбы', 1),
(55, 'school_schedule_file', 'schedule19110.jpg', 'Файл расписания школы', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_order`
--

CREATE TABLE `mktb_order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `new` tinyint(1) NOT NULL,
  `items` text NOT NULL,
  `stock_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `fio` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `dover` varchar(255) NOT NULL,
  `dover_date` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `last_stock_change` varchar(255) NOT NULL,
  `last_balance_change` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_order_change`
--

CREATE TABLE `mktb_order_change` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `new_status` tinyint(2) NOT NULL,
  `date` int(11) NOT NULL,
  `comment` varchar(2000) NOT NULL,
  `customer_notified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_page`
--

CREATE TABLE `mktb_page` (
  `id` int(11) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `side` varchar(255) NOT NULL,
  `layout` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `text_name` text NOT NULL,
  `nav_name` text NOT NULL,
  `descr` text NOT NULL,
  `descr_full` text NOT NULL,
  `meta_t` text NOT NULL,
  `meta_d` text NOT NULL,
  `meta_k` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_page`
--

INSERT INTO `mktb_page` (`id`, `controller`, `method`, `side`, `layout`, `status`, `alias`, `name`, `text_name`, `nav_name`, `descr`, `descr_full`, `meta_t`, `meta_d`, `meta_k`) VALUES
(1, 'home', 'index', 'front', 'default', 1, '', '{\"1\":\"Maktab\"}', '{\"1\":\"Maktab\"}', '{\"1\":\"Главная\"}', '{\"1\":\"\"}', '{\"1\":\"&lt;p&gt;Maktab&lt;\\/p&gt;\"}', '{\"1\":\"\"}', '{\"1\":\"\"}', '{\"1\":\"\"}'),
(21, 'contact', 'index', 'front', 'default', 1, 'contact', '{\"1\":\"Контакты\"}', '{\"1\":\"Связаться с нами\"}', '{\"1\":\"Контакты\"}', '{\"1\":\"\"}', '{\"1\":\"\"}', '{\"1\":\"\"}', '{\"1\":\"\"}', '{\"1\":\"\"}'),
(24, 'information', 'view', 'front', 'default', 1, 'rules.html', '{\"1\":\"Пользовательское соглашение\"}', '{\"1\":\"Пользовательское соглашение\"}', '{\"1\":\"Пользовательское соглашение\"}', '{\"1\":\"\"}', '{\"1\":\"&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati fuga itaque debitis dolorum veritatis deserunt sit illum rerum fugit voluptatem, at odio, reprehenderit, dolores deleniti dignissimos qui dolor repudiandae ullam.&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Praesentium modi voluptatibus velit excepturi qui reprehenderit rerum, totam, nesciunt, obcaecati neque quos quisquam! Ab molestiae qui veniam voluptatem deleniti in inventore, maxime itaque cumque recusandae odit nisi ut. Repellat!&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Qui molestias culpa ipsam rem, saepe. Inventore aliquam ab ducimus accusamus reiciendis saepe quidem nisi aliquid earum maiores voluptatum repellat dolore sequi magnam, labore dolorum placeat enim suscipit laborum veniam.&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Fuga incidunt neque distinctio aliquid ut, ipsam officiis deleniti magni eveniet est dolor quam ab id, atque doloremque eos repudiandae architecto possimus minima nulla ea labore consequatur maxime cum. Dolores.&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Sapiente harum rem reprehenderit ex accusamus, vero ducimus. Accusantium ullam quia, et id nam tempora nulla recusandae eligendi minima perspiciatis nostrum, numquam molestias, repellat fuga distinctio autem, consequatur dolorem. Iste.&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Odio molestiae harum aperiam officiis hic, at assumenda, incidunt iusto est totam commodi quidem perspiciatis dolorum ab ducimus recusandae eius doloribus! Molestias quasi ea suscipit, perspiciatis numquam quos itaque obcaecati.&lt;\\/p&gt;\"}', '{\"1\":\"\"}', '{\"1\":\"\"}', '{\"1\":\"\"}');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_page_module`
--

CREATE TABLE `mktb_page_module` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `side` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_post`
--

CREATE TABLE `mktb_post` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `type` tinyint(3) NOT NULL,
  `image` varchar(255) NOT NULL,
  `images` text NOT NULL,
  `video_code` varchar(5000) NOT NULL,
  `sort_number` int(11) NOT NULL,
  `name` text NOT NULL,
  `descr` text NOT NULL,
  `descr_full` text NOT NULL,
  `date` varchar(255) NOT NULL,
  `date_add` int(11) NOT NULL,
  `date_modify` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `meta_t` text NOT NULL,
  `meta_d` text NOT NULL,
  `meta_k` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_product`
--

CREATE TABLE `mktb_product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category_type_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `images` text NOT NULL,
  `images_gallery` text NOT NULL,
  `videos` text NOT NULL,
  `up_sells` text NOT NULL,
  `cross_sells` text NOT NULL,
  `options` text NOT NULL,
  `sort_number` int(11) NOT NULL,
  `video_code` varchar(5000) NOT NULL,
  `price_orig` decimal(11,2) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `discount` tinyint(3) NOT NULL,
  `excise` decimal(11,2) NOT NULL,
  `nds` int(11) NOT NULL,
  `unit_in_block` int(11) NOT NULL,
  `unit_in_dal` int(11) NOT NULL,
  `stock_1` bigint(15) NOT NULL,
  `stock_2` bigint(15) NOT NULL,
  `stock_3` bigint(15) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `project_use` tinyint(2) NOT NULL,
  `project_life_style` tinyint(2) NOT NULL,
  `name` text NOT NULL,
  `descr` text NOT NULL,
  `descr_full` text NOT NULL,
  `specifications` text NOT NULL,
  `meta_t` text NOT NULL,
  `meta_d` text NOT NULL,
  `meta_k` text NOT NULL,
  `date_add` int(11) NOT NULL,
  `date_modify` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  `request_product` tinyint(1) NOT NULL DEFAULT '0',
  `recommended` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_product_name`
--

CREATE TABLE `mktb_product_name` (
  `product_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `lang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_product_option`
--

CREATE TABLE `mktb_product_option` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_product_option_to_product`
--

CREATE TABLE `mktb_product_option_to_product` (
  `product_option_value_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_product_option_value`
--

CREATE TABLE `mktb_product_option_value` (
  `id` int(11) NOT NULL,
  `product_option_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `file_id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_product_search`
--

CREATE TABLE `mktb_product_search` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `search_text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_review`
--

CREATE TABLE `mktb_review` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `date_add` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `new` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_slider`
--

CREATE TABLE `mktb_slider` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_number` int(11) NOT NULL,
  `name` text NOT NULL,
  `url` text NOT NULL,
  `descr_full` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_student_attendance`
--

CREATE TABLE `mktb_student_attendance` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `attended` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mktb_student_attendance`
--

INSERT INTO `mktb_student_attendance` (`id`, `lesson_id`, `student_id`, `attended`) VALUES
(4, 2, 13, 1),
(5, 2, 14, 1),
(6, 2, 25, 1),
(10, 4, 13, 1),
(11, 4, 14, 1),
(12, 4, 25, 1),
(22, 1, 13, 1),
(23, 1, 14, 1),
(24, 1, 25, 0),
(25, 6, 13, 1),
(26, 6, 14, 1),
(27, 6, 25, 1),
(28, 7, 27, 1),
(29, 8, 26, 1),
(30, 9, 13, 1),
(31, 9, 14, 0),
(32, 9, 25, 0),
(33, 9, 31, 0),
(34, 10, 13, 1),
(35, 10, 14, 0),
(36, 10, 25, 1),
(37, 10, 31, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_student_mark`
--

CREATE TABLE `mktb_student_mark` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `mark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mktb_student_mark`
--

INSERT INTO `mktb_student_mark` (`id`, `lesson_id`, `student_id`, `mark`) VALUES
(4, 2, 13, '4'),
(5, 2, 14, '4'),
(6, 2, 25, '5'),
(10, 4, 13, '5'),
(11, 4, 14, '5'),
(12, 4, 25, '5'),
(22, 1, 13, '3'),
(23, 1, 14, '5'),
(24, 1, 25, '0'),
(25, 6, 13, '5'),
(26, 6, 14, '4'),
(27, 6, 25, '3'),
(28, 7, 27, '5'),
(29, 8, 26, '5'),
(30, 9, 13, '5'),
(31, 9, 14, '0'),
(32, 9, 25, '0'),
(33, 9, 31, '0'),
(34, 10, 13, '2'),
(35, 10, 14, '0'),
(36, 10, 25, '5'),
(37, 10, 31, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_student_to_group`
--

CREATE TABLE `mktb_student_to_group` (
  `student_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mktb_student_to_group`
--

INSERT INTO `mktb_student_to_group` (`student_id`, `group_id`) VALUES
(13, 3),
(14, 3),
(25, 3),
(26, 1),
(27, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_student_to_user`
--

CREATE TABLE `mktb_student_to_user` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mktb_student_to_user`
--

INSERT INTO `mktb_student_to_user` (`student_id`, `user_id`) VALUES
(13, 39),
(13, 41),
(26, 39),
(27, 38);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_study_period`
--

CREATE TABLE `mktb_study_period` (
  `id` int(11) NOT NULL,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_year` smallint(4) NOT NULL,
  `end_year` smallint(4) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mktb_study_period`
--

INSERT INTO `mktb_study_period` (`id`, `period`, `start_year`, `end_year`, `start_time`, `end_time`, `status`) VALUES
(1, '1', 2018, 2019, 1535742000, 1541012399, 1),
(2, '2', 2018, 2019, 1541012401, 1546196401, 1),
(3, '3', 2018, 2019, 1546282801, 1553972401, 1),
(4, '4', 2018, 2019, 1554058801, 1567191601, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_subject`
--

CREATE TABLE `mktb_subject` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mktb_subject`
--

INSERT INTO `mktb_subject` (`id`, `name`, `status`) VALUES
(1, 'Алгебра', 1),
(2, 'Геометрия', 1),
(3, 'Физика', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_subject_to_teacher`
--

CREATE TABLE `mktb_subject_to_teacher` (
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mktb_subject_to_teacher`
--

INSERT INTO `mktb_subject_to_teacher` (`subject_id`, `teacher_id`) VALUES
(1, 40),
(1, 42),
(2, 40),
(2, 42),
(3, 40);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_subscribe`
--

CREATE TABLE `mktb_subscribe` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscribe` tinyint(1) NOT NULL,
  `type` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_subscribe`
--

INSERT INTO `mktb_subscribe` (`id`, `email`, `subscribe`, `type`) VALUES
(1, 'test@test.com', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tag`
--

CREATE TABLE `mktb_tag` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `lang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tag_to_product`
--

CREATE TABLE `mktb_tag_to_product` (
  `tag_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_teacher_to_group`
--

CREATE TABLE `mktb_teacher_to_group` (
  `teacher_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mktb_teacher_to_group`
--

INSERT INTO `mktb_teacher_to_group` (`teacher_id`, `group_id`) VALUES
(40, 1),
(40, 2),
(42, 2),
(42, 3),
(42, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_api_token`
--

CREATE TABLE `mktb_tgbot_api_token` (
  `id` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `counter` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_botan_shortener`
--

CREATE TABLE `mktb_tgbot_botan_shortener` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Unique identifier for this entry',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `url` text NOT NULL COMMENT 'Original URL',
  `short_url` char(255) NOT NULL DEFAULT '' COMMENT 'Shortened URL',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_callback_query`
--

CREATE TABLE `mktb_tgbot_callback_query` (
  `id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Unique identifier for this query',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `chat_id` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier',
  `message_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Unique message identifier',
  `inline_message_id` char(255) DEFAULT NULL COMMENT 'Identifier of the message sent via the bot in inline mode, that originated the query',
  `data` char(255) NOT NULL DEFAULT '' COMMENT 'Data associated with the callback button',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_tgbot_callback_query`
--

INSERT INTO `mktb_tgbot_callback_query` (`id`, `user_id`, `chat_id`, `message_id`, `inline_message_id`, `data`, `created_at`) VALUES
(47760109454604512, 11120017, 11120017, 1254, NULL, 'mychildren_group_id_2', '2018-09-22 09:11:25'),
(47760109891395381, 11120017, 11120017, 952, NULL, 'mychildren_group_id_6', '2018-09-17 14:24:37'),
(47760110050686714, 11120017, 11120017, 954, NULL, 'mychildren_add_student_id_13', '2018-09-17 14:24:48'),
(47760110429534463, 11120017, 11120017, 952, NULL, 'mychildren_group_id_3', '2018-09-17 14:24:39'),
(47760110995474518, 11120017, 11120017, 1251, NULL, 'mychildren_view_lessons_27_2', '2018-09-22 09:10:22'),
(47760111885069746, 11120017, 11120017, 1256, NULL, 'mychildren_add_student_id_13', '2018-09-22 09:11:32'),
(47760112490378856, 11120017, 11120017, 1075, NULL, 'mychildren_group_id_6', '2018-09-18 12:32:25'),
(47760112753918303, 11120017, 11120017, 1254, NULL, 'mychildren_group_id_3', '2018-09-22 09:11:29'),
(47760113449259445, 11120017, 11120017, 1076, NULL, 'mychildren_add_student_id_27', '2018-09-18 12:32:27'),
(47760113482159183, 11120017, 11120017, 1133, NULL, 'mychildren_group_id_3', '2018-09-21 13:15:21'),
(47760113529054858, 11120017, 11120017, 1250, NULL, 'mychildren_view_student_id_27', '2018-09-22 09:10:18'),
(192200744296022316, 44750223, 44750223, 1123, NULL, 'mychildren_group_id_1', '2018-09-21 13:06:53'),
(192200745513811338, 44750223, 44750223, 1137, NULL, 'mychildren_view_student_id_13', '2018-09-21 13:15:36'),
(192200745596093688, 44750223, 44750223, 1156, NULL, 'mychildren_view_student_id_13', '2018-09-21 13:16:38'),
(192200746140874778, 44750223, 44750223, 1128, NULL, 'mychildren_add_student_id_13', '2018-09-21 13:14:45'),
(192200746187145731, 44750223, 44750223, 1123, NULL, 'mychildren_group_id_2', '2018-09-21 13:08:27'),
(192200746764989970, 44750223, 44750223, 1123, NULL, 'mychildren_group_id_3', '2018-09-21 13:14:37'),
(192200747071524640, 44750223, 44750223, 1157, NULL, 'mychildren_view_lessons_13_2', '2018-09-21 13:16:42'),
(192200747072189110, 44750223, 44750223, 1123, NULL, 'mychildren_group_id_5', '2018-09-21 13:06:39'),
(192200747184440826, 44750223, 44750223, 1174, NULL, 'mychildren_view_lessons_26_1', '2018-09-21 13:29:03'),
(192200747446885695, 44750223, 44750223, 1140, NULL, 'mychildren_view_lessons_13_1', '2018-09-21 13:15:40'),
(192200748106140452, 44750223, 44750223, 1171, NULL, 'mychildren_view_student_id_26', '2018-09-21 13:28:47'),
(192200748235015553, 44750223, 44750223, 1125, NULL, 'mychildren_add_student_id_26', '2018-09-21 13:06:58'),
(1384169377249939841, 322277047, 322277047, 1213, NULL, 'mychildren_view_student_id_13', '2018-09-21 13:43:12'),
(1384169377562257785, 322277047, 322277047, 1201, NULL, 'mychildren_group_id_3', '2018-09-21 13:37:42'),
(1384169377871953373, 322277047, 322277047, 1209, NULL, 'mychildren_add_student_id_13', '2018-09-21 13:43:01'),
(1384169377880352095, 322277047, 322277047, 1218, NULL, 'mychildren_view_student_id_13', '2018-09-21 14:21:02'),
(1384169378265056532, 322277047, 322277047, 1207, NULL, 'mychildren_view_lessons_13_1', '2018-09-21 13:38:47'),
(1384169379301554378, 322277047, 322277047, 1214, NULL, 'mychildren_view_lessons_13_1', '2018-09-21 13:43:14'),
(1384169379934262267, 322277047, 322277047, 1263, NULL, 'mychildren_view_lessons_13_1', '2018-09-22 11:15:16'),
(1384169380157782540, 322277047, 322277047, 1201, NULL, 'mychildren_group_id_3', '2018-09-21 13:41:09'),
(1384169380197196120, 322277047, 322277047, 1225, NULL, 'mychildren_add_student_id_13', '2018-09-21 14:22:07'),
(1384169380398224321, 322277047, 322277047, 1206, NULL, 'mychildren_view_student_id_13', '2018-09-21 13:38:42'),
(1384169380398592159, 322277047, 322277047, 1202, NULL, 'mychildren_add_student_id_13', '2018-09-21 13:37:46'),
(1384169380478262418, 322277047, 322277047, 1222, NULL, 'mychildren_group_id_2', '2018-09-21 14:21:27'),
(1384169380778506732, 322277047, 322277047, 1222, NULL, 'mychildren_group_id_3', '2018-09-21 14:21:27'),
(1384169380853332804, 322277047, 322277047, 1262, NULL, 'mychildren_view_student_id_13', '2018-09-22 11:15:11');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_chat`
--

CREATE TABLE `mktb_tgbot_chat` (
  `id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Unique user or chat identifier',
  `type` enum('private','group','supergroup','channel') NOT NULL COMMENT 'Chat type, either private, group, supergroup or channel',
  `title` char(255) DEFAULT '' COMMENT 'Chat (group) title, is null if chat type is private',
  `username` char(255) DEFAULT NULL COMMENT 'Username, for private chats, supergroups and channels if available',
  `all_members_are_administrators` tinyint(1) DEFAULT '0' COMMENT 'True if a all members of this group are admins',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date update',
  `old_id` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier, this is filled when a group is converted to a supergroup'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_tgbot_chat`
--

INSERT INTO `mktb_tgbot_chat` (`id`, `type`, `title`, `username`, `all_members_are_administrators`, `created_at`, `updated_at`, `old_id`) VALUES
(11120017, 'private', NULL, 'smartweb_uz', NULL, '2018-09-17 13:20:42', '2018-09-22 13:53:28', NULL),
(44750223, 'private', NULL, 'ELFIYSAR', NULL, '2018-09-17 16:49:11', '2018-09-21 13:30:53', NULL),
(51161476, 'private', NULL, 'intromax', NULL, '2018-09-18 06:57:23', '2018-09-18 06:58:10', NULL),
(87703754, 'private', NULL, 'interintellect', NULL, '2018-09-15 17:10:39', '2018-09-21 13:16:57', NULL),
(211654109, 'private', NULL, 'farruhkarimov', NULL, '2018-09-16 19:58:22', '2018-09-16 20:01:22', NULL),
(263488083, 'private', NULL, NULL, NULL, '2018-09-22 05:49:37', '2018-09-22 05:49:37', NULL),
(286558501, 'private', NULL, 'salamhotel', NULL, '2018-09-15 17:17:17', '2018-09-17 13:19:43', NULL),
(322277047, 'private', NULL, NULL, NULL, '2018-09-21 13:36:52', '2018-09-22 11:15:11', NULL),
(370140466, 'private', NULL, NULL, NULL, '2018-09-04 05:45:05', '2018-09-18 11:53:34', NULL),
(381717598, 'private', NULL, 'Internet_Marketing_SMM', NULL, '2018-09-15 17:21:38', '2018-09-15 17:21:53', NULL),
(691261462, 'private', NULL, NULL, NULL, '2018-09-07 21:35:49', '2018-09-07 21:35:49', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_chosen_inline_result`
--

CREATE TABLE `mktb_tgbot_chosen_inline_result` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Unique identifier for this entry',
  `result_id` char(255) NOT NULL DEFAULT '' COMMENT 'Identifier for this result',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `location` char(255) DEFAULT NULL COMMENT 'Location object, user''s location',
  `inline_message_id` char(255) DEFAULT NULL COMMENT 'Identifier of the sent inline message',
  `query` text NOT NULL COMMENT 'The query that was used to obtain the result',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_conversation`
--

CREATE TABLE `mktb_tgbot_conversation` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Unique identifier for this entry',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `chat_id` bigint(20) DEFAULT NULL COMMENT 'Unique user or chat identifier',
  `status` enum('active','cancelled','stopped') NOT NULL DEFAULT 'active' COMMENT 'Conversation state',
  `command` varchar(160) DEFAULT '' COMMENT 'Default command to execute',
  `notes` text COMMENT 'Data stored from command',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date update'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_tgbot_conversation`
--

INSERT INTO `mktb_tgbot_conversation` (`id`, `user_id`, `chat_id`, `status`, `command`, `notes`, `created_at`, `updated_at`) VALUES
(11, 211654109, 211654109, 'stopped', 'feedback', '{\"state\":0}', '2018-09-16 20:00:53', '2018-09-16 20:00:57'),
(12, 11120017, 11120017, 'stopped', 'feedback', '{\"state\":0,\"type\":\"\\u0416\\u0430\\u043b\\u043e\\u0431\\u044b\",\"name\":\"Ulugbek +998908081239\",\"message\":\"Ggch\"}', '2018-09-18 12:20:27', '2018-09-18 12:31:53'),
(13, 87703754, 87703754, 'active', 'feedback', '{\"state\":0}', '2018-09-21 13:16:57', '2018-09-21 13:16:57'),
(14, 44750223, 44750223, 'stopped', 'feedback', '{\"state\":0,\"type\":\"Takliflar\",\"name\":\"\\u0413\\u0423\\u041b\\u0411\\u0410\\u0425\\u041e\\u0420 \\u0411\\u0430\\u0445\\u0442\\u0438\\u044f\\u0440\\u043e\\u0432\\u043d\\u0430 +998934430204\",\"message\":\"\\u041f\\u043f\\u0432\\u043b\\u0432\\u0434\\u0430\\u043e\\u0447\\u0442\\u0432\"}', '2018-09-21 13:30:28', '2018-09-21 13:30:54');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_edited_message`
--

CREATE TABLE `mktb_tgbot_edited_message` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Unique identifier for this entry',
  `chat_id` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier',
  `message_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Unique message identifier',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `edit_date` timestamp NULL DEFAULT NULL COMMENT 'Date the message was edited in timestamp format',
  `text` text COMMENT 'For text messages, the actual UTF-8 text of the message max message length 4096 char utf8',
  `entities` text COMMENT 'For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text',
  `caption` text COMMENT 'For message with caption, the actual UTF-8 text of the caption'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_tgbot_edited_message`
--

INSERT INTO `mktb_tgbot_edited_message` (`id`, `chat_id`, `message_id`, `user_id`, `edit_date`, `text`, `entities`, `caption`) VALUES
(55, 11120017, 952, 588857334, '2018-09-17 14:24:39', 'Выберите класс', NULL, NULL),
(56, 44750223, 1123, 588857334, '2018-09-21 13:06:53', 'Выберите класс', NULL, NULL),
(57, 44750223, 1123, 588857334, '2018-09-21 13:08:27', 'Выберите класс', NULL, NULL),
(58, 44750223, 1123, 588857334, '2018-09-21 13:14:37', 'Выберите класс', NULL, NULL),
(59, 322277047, 1201, 588857334, '2018-09-21 13:41:09', 'Выберите класс', NULL, NULL),
(60, 322277047, 1222, 588857334, '2018-09-21 14:21:27', 'Выберите класс', NULL, NULL),
(61, 11120017, 1254, 588857334, '2018-09-22 09:11:29', 'Выберите класс', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_file`
--

CREATE TABLE `mktb_tgbot_file` (
  `id` int(11) NOT NULL,
  `file_id` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_information`
--

CREATE TABLE `mktb_tgbot_information` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `sort_number` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_inline_query`
--

CREATE TABLE `mktb_tgbot_inline_query` (
  `id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Unique identifier for this query',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `location` char(255) DEFAULT NULL COMMENT 'Location of the user',
  `query` text NOT NULL COMMENT 'Text of the query',
  `offset` char(255) DEFAULT NULL COMMENT 'Offset of the result',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_message`
--

CREATE TABLE `mktb_tgbot_message` (
  `chat_id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Unique chat identifier',
  `id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Unique message identifier',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier',
  `date` timestamp NULL DEFAULT NULL COMMENT 'Date the message was sent in timestamp format',
  `forward_from` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier, sender of the original message',
  `forward_from_chat` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier, chat the original message belongs to',
  `forward_from_message_id` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier of the original message in the channel',
  `forward_date` timestamp NULL DEFAULT NULL COMMENT 'date the original message was sent in timestamp format',
  `reply_to_chat` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier',
  `reply_to_message` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Message that this message is reply to',
  `text` text COMMENT 'For text messages, the actual UTF-8 text of the message max message length 4096 char utf8',
  `entities` text COMMENT 'For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text',
  `audio` text COMMENT 'Audio object. Message is an audio file, information about the file',
  `document` text COMMENT 'Document object. Message is a general file, information about the file',
  `photo` text COMMENT 'Array of PhotoSize objects. Message is a photo, available sizes of the photo',
  `sticker` text COMMENT 'Sticker object. Message is a sticker, information about the sticker',
  `video` text COMMENT 'Video object. Message is a video, information about the video',
  `voice` text COMMENT 'Voice Object. Message is a Voice, information about the Voice',
  `video_note` text COMMENT 'VoiceNote Object. Message is a Video Note, information about the Video Note',
  `contact` text COMMENT 'Contact object. Message is a shared contact, information about the contact',
  `location` text COMMENT 'Location object. Message is a shared location, information about the location',
  `venue` text COMMENT 'Venue object. Message is a Venue, information about the Venue',
  `caption` text COMMENT 'For message with caption, the actual UTF-8 text of the caption',
  `new_chat_members` text COMMENT 'List of unique user identifiers, new member(s) were added to the group, information about them (one of these members may be the bot itself)',
  `left_chat_member` bigint(20) DEFAULT NULL COMMENT 'Unique user identifier, a member was removed from the group, information about them (this member may be the bot itself)',
  `new_chat_title` char(255) DEFAULT NULL COMMENT 'A chat title was changed to this value',
  `new_chat_photo` text COMMENT 'Array of PhotoSize objects. A chat photo was change to this value',
  `delete_chat_photo` tinyint(1) DEFAULT '0' COMMENT 'Informs that the chat photo was deleted',
  `group_chat_created` tinyint(1) DEFAULT '0' COMMENT 'Informs that the group has been created',
  `supergroup_chat_created` tinyint(1) DEFAULT '0' COMMENT 'Informs that the supergroup has been created',
  `channel_chat_created` tinyint(1) DEFAULT '0' COMMENT 'Informs that the channel chat has been created',
  `migrate_to_chat_id` bigint(20) DEFAULT NULL COMMENT 'Migrate to chat identifier. The group has been migrated to a supergroup with the specified identifier',
  `migrate_from_chat_id` bigint(20) DEFAULT NULL COMMENT 'Migrate from chat identifier. The supergroup has been migrated from a group with the specified identifier',
  `pinned_message` text COMMENT 'Message object. Specified message was pinned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_tgbot_message`
--

INSERT INTO `mktb_tgbot_message` (`chat_id`, `id`, `user_id`, `date`, `forward_from`, `forward_from_chat`, `forward_from_message_id`, `forward_date`, `reply_to_chat`, `reply_to_message`, `text`, `entities`, `audio`, `document`, `photo`, `sticker`, `video`, `voice`, `video_note`, `contact`, `location`, `venue`, `caption`, `new_chat_members`, `left_chat_member`, `new_chat_title`, `new_chat_photo`, `delete_chat_photo`, `group_chat_created`, `supergroup_chat_created`, `channel_chat_created`, `migrate_to_chat_id`, `migrate_from_chat_id`, `pinned_message`) VALUES
(11120017, 926, 11120017, '2018-09-17 13:20:42', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 927, 588857334, '2018-09-17 13:20:46', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 928, 11120017, '2018-09-17 13:20:49', NULL, NULL, NULL, NULL, 11120017, 927, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"+998908081239\",\"first_name\":\"Ulugbek\",\"last_name\":\"Yusupxodjayev\",\"user_id\":11120017}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 931, 11120017, '2018-09-17 13:21:12', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 933, 11120017, '2018-09-17 13:21:14', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 935, 11120017, '2018-09-17 13:21:34', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 937, 11120017, '2018-09-17 13:21:37', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 939, 11120017, '2018-09-17 14:13:44', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 941, 11120017, '2018-09-17 14:22:25', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 943, 11120017, '2018-09-17 14:24:16', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 945, 11120017, '2018-09-17 14:24:25', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 947, 11120017, '2018-09-17 14:24:29', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 949, 11120017, '2018-09-17 14:24:30', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 951, 11120017, '2018-09-17 14:24:33', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 952, 588857334, '2018-09-17 14:24:34', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите класс', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 954, 588857334, '2018-09-17 14:24:40', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 995, 11120017, '2018-09-18 06:57:54', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1015, 11120017, '2018-09-18 12:11:03', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1017, 11120017, '2018-09-18 12:11:07', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1019, 11120017, '2018-09-18 12:11:09', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1021, 11120017, '2018-09-18 12:13:48', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1023, 11120017, '2018-09-18 12:20:09', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1025, 11120017, '2018-09-18 12:20:22', NULL, NULL, NULL, NULL, NULL, NULL, '/help', '[{\"offset\":0,\"length\":5,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1027, 11120017, '2018-09-18 12:20:27', NULL, NULL, NULL, NULL, NULL, NULL, '/feedback', '[{\"offset\":0,\"length\":9,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1029, 11120017, '2018-09-18 12:20:33', NULL, NULL, NULL, NULL, NULL, NULL, '/whoami', '[{\"offset\":0,\"length\":7,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1031, 11120017, '2018-09-18 12:20:47', NULL, NULL, NULL, NULL, NULL, NULL, '/others', '[{\"offset\":0,\"length\":7,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1033, 11120017, '2018-09-18 12:20:54', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1034, 588857334, '2018-09-18 12:20:54', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1035, 11120017, '2018-09-18 12:27:05', NULL, NULL, NULL, NULL, 11120017, 1034, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998908081239\",\"first_name\":\"Ulugbek\",\"last_name\":\"Yusupxodjayev\",\"user_id\":11120017}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1038, 11120017, '2018-09-18 12:30:43', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1039, 588857334, '2018-09-18 12:30:44', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1040, 11120017, '2018-09-18 12:30:46', NULL, NULL, NULL, NULL, 11120017, 1039, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998908081239\",\"first_name\":\"Ulugbek\",\"last_name\":\"Yusupxodjayev\",\"user_id\":11120017}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1043, 11120017, '2018-09-18 12:31:11', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1045, 11120017, '2018-09-18 12:31:14', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1047, 11120017, '2018-09-18 12:31:16', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1049, 11120017, '2018-09-18 12:31:21', NULL, NULL, NULL, NULL, NULL, NULL, '❌️ Удалить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1051, 11120017, '2018-09-18 12:31:24', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1053, 11120017, '2018-09-18 12:31:27', NULL, NULL, NULL, NULL, NULL, NULL, '? Контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1055, 11120017, '2018-09-18 12:31:30', NULL, NULL, NULL, NULL, NULL, NULL, '✏️ Обращение', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1057, 11120017, '2018-09-18 12:31:40', NULL, NULL, NULL, NULL, NULL, NULL, 'Жалобы', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1059, 11120017, '2018-09-18 12:31:42', NULL, NULL, NULL, NULL, NULL, NULL, 'Ulugbek +998908081239', '[{\"offset\":8,\"length\":13,\"type\":\"phone_number\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1061, 11120017, '2018-09-18 12:31:48', NULL, NULL, NULL, NULL, NULL, NULL, 'Ggch', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1063, 11120017, '2018-09-18 12:31:53', NULL, NULL, NULL, NULL, NULL, NULL, '✔️ Подтвердить', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1066, 11120017, '2018-09-18 12:32:00', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1068, 11120017, '2018-09-18 12:32:12', NULL, NULL, NULL, NULL, NULL, NULL, '? Tilni tanlash / Выбрать язык', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1070, 11120017, '2018-09-18 12:32:14', NULL, NULL, NULL, NULL, NULL, NULL, '?? O\'zbekcha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1072, 11120017, '2018-09-18 12:32:18', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? O\'quvchilarim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1074, 11120017, '2018-09-18 12:32:23', NULL, NULL, NULL, NULL, NULL, NULL, '?️ O\'quvchi qo\'shish', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1075, 588857334, '2018-09-18 12:32:24', NULL, NULL, NULL, NULL, NULL, NULL, 'Sinfni tanlang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1076, 588857334, '2018-09-18 12:32:26', NULL, NULL, NULL, NULL, NULL, NULL, 'O\'quvchini tanlang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1130, 11120017, '2018-09-21 13:15:08', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? O\'quvchilarim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1132, 11120017, '2018-09-21 13:15:10', NULL, NULL, NULL, NULL, NULL, NULL, '?️ O\'quvchi qo\'shish', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1133, 588857334, '2018-09-21 13:15:10', NULL, NULL, NULL, NULL, NULL, NULL, 'Sinfni tanlang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1138, 11120017, '2018-09-21 13:15:34', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? O\'quvchilarim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1142, 11120017, '2018-09-21 13:16:03', NULL, NULL, NULL, NULL, NULL, NULL, '? Bosh sahifa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1144, 11120017, '2018-09-21 13:16:13', NULL, NULL, NULL, NULL, NULL, NULL, '? Boshqa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1221, 11120017, '2018-09-21 14:21:15', NULL, NULL, NULL, NULL, NULL, NULL, '? Bosh sahifa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1238, 11120017, '2018-09-22 09:09:40', NULL, NULL, NULL, NULL, NULL, NULL, '? Boshqa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1240, 11120017, '2018-09-22 09:09:47', NULL, NULL, NULL, NULL, NULL, NULL, '? Tilni tanlash / Выбрать язык', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1242, 11120017, '2018-09-22 09:09:50', NULL, NULL, NULL, NULL, NULL, NULL, '?? Русский', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1244, 11120017, '2018-09-22 09:09:53', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1246, 11120017, '2018-09-22 09:10:11', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1248, 11120017, '2018-09-22 09:10:13', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1250, 588857334, '2018-09-22 09:10:16', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1251, 588857334, '2018-09-22 09:10:18', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите предмет', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1253, 11120017, '2018-09-22 09:10:54', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1254, 588857334, '2018-09-22 09:10:56', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите класс', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1256, 588857334, '2018-09-22 09:11:29', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1258, 11120017, '2018-09-22 09:11:36', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1265, 11120017, '2018-09-22 13:20:51', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1266, 11120017, '2018-09-22 13:29:25', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1267, 11120017, '2018-09-22 13:42:46', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1269, 11120017, '2018-09-22 13:42:50', NULL, NULL, NULL, NULL, NULL, NULL, 'button_school_schedule', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1270, 11120017, '2018-09-22 13:46:57', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1272, 11120017, '2018-09-22 13:46:59', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1274, 11120017, '2018-09-22 13:47:00', NULL, NULL, NULL, NULL, NULL, NULL, 'button_school_schedule', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1275, 11120017, '2018-09-22 13:48:34', NULL, NULL, NULL, NULL, NULL, NULL, 'button_school_schedule', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1276, 11120017, '2018-09-22 13:49:28', NULL, NULL, NULL, NULL, NULL, NULL, 'button_school_schedule', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1277, 11120017, '2018-09-22 13:52:19', NULL, NULL, NULL, NULL, NULL, NULL, 'button_school_schedule', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1278, 11120017, '2018-09-22 13:53:09', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1280, 11120017, '2018-09-22 13:53:12', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1282, 11120017, '2018-09-22 13:53:13', NULL, NULL, NULL, NULL, NULL, NULL, 'button_school_schedule', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1284, 11120017, '2018-09-22 13:53:26', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11120017, 1286, 11120017, '2018-09-22 13:53:28', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 956, 44750223, '2018-09-17 16:49:11', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 957, 588857334, '2018-09-17 16:49:13', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 958, 44750223, '2018-09-17 16:49:27', NULL, NULL, NULL, NULL, 44750223, 957, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998934430204\",\"first_name\":\"\\u0413\\u0423\\u041b\\u0411\\u0410\\u0425\\u041e\\u0420 \\u0411\\u0430\\u0445\\u0442\\u0438\\u044f\\u0440\\u043e\\u0432\\u043d\\u0430\",\"last_name\":\"\\u0410\\u0425\\u0418 \\u0410\\u0411\\u0414\\u0423\\u041a\\u0410\\u0420\\u0418\\u041c\\u041e\\u0412\\u0410\",\"user_id\":44750223}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 961, 44750223, '2018-09-17 16:50:00', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 963, 44750223, '2018-09-17 16:50:06', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 965, 44750223, '2018-09-17 16:50:14', NULL, NULL, NULL, NULL, NULL, NULL, 'Малика ф', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 966, 44750223, '2018-09-17 16:50:23', NULL, NULL, NULL, NULL, NULL, NULL, '❌️ Удалить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 967, 44750223, '2018-09-17 16:50:25', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 970, 44750223, '2018-09-17 16:50:32', NULL, NULL, NULL, NULL, NULL, NULL, '? Контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 972, 44750223, '2018-09-17 16:51:10', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 974, 44750223, '2018-09-17 16:51:23', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 976, 44750223, '2018-09-17 16:51:28', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 978, 44750223, '2018-09-17 16:51:30', NULL, NULL, NULL, NULL, NULL, NULL, '? Tilni tanlash / Выбрать язык', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 980, 44750223, '2018-09-17 16:51:34', NULL, NULL, NULL, NULL, NULL, NULL, '?? Русский', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 982, 44750223, '2018-09-17 16:51:37', NULL, NULL, NULL, NULL, NULL, NULL, '? Контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1108, 44750223, '2018-09-21 12:55:36', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1109, 588857334, '2018-09-21 12:55:37', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1110, 44750223, '2018-09-21 12:55:39', NULL, NULL, NULL, NULL, 44750223, 1109, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998934430204\",\"first_name\":\"\\u0413\\u0423\\u041b\\u0411\\u0410\\u0425\\u041e\\u0420 \\u0411\\u0430\\u0445\\u0442\\u0438\\u044f\\u0440\\u043e\\u0432\\u043d\\u0430\",\"last_name\":\"\\u0410\\u0425\\u0418 \\u0410\\u0411\\u0414\\u0423\\u041a\\u0410\\u0420\\u0418\\u041c\\u041e\\u0412\\u0410\",\"user_id\":44750223}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1118, 44750223, '2018-09-21 13:06:07', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1120, 44750223, '2018-09-21 13:06:14', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1121, 44750223, '2018-09-21 13:06:17', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1123, 588857334, '2018-09-21 13:06:22', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите класс', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1125, 588857334, '2018-09-21 13:06:54', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1128, 588857334, '2018-09-21 13:14:37', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1135, 44750223, '2018-09-21 13:15:27', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1137, 588857334, '2018-09-21 13:15:30', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1140, 588857334, '2018-09-21 13:15:36', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите предмет', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1146, 44750223, '2018-09-21 13:16:20', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1148, 44750223, '2018-09-21 13:16:23', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1150, 44750223, '2018-09-21 13:16:26', NULL, NULL, NULL, NULL, NULL, NULL, '? Tilni tanlash / Выбрать язык', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1152, 44750223, '2018-09-21 13:16:28', NULL, NULL, NULL, NULL, NULL, NULL, '?? O\'zbekcha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1154, 44750223, '2018-09-21 13:16:31', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? O\'quvchilarim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1156, 588857334, '2018-09-21 13:16:32', NULL, NULL, NULL, NULL, NULL, NULL, 'O\'quvchini tanlang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1157, 588857334, '2018-09-21 13:16:39', NULL, NULL, NULL, NULL, NULL, NULL, 'Fanni tanlang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1161, 44750223, '2018-09-21 13:19:35', NULL, NULL, NULL, NULL, NULL, NULL, '? Bosh sahifa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1163, 44750223, '2018-09-21 13:19:40', NULL, NULL, NULL, NULL, NULL, NULL, '? Aloqa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1165, 44750223, '2018-09-21 13:19:47', NULL, NULL, NULL, NULL, NULL, NULL, '? Boshqa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1167, 44750223, '2018-09-21 13:28:35', NULL, NULL, NULL, NULL, NULL, NULL, '? Bosh sahifa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1169, 44750223, '2018-09-21 13:28:40', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? O\'quvchilarim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1171, 588857334, '2018-09-21 13:28:41', NULL, NULL, NULL, NULL, NULL, NULL, 'O\'quvchini tanlang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1172, 44750223, '2018-09-21 13:28:44', NULL, NULL, NULL, NULL, NULL, NULL, '?️ O\'quvchi qo\'shish', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1174, 588857334, '2018-09-21 13:28:47', NULL, NULL, NULL, NULL, NULL, NULL, 'Fanni tanlang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1176, 44750223, '2018-09-21 13:29:45', NULL, NULL, NULL, NULL, NULL, NULL, '? Bosh sahifa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1178, 44750223, '2018-09-21 13:29:53', NULL, NULL, NULL, NULL, NULL, NULL, '? Boshqa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1180, 44750223, '2018-09-21 13:30:11', NULL, NULL, NULL, NULL, NULL, NULL, '? Bosh sahifa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1182, 44750223, '2018-09-21 13:30:28', NULL, NULL, NULL, NULL, NULL, NULL, '✏️ Murojaat', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1184, 44750223, '2018-09-21 13:30:32', NULL, NULL, NULL, NULL, NULL, NULL, 'Takliflar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1186, 44750223, '2018-09-21 13:30:40', NULL, NULL, NULL, NULL, NULL, NULL, 'ГУЛБАХОР Бахтияровна +998934430204', '[{\"offset\":21,\"length\":13,\"type\":\"phone_number\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1188, 44750223, '2018-09-21 13:30:48', NULL, NULL, NULL, NULL, NULL, NULL, 'Ппвлвдаочтв', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44750223, 1190, 44750223, '2018-09-21 13:30:53', NULL, NULL, NULL, NULL, NULL, NULL, '✔️ Tasdiqlash', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51161476, 984, 51161476, '2018-09-18 06:57:23', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51161476, 985, 588857334, '2018-09-18 06:57:24', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51161476, 986, 51161476, '2018-09-18 06:57:33', NULL, NULL, NULL, NULL, 51161476, 985, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"+998903263563\",\"first_name\":\"\\u041c\\u0430\\u043a\\u0441\\u0438\\u043c\",\"user_id\":51161476}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51161476, 989, 51161476, '2018-09-18 06:57:38', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51161476, 991, 51161476, '2018-09-18 06:57:40', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51161476, 993, 51161476, '2018-09-18 06:57:46', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51161476, 997, 51161476, '2018-09-18 06:58:01', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51161476, 999, 51161476, '2018-09-18 06:58:04', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51161476, 1001, 51161476, '2018-09-18 06:58:08', NULL, NULL, NULL, NULL, NULL, NULL, '❌️ Удалить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51161476, 1003, 51161476, '2018-09-18 06:58:10', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 746, 87703754, '2018-09-15 17:10:39', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 747, 588857334, '2018-09-15 17:10:43', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 748, 87703754, '2018-09-15 17:10:47', NULL, NULL, NULL, NULL, 87703754, 747, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"+998911660048\",\"first_name\":\"Umidjon\",\"user_id\":87703754}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 751, 87703754, '2018-09-15 17:10:56', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 753, 87703754, '2018-09-15 17:11:00', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 755, 87703754, '2018-09-15 17:11:25', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 757, 87703754, '2018-09-15 17:11:36', NULL, NULL, NULL, NULL, NULL, NULL, '❌️ Удалить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 758, 87703754, '2018-09-15 17:11:39', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 761, 87703754, '2018-09-15 17:11:59', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 763, 87703754, '2018-09-15 17:12:01', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 765, 87703754, '2018-09-15 17:12:06', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 782, 87703754, '2018-09-15 17:16:04', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 784, 87703754, '2018-09-15 17:16:19', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 786, 87703754, '2018-09-15 17:16:21', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1078, 87703754, '2018-09-21 12:53:17', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1079, 588857334, '2018-09-21 12:53:19', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1080, 87703754, '2018-09-21 12:53:23', NULL, NULL, NULL, NULL, 87703754, 1079, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998911660048\",\"first_name\":\"Umidjon\",\"user_id\":87703754}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1083, 87703754, '2018-09-21 12:53:29', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1084, 588857334, '2018-09-21 12:53:29', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1085, 87703754, '2018-09-21 12:53:33', NULL, NULL, NULL, NULL, 87703754, 1084, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998911660048\",\"first_name\":\"Umidjon\",\"user_id\":87703754}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1088, 87703754, '2018-09-21 12:53:39', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1089, 588857334, '2018-09-21 12:53:39', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1090, 87703754, '2018-09-21 12:53:42', NULL, NULL, NULL, NULL, 87703754, 1089, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998911660048\",\"first_name\":\"Umidjon\",\"user_id\":87703754}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1093, 87703754, '2018-09-21 12:53:46', NULL, NULL, NULL, NULL, NULL, NULL, '? Контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1095, 87703754, '2018-09-21 12:53:49', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1097, 87703754, '2018-09-21 12:53:54', NULL, NULL, NULL, NULL, NULL, NULL, '? Tilni tanlash / Выбрать язык', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1099, 87703754, '2018-09-21 12:53:57', NULL, NULL, NULL, NULL, NULL, NULL, '?? O\'zbekcha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1101, 87703754, '2018-09-21 12:54:00', NULL, NULL, NULL, NULL, NULL, NULL, '? Aloqa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1103, 87703754, '2018-09-21 12:54:02', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? O\'quvchilarim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1104, 588857334, '2018-09-21 12:54:03', NULL, NULL, NULL, NULL, NULL, NULL, 'Telefon raqamingizni yuboring', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1105, 87703754, '2018-09-21 12:54:58', NULL, NULL, NULL, NULL, 87703754, 1104, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998911660048\",\"first_name\":\"Umidjon\",\"user_id\":87703754}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1113, 87703754, '2018-09-21 13:05:48', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? O\'quvchilarim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1114, 588857334, '2018-09-21 13:05:52', NULL, NULL, NULL, NULL, NULL, NULL, 'Telefon raqamingizni yuboring', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1115, 87703754, '2018-09-21 13:05:55', NULL, NULL, NULL, NULL, 87703754, 1114, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998911660048\",\"first_name\":\"Umidjon\",\"user_id\":87703754}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87703754, 1159, 87703754, '2018-09-21 13:16:57', NULL, NULL, NULL, NULL, NULL, NULL, '✏️ Murojaat', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 847, 211654109, '2018-09-16 19:58:22', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 848, 588857334, '2018-09-16 19:58:26', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 849, 211654109, '2018-09-16 19:58:31', NULL, NULL, NULL, NULL, 211654109, 848, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998949343836\",\"first_name\":\"\\u0424\\u0430\\u0440\\u0440\\u0443\\u04b3\",\"user_id\":211654109}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 852, 211654109, '2018-09-16 19:58:46', NULL, NULL, NULL, NULL, NULL, NULL, '? Контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 854, 211654109, '2018-09-16 20:00:52', NULL, NULL, NULL, NULL, NULL, NULL, '✏️ Обращение', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 856, 211654109, '2018-09-16 20:00:57', NULL, NULL, NULL, NULL, NULL, NULL, '⬅️ Назад', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 858, 211654109, '2018-09-16 20:00:58', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 860, 211654109, '2018-09-16 20:01:04', NULL, NULL, NULL, NULL, NULL, NULL, '? Tilni tanlash / Выбрать язык', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 862, 211654109, '2018-09-16 20:01:05', NULL, NULL, NULL, NULL, NULL, NULL, '?? O\'zbekcha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 864, 211654109, '2018-09-16 20:01:10', NULL, NULL, NULL, NULL, NULL, NULL, '? Boshqa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 866, 211654109, '2018-09-16 20:01:14', NULL, NULL, NULL, NULL, NULL, NULL, '? Bosh sahifa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 868, 211654109, '2018-09-16 20:01:17', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? O\'quvchilarim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(211654109, 870, 211654109, '2018-09-16 20:01:22', NULL, NULL, NULL, NULL, NULL, NULL, '?️ O\'quvchi qo\'shish', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(263488083, 1237, 263488083, '2018-09-22 05:49:37', NULL, NULL, NULL, NULL, NULL, NULL, 'Нималар бор тугарак ишланмаси борми жисмоний тарбия фанидан стол тенниси буйича керак', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `mktb_tgbot_message` (`chat_id`, `id`, `user_id`, `date`, `forward_from`, `forward_from_chat`, `forward_from_message_id`, `forward_date`, `reply_to_chat`, `reply_to_message`, `text`, `entities`, `audio`, `document`, `photo`, `sticker`, `video`, `voice`, `video_note`, `contact`, `location`, `venue`, `caption`, `new_chat_members`, `left_chat_member`, `new_chat_title`, `new_chat_photo`, `delete_chat_photo`, `group_chat_created`, `supergroup_chat_created`, `channel_chat_created`, `migrate_to_chat_id`, `migrate_from_chat_id`, `pinned_message`) VALUES
(286558501, 793, 286558501, '2018-09-15 17:17:17', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(286558501, 794, 588857334, '2018-09-15 17:17:17', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(286558501, 795, 286558501, '2018-09-15 17:17:21', NULL, NULL, NULL, NULL, 286558501, 794, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998903261137\",\"first_name\":\"SalamHotel\",\"user_id\":286558501}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(286558501, 798, 286558501, '2018-09-15 17:17:27', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(286558501, 800, 286558501, '2018-09-15 17:17:29', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(286558501, 924, 286558501, '2018-09-17 13:19:43', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1193, 322277047, '2018-09-21 13:36:52', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1194, 588857334, '2018-09-21 13:36:53', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1195, 322277047, '2018-09-21 13:37:27', NULL, NULL, NULL, NULL, 322277047, 1194, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998916122080\",\"first_name\":\"Izzatillo\",\"last_name\":\"Ismoilov\",\"user_id\":322277047}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1198, 322277047, '2018-09-21 13:37:35', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1200, 322277047, '2018-09-21 13:37:39', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1201, 588857334, '2018-09-21 13:37:39', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите класс', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1202, 588857334, '2018-09-21 13:37:44', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1204, 322277047, '2018-09-21 13:38:35', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1206, 588857334, '2018-09-21 13:38:36', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1207, 588857334, '2018-09-21 13:38:43', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите предмет', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1209, 588857334, '2018-09-21 13:41:09', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1211, 322277047, '2018-09-21 13:43:08', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1213, 588857334, '2018-09-21 13:43:10', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1214, 588857334, '2018-09-21 13:43:12', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите предмет', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1216, 322277047, '2018-09-21 14:20:52', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1218, 588857334, '2018-09-21 14:20:54', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1220, 322277047, '2018-09-21 14:21:15', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1222, 588857334, '2018-09-21 14:21:16', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите класс', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1225, 588857334, '2018-09-21 14:21:28', NULL, NULL, NULL, NULL, NULL, NULL, 'Выберите ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1227, 322277047, '2018-09-21 14:22:16', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1229, 322277047, '2018-09-21 14:22:19', NULL, NULL, NULL, NULL, NULL, NULL, '? Контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1231, 322277047, '2018-09-21 14:22:31', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1233, 322277047, '2018-09-21 14:22:36', NULL, NULL, NULL, NULL, NULL, NULL, '? Tilni tanlash / Выбрать язык', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1235, 322277047, '2018-09-21 14:22:39', NULL, NULL, NULL, NULL, NULL, NULL, '?? O\'zbekcha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1260, 322277047, '2018-09-22 11:14:55', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? O\'quvchilarim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1262, 588857334, '2018-09-22 11:15:04', NULL, NULL, NULL, NULL, NULL, NULL, 'O\'quvchini tanlang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(322277047, 1263, 588857334, '2018-09-22 11:15:11', NULL, NULL, NULL, NULL, NULL, NULL, 'Fanni tanlang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370140466, 172, 370140466, '2018-09-03 23:15:03', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370140466, 173, 370140466, '2018-09-04 05:45:05', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370140466, 175, 588857334, '2018-09-04 05:45:32', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370140466, 176, 370140466, '2018-09-04 05:47:38', NULL, NULL, NULL, NULL, 370140466, 175, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"+998911667886\",\"first_name\":\"KLeoPaTRa\",\"last_name\":\"123\",\"user_id\":370140466}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370140466, 179, 370140466, '2018-09-04 05:49:07', NULL, NULL, NULL, NULL, NULL, NULL, '? Контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370140466, 1005, 370140466, '2018-09-18 11:52:21', NULL, NULL, NULL, NULL, NULL, NULL, '? Прочее', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370140466, 1007, 370140466, '2018-09-18 11:53:02', NULL, NULL, NULL, NULL, NULL, NULL, '? Главная', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370140466, 1009, 370140466, '2018-09-18 11:53:08', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370140466, 1011, 370140466, '2018-09-18 11:53:21', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(370140466, 1013, 370140466, '2018-09-18 11:53:34', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(381717598, 838, 381717598, '2018-09-15 17:21:38', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(381717598, 839, 588857334, '2018-09-15 17:21:41', NULL, NULL, NULL, NULL, NULL, NULL, 'Отправьте ваши контакты', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(381717598, 840, 381717598, '2018-09-15 17:21:44', NULL, NULL, NULL, NULL, 381717598, 839, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"phone_number\":\"998946453799\",\"first_name\":\"Bobur Kodirjonov\",\"user_id\":381717598}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(381717598, 843, 381717598, '2018-09-15 17:21:50', NULL, NULL, NULL, NULL, NULL, NULL, '?‍?‍? Мои ученики', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(381717598, 845, 381717598, '2018-09-15 17:21:53', NULL, NULL, NULL, NULL, NULL, NULL, '?️ Добавить ученика', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(691261462, 493, 691261462, '2018-09-07 21:35:49', NULL, NULL, NULL, NULL, NULL, NULL, '/start', '[{\"offset\":0,\"length\":6,\"type\":\"bot_command\"}]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_request_limiter`
--

CREATE TABLE `mktb_tgbot_request_limiter` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'Unique identifier for this entry',
  `chat_id` char(255) DEFAULT NULL COMMENT 'Unique chat identifier',
  `inline_message_id` char(255) DEFAULT NULL COMMENT 'Identifier of the sent inline message',
  `method` char(255) DEFAULT NULL COMMENT 'Request method',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_tgbot_request_limiter`
--

INSERT INTO `mktb_tgbot_request_limiter` (`id`, `chat_id`, `inline_message_id`, `method`, `created_at`) VALUES
(442, '286558501', NULL, 'sendMessage', '2018-09-17 13:19:46'),
(443, '11120017', NULL, 'sendMessage', '2018-09-17 13:20:43'),
(444, '11120017', NULL, 'sendMessage', '2018-09-17 13:20:49'),
(445, '11120017', NULL, 'sendMessage', '2018-09-17 13:20:50'),
(446, '11120017', NULL, 'sendMessage', '2018-09-17 13:21:13'),
(447, '11120017', NULL, 'sendMessage', '2018-09-17 13:21:14'),
(448, '11120017', NULL, 'sendMessage', '2018-09-17 13:21:34'),
(449, '11120017', NULL, 'sendMessage', '2018-09-17 13:21:37'),
(450, '11120017', NULL, 'sendMessage', '2018-09-17 14:13:47'),
(451, '11120017', NULL, 'sendMessage', '2018-09-17 14:22:25'),
(452, '11120017', NULL, 'sendMessage', '2018-09-17 14:24:23'),
(453, '11120017', NULL, 'sendMessage', '2018-09-17 14:24:25'),
(454, '11120017', NULL, 'sendMessage', '2018-09-17 14:24:29'),
(455, '11120017', NULL, 'sendMessage', '2018-09-17 14:24:30'),
(456, '11120017', NULL, 'sendMessage', '2018-09-17 14:24:33'),
(457, '11120017', NULL, 'sendMessage', '2018-09-17 14:24:37'),
(458, '11120017', NULL, 'sendMessage', '2018-09-17 14:24:39'),
(459, '11120017', NULL, 'sendMessage', '2018-09-17 14:24:48'),
(460, '44750223', NULL, 'sendMessage', '2018-09-17 16:49:13'),
(461, '44750223', NULL, 'sendMessage', '2018-09-17 16:49:27'),
(462, '44750223', NULL, 'sendMessage', '2018-09-17 16:49:28'),
(463, '44750223', NULL, 'sendMessage', '2018-09-17 16:50:01'),
(464, '44750223', NULL, 'sendMessage', '2018-09-17 16:50:06'),
(465, '44750223', NULL, 'sendMessage', '2018-09-17 16:50:25'),
(466, '44750223', NULL, 'sendMessage', '2018-09-17 16:50:26'),
(467, '44750223', NULL, 'sendMessage', '2018-09-17 16:50:32'),
(468, '44750223', NULL, 'sendMessage', '2018-09-17 16:51:11'),
(469, '44750223', NULL, 'sendMessage', '2018-09-17 16:51:25'),
(470, '44750223', NULL, 'sendMessage', '2018-09-17 16:51:29'),
(471, '44750223', NULL, 'sendMessage', '2018-09-17 16:51:30'),
(472, '44750223', NULL, 'sendMessage', '2018-09-17 16:51:34'),
(473, '44750223', NULL, 'sendMessage', '2018-09-17 16:51:37'),
(474, '51161476', NULL, 'sendMessage', '2018-09-18 06:57:24'),
(475, '51161476', NULL, 'sendMessage', '2018-09-18 06:57:33'),
(476, '51161476', NULL, 'sendMessage', '2018-09-18 06:57:34'),
(477, '51161476', NULL, 'sendMessage', '2018-09-18 06:57:38'),
(478, '51161476', NULL, 'sendMessage', '2018-09-18 06:57:40'),
(479, '51161476', NULL, 'sendMessage', '2018-09-18 06:57:46'),
(480, '11120017', NULL, 'sendMessage', '2018-09-18 06:57:55'),
(481, '51161476', NULL, 'sendMessage', '2018-09-18 06:58:01'),
(482, '51161476', NULL, 'sendMessage', '2018-09-18 06:58:04'),
(483, '51161476', NULL, 'sendMessage', '2018-09-18 06:58:08'),
(484, '51161476', NULL, 'sendMessage', '2018-09-18 06:58:11'),
(485, '370140466', NULL, 'sendMessage', '2018-09-18 11:52:23'),
(486, '370140466', NULL, 'sendMessage', '2018-09-18 11:53:05'),
(487, '370140466', NULL, 'sendMessage', '2018-09-18 11:53:08'),
(488, '370140466', NULL, 'sendMessage', '2018-09-18 11:53:22'),
(489, '370140466', NULL, 'sendMessage', '2018-09-18 11:53:36'),
(490, '11120017', NULL, 'sendMessage', '2018-09-18 12:11:06'),
(491, '11120017', NULL, 'sendMessage', '2018-09-18 12:11:07'),
(492, '11120017', NULL, 'sendMessage', '2018-09-18 12:11:09'),
(493, '11120017', NULL, 'sendMessage', '2018-09-18 12:13:50'),
(494, '11120017', NULL, 'sendMessage', '2018-09-18 12:20:10'),
(495, '11120017', NULL, 'sendMessage', '2018-09-18 12:20:23'),
(496, '11120017', NULL, 'sendMessage', '2018-09-18 12:20:27'),
(497, '11120017', NULL, 'sendPhoto', '2018-09-18 12:20:40'),
(498, '11120017', NULL, 'sendMessage', '2018-09-18 12:20:47'),
(499, '11120017', NULL, 'sendMessage', '2018-09-18 12:20:54'),
(500, '11120017', NULL, 'sendMessage', '2018-09-18 12:27:06'),
(501, '11120017', NULL, 'sendMessage', '2018-09-18 12:27:07'),
(502, '11120017', NULL, 'sendMessage', '2018-09-18 12:30:44'),
(503, '11120017', NULL, 'sendMessage', '2018-09-18 12:30:46'),
(504, '11120017', NULL, 'sendMessage', '2018-09-18 12:30:47'),
(505, '11120017', NULL, 'sendMessage', '2018-09-18 12:31:12'),
(506, '11120017', NULL, 'sendMessage', '2018-09-18 12:31:14'),
(507, '11120017', NULL, 'sendMessage', '2018-09-18 12:31:17'),
(508, '11120017', NULL, 'sendMessage', '2018-09-18 12:31:21'),
(509, '11120017', NULL, 'sendMessage', '2018-09-18 12:31:24'),
(510, '11120017', NULL, 'sendMessage', '2018-09-18 12:31:27'),
(511, '11120017', NULL, 'sendMessage', '2018-09-18 12:31:36'),
(512, '11120017', NULL, 'sendMessage', '2018-09-18 12:31:40'),
(513, '11120017', NULL, 'sendMessage', '2018-09-18 12:31:42'),
(514, '11120017', NULL, 'sendMessage', '2018-09-18 12:31:49'),
(515, '11120017', NULL, 'sendMessage', '2018-09-18 12:31:53'),
(516, '11120017', NULL, 'sendMessage', '2018-09-18 12:31:54'),
(517, '11120017', NULL, 'sendMessage', '2018-09-18 12:32:04'),
(518, '11120017', NULL, 'sendMessage', '2018-09-18 12:32:13'),
(519, '11120017', NULL, 'sendMessage', '2018-09-18 12:32:14'),
(520, '11120017', NULL, 'sendMessage', '2018-09-18 12:32:19'),
(521, '11120017', NULL, 'sendMessage', '2018-09-18 12:32:23'),
(522, '11120017', NULL, 'sendMessage', '2018-09-18 12:32:25'),
(523, '11120017', NULL, 'sendMessage', '2018-09-18 12:32:27'),
(524, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:19'),
(525, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:23'),
(526, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:24'),
(527, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:29'),
(528, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:33'),
(529, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:34'),
(530, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:39'),
(531, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:42'),
(532, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:43'),
(533, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:46'),
(534, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:49'),
(535, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:54'),
(536, '87703754', NULL, 'sendMessage', '2018-09-21 12:53:57'),
(537, '87703754', NULL, 'sendMessage', '2018-09-21 12:54:00'),
(538, '87703754', NULL, 'sendMessage', '2018-09-21 12:54:02'),
(539, '87703754', NULL, 'sendMessage', '2018-09-21 12:54:59'),
(540, '87703754', NULL, 'sendMessage', '2018-09-21 12:55:00'),
(541, '44750223', NULL, 'sendMessage', '2018-09-21 12:55:36'),
(542, '44750223', NULL, 'sendMessage', '2018-09-21 12:55:40'),
(543, '44750223', NULL, 'sendMessage', '2018-09-21 12:55:41'),
(544, '87703754', NULL, 'sendMessage', '2018-09-21 13:05:51'),
(545, '87703754', NULL, 'sendMessage', '2018-09-21 13:05:55'),
(546, '87703754', NULL, 'sendMessage', '2018-09-21 13:05:57'),
(547, '44750223', NULL, 'sendMessage', '2018-09-21 13:06:08'),
(548, '44750223', NULL, 'sendMessage', '2018-09-21 13:06:21'),
(549, '44750223', NULL, 'sendMessage', '2018-09-21 13:06:22'),
(550, '44750223', NULL, 'sendMessage', '2018-09-21 13:06:39'),
(551, '44750223', NULL, 'sendMessage', '2018-09-21 13:06:53'),
(552, '44750223', NULL, 'sendMessage', '2018-09-21 13:06:58'),
(553, '44750223', NULL, 'sendMessage', '2018-09-21 13:08:27'),
(554, '44750223', NULL, 'sendMessage', '2018-09-21 13:14:37'),
(555, '44750223', NULL, 'sendMessage', '2018-09-21 13:14:45'),
(556, '11120017', NULL, 'sendMessage', '2018-09-21 13:15:08'),
(557, '11120017', NULL, 'sendMessage', '2018-09-21 13:15:10'),
(558, '11120017', NULL, 'sendMessage', '2018-09-21 13:15:21'),
(559, '44750223', NULL, 'sendMessage', '2018-09-21 13:15:28'),
(560, '44750223', NULL, 'sendMessage', '2018-09-21 13:15:29'),
(561, '11120017', NULL, 'sendMessage', '2018-09-21 13:15:34'),
(562, '44750223', NULL, 'sendMessage', '2018-09-21 13:15:36'),
(563, '44750223', NULL, 'sendMessage', '2018-09-21 13:15:40'),
(564, '11120017', NULL, 'sendMessage', '2018-09-21 13:16:03'),
(565, '11120017', NULL, 'sendMessage', '2018-09-21 13:16:17'),
(566, '44750223', NULL, 'sendMessage', '2018-09-21 13:16:20'),
(567, '44750223', NULL, 'sendMessage', '2018-09-21 13:16:24'),
(568, '44750223', NULL, 'sendMessage', '2018-09-21 13:16:26'),
(569, '44750223', NULL, 'sendMessage', '2018-09-21 13:16:29'),
(570, '44750223', NULL, 'sendMessage', '2018-09-21 13:16:31'),
(571, '44750223', NULL, 'sendMessage', '2018-09-21 13:16:32'),
(572, '44750223', NULL, 'sendMessage', '2018-09-21 13:16:38'),
(573, '44750223', NULL, 'sendMessage', '2018-09-21 13:16:42'),
(574, '87703754', NULL, 'sendMessage', '2018-09-21 13:16:57'),
(575, '44750223', NULL, 'sendMessage', '2018-09-21 13:19:36'),
(576, '44750223', NULL, 'sendMessage', '2018-09-21 13:19:40'),
(577, '44750223', NULL, 'sendMessage', '2018-09-21 13:19:50'),
(578, '44750223', NULL, 'sendMessage', '2018-09-21 13:28:37'),
(579, '44750223', NULL, 'sendMessage', '2018-09-21 13:28:40'),
(580, '44750223', NULL, 'sendMessage', '2018-09-21 13:28:41'),
(581, '44750223', NULL, 'sendMessage', '2018-09-21 13:28:44'),
(582, '44750223', NULL, 'sendMessage', '2018-09-21 13:28:47'),
(583, '44750223', NULL, 'sendMessage', '2018-09-21 13:29:03'),
(584, '44750223', NULL, 'sendMessage', '2018-09-21 13:29:50'),
(585, '44750223', NULL, 'sendMessage', '2018-09-21 13:29:54'),
(586, '44750223', NULL, 'sendMessage', '2018-09-21 13:30:12'),
(587, '44750223', NULL, 'sendMessage', '2018-09-21 13:30:28'),
(588, '44750223', NULL, 'sendMessage', '2018-09-21 13:30:32'),
(589, '44750223', NULL, 'sendMessage', '2018-09-21 13:30:40'),
(590, '44750223', NULL, 'sendMessage', '2018-09-21 13:30:48'),
(591, '11120017', NULL, 'sendMessage', '2018-09-21 13:30:53'),
(592, '44750223', NULL, 'sendMessage', '2018-09-21 13:30:54'),
(593, '322277047', NULL, 'sendMessage', '2018-09-21 13:36:53'),
(594, '322277047', NULL, 'sendMessage', '2018-09-21 13:37:28'),
(595, '322277047', NULL, 'sendMessage', '2018-09-21 13:37:29'),
(596, '322277047', NULL, 'sendMessage', '2018-09-21 13:37:36'),
(597, '322277047', NULL, 'sendMessage', '2018-09-21 13:37:39'),
(598, '322277047', NULL, 'sendMessage', '2018-09-21 13:37:42'),
(599, '322277047', NULL, 'sendMessage', '2018-09-21 13:37:46'),
(600, '322277047', NULL, 'sendMessage', '2018-09-21 13:38:35'),
(601, '322277047', NULL, 'sendMessage', '2018-09-21 13:38:36'),
(602, '322277047', NULL, 'sendMessage', '2018-09-21 13:38:42'),
(603, '322277047', NULL, 'sendMessage', '2018-09-21 13:38:47'),
(604, '322277047', NULL, 'sendMessage', '2018-09-21 13:41:09'),
(605, '322277047', NULL, 'sendMessage', '2018-09-21 13:43:01'),
(606, '322277047', NULL, 'sendMessage', '2018-09-21 13:43:08'),
(607, '322277047', NULL, 'sendMessage', '2018-09-21 13:43:09'),
(608, '322277047', NULL, 'sendMessage', '2018-09-21 13:43:12'),
(609, '322277047', NULL, 'sendMessage', '2018-09-21 13:43:14'),
(610, '322277047', NULL, 'sendMessage', '2018-09-21 14:20:53'),
(611, '322277047', NULL, 'sendMessage', '2018-09-21 14:20:54'),
(612, '322277047', NULL, 'sendMessage', '2018-09-21 14:21:02'),
(613, '322277047', NULL, 'sendMessage', '2018-09-21 14:21:15'),
(614, '322277047', NULL, 'sendMessage', '2018-09-21 14:21:27'),
(615, '11120017', NULL, 'sendMessage', '2018-09-21 14:21:27'),
(616, '322277047', NULL, 'sendMessage', '2018-09-21 14:21:28'),
(617, '322277047', NULL, 'sendMessage', '2018-09-21 14:22:07'),
(618, '322277047', NULL, 'sendMessage', '2018-09-21 14:22:16'),
(619, '322277047', NULL, 'sendMessage', '2018-09-21 14:22:20'),
(620, '322277047', NULL, 'sendMessage', '2018-09-21 14:22:31'),
(621, '322277047', NULL, 'sendMessage', '2018-09-21 14:22:36'),
(622, '322277047', NULL, 'sendMessage', '2018-09-21 14:22:39'),
(623, '11120017', NULL, 'sendMessage', '2018-09-22 09:09:41'),
(624, '11120017', NULL, 'sendMessage', '2018-09-22 09:09:49'),
(625, '11120017', NULL, 'sendMessage', '2018-09-22 09:09:50'),
(626, '11120017', NULL, 'sendMessage', '2018-09-22 09:09:54'),
(627, '11120017', NULL, 'sendMessage', '2018-09-22 09:10:11'),
(628, '11120017', NULL, 'sendMessage', '2018-09-22 09:10:14'),
(629, '11120017', NULL, 'sendMessage', '2018-09-22 09:10:16'),
(630, '11120017', NULL, 'sendMessage', '2018-09-22 09:10:18'),
(631, '11120017', NULL, 'sendMessage', '2018-09-22 09:10:22'),
(632, '11120017', NULL, 'sendMessage', '2018-09-22 09:10:55'),
(633, '11120017', NULL, 'sendMessage', '2018-09-22 09:11:25'),
(634, '11120017', NULL, 'sendMessage', '2018-09-22 09:11:29'),
(635, '11120017', NULL, 'sendMessage', '2018-09-22 09:11:32'),
(636, '11120017', NULL, 'sendMessage', '2018-09-22 09:11:36'),
(637, '322277047', NULL, 'sendMessage', '2018-09-22 11:15:03'),
(638, '322277047', NULL, 'sendMessage', '2018-09-22 11:15:04'),
(639, '322277047', NULL, 'sendMessage', '2018-09-22 11:15:11'),
(640, '322277047', NULL, 'sendMessage', '2018-09-22 11:15:16'),
(641, '11120017', NULL, 'sendMessage', '2018-09-22 13:42:47'),
(642, '11120017', NULL, 'sendPhoto', '2018-09-22 13:42:50'),
(643, '11120017', NULL, 'sendMessage', '2018-09-22 13:46:58'),
(644, '11120017', NULL, 'sendMessage', '2018-09-22 13:46:59'),
(645, '11120017', NULL, 'sendPhoto', '2018-09-22 13:47:01'),
(646, '11120017', NULL, 'sendPhoto', '2018-09-22 13:48:35'),
(647, '11120017', NULL, 'sendPhoto', '2018-09-22 13:49:28'),
(648, '11120017', NULL, 'sendPhoto', '2018-09-22 13:52:20'),
(649, '11120017', NULL, 'sendMessage', '2018-09-22 13:53:10'),
(650, '11120017', NULL, 'sendMessage', '2018-09-22 13:53:12'),
(651, '11120017', NULL, 'sendPhoto', '2018-09-22 13:53:14'),
(652, '11120017', NULL, 'sendMessage', '2018-09-22 13:53:26'),
(653, '11120017', NULL, 'sendMessage', '2018-09-22 13:53:29'),
(654, '11120017', NULL, 'sendMessage', '2018-09-22 13:53:30');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_store_cart`
--

CREATE TABLE `mktb_tgbot_store_cart` (
  `id` bigint(20) NOT NULL COMMENT 'Unique cart identifier',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'User ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_store_cart_item`
--

CREATE TABLE `mktb_tgbot_store_cart_item` (
  `id` bigint(20) NOT NULL COMMENT 'Unique cart item identifier',
  `cart_id` bigint(20) NOT NULL COMMENT 'Cart identifier',
  `product_id` bigint(20) NOT NULL COMMENT 'Product identifier',
  `quantity` int(10) NOT NULL COMMENT 'Product quantity in cart'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_store_order`
--

CREATE TABLE `mktb_tgbot_store_order` (
  `id` bigint(20) NOT NULL COMMENT 'Unique cart identifier',
  `user_id` bigint(20) DEFAULT NULL COMMENT 'User identifier',
  `date_created` int(11) NOT NULL COMMENT 'Date order placed timestamp',
  `total` decimal(15,2) NOT NULL COMMENT 'Order total price',
  `phone` char(255) DEFAULT '' COMMENT 'Phone number',
  `address` text NOT NULL COMMENT 'Order address',
  `status` tinyint(2) NOT NULL COMMENT 'Order status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_store_order_item`
--

CREATE TABLE `mktb_tgbot_store_order_item` (
  `id` bigint(20) NOT NULL COMMENT 'Order item identifier',
  `order_id` bigint(20) NOT NULL COMMENT 'Order identifier',
  `product_id` bigint(20) NOT NULL COMMENT 'Product identifier',
  `title` char(255) DEFAULT '' COMMENT 'Product title',
  `price` decimal(10,2) NOT NULL COMMENT 'Product price',
  `quantity` int(10) NOT NULL COMMENT 'Product quantity in order'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_store_product`
--

CREATE TABLE `mktb_tgbot_store_product` (
  `id` bigint(20) NOT NULL COMMENT 'Unique product identifier',
  `price` decimal(10,2) NOT NULL COMMENT 'Product price',
  `title` char(255) DEFAULT '' COMMENT 'Product title',
  `description` varchar(5000) NOT NULL COMMENT 'Product description',
  `image_file_id` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_telegram_update`
--

CREATE TABLE `mktb_tgbot_telegram_update` (
  `id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Update''s unique identifier',
  `chat_id` bigint(20) DEFAULT NULL COMMENT 'Unique chat identifier',
  `message_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Unique message identifier',
  `inline_query_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Unique inline query identifier',
  `chosen_inline_result_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Local chosen inline result identifier',
  `callback_query_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Unique callback query identifier',
  `edited_message_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Local edited message identifier'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_tgbot_telegram_update`
--

INSERT INTO `mktb_tgbot_telegram_update` (`id`, `chat_id`, `message_id`, `inline_query_id`, `chosen_inline_result_id`, `callback_query_id`, `edited_message_id`) VALUES
(989110529, 370140466, 172, NULL, NULL, NULL, NULL),
(989110530, 370140466, 173, NULL, NULL, NULL, NULL),
(989110531, 370140466, 176, NULL, NULL, NULL, NULL),
(989110532, 370140466, 179, NULL, NULL, NULL, NULL),
(989110700, NULL, NULL, NULL, NULL, 47760110505424934, NULL),
(989110701, NULL, NULL, NULL, NULL, 47760112885709575, NULL),
(989110702, NULL, NULL, NULL, NULL, 47760110898384855, NULL),
(989110704, NULL, NULL, NULL, NULL, 47760112890180517, NULL),
(989110705, NULL, NULL, NULL, NULL, 47760113406132666, NULL),
(989110707, NULL, NULL, NULL, NULL, 47760112673742210, NULL),
(989110709, NULL, NULL, NULL, NULL, 47760110303131435, NULL),
(989110710, NULL, NULL, NULL, NULL, 47760113425283301, NULL),
(989110711, 691261462, 493, NULL, NULL, NULL, NULL),
(989110713, NULL, NULL, NULL, NULL, 47760110365138892, NULL),
(989110714, NULL, NULL, NULL, NULL, 47760110828434502, NULL),
(989110715, NULL, NULL, NULL, NULL, 47760110223997033, NULL),
(989110716, NULL, NULL, NULL, NULL, 47760111789410056, NULL),
(989110717, NULL, NULL, NULL, NULL, 47760110990787472, NULL),
(989110718, NULL, NULL, NULL, NULL, 47760113581422062, NULL),
(989110719, NULL, NULL, NULL, NULL, 47760112738278338, NULL),
(989110720, NULL, NULL, NULL, NULL, 47760111202594639, NULL),
(989110721, NULL, NULL, NULL, NULL, 47760110303804578, NULL),
(989110722, NULL, NULL, NULL, NULL, 47760111867921996, NULL),
(989110726, NULL, NULL, NULL, NULL, 47760109913471721, NULL),
(989110727, NULL, NULL, NULL, NULL, 47760109688207332, NULL),
(989110729, NULL, NULL, NULL, NULL, 47760109486716918, NULL),
(989110730, NULL, NULL, NULL, NULL, 47760110343323080, NULL),
(989110733, NULL, NULL, NULL, NULL, 47760110566033698, NULL),
(989110734, NULL, NULL, NULL, NULL, 47760112746790649, NULL),
(989110736, NULL, NULL, NULL, NULL, 47760109488236591, NULL),
(989110740, NULL, NULL, NULL, NULL, 47760110863485749, NULL),
(989110742, NULL, NULL, NULL, NULL, 47760110532554043, NULL),
(989110743, NULL, NULL, NULL, NULL, 47760110043760145, NULL),
(989110744, NULL, NULL, NULL, NULL, 47760109848510152, NULL),
(989110746, NULL, NULL, NULL, NULL, 47760111271715136, NULL),
(989110747, NULL, NULL, NULL, NULL, 47760111987451021, NULL),
(989110748, NULL, NULL, NULL, NULL, 47760109652529881, NULL),
(989110750, NULL, NULL, NULL, NULL, 47760112518512172, NULL),
(989110751, NULL, NULL, NULL, NULL, 47760113446949678, NULL),
(989110752, NULL, NULL, NULL, NULL, 47760110983484948, NULL),
(989110753, NULL, NULL, NULL, NULL, 47760111814276720, NULL),
(989110754, NULL, NULL, NULL, NULL, 47760110349194928, NULL),
(989110755, NULL, NULL, NULL, NULL, 47760111514514948, NULL),
(989110756, NULL, NULL, NULL, NULL, 47760111675382341, NULL),
(989110757, NULL, NULL, NULL, NULL, 47760110696124570, NULL),
(989110759, NULL, NULL, NULL, NULL, 47760111398241088, NULL),
(989110760, NULL, NULL, NULL, NULL, 47760112899788431, NULL),
(989110761, NULL, NULL, NULL, NULL, 47760110224013938, NULL),
(989110762, NULL, NULL, NULL, NULL, 47760112998724905, NULL),
(989110763, NULL, NULL, NULL, NULL, 47760110588366043, NULL),
(989110764, NULL, NULL, NULL, NULL, 47760113485324632, NULL),
(989110765, NULL, NULL, NULL, NULL, 47760110515455239, NULL),
(989110766, NULL, NULL, NULL, NULL, 47760110486501955, NULL),
(989110767, NULL, NULL, NULL, NULL, 47760112720895256, NULL),
(989110768, NULL, NULL, NULL, NULL, 47760113004391681, NULL),
(989110769, NULL, NULL, NULL, NULL, 47760110276080720, NULL),
(989110770, NULL, NULL, NULL, NULL, 47760110014379183, NULL),
(989110771, NULL, NULL, NULL, NULL, 47760112640241516, NULL),
(989110772, NULL, NULL, NULL, NULL, 47760109417118744, NULL),
(989110773, NULL, NULL, NULL, NULL, 47760111349483324, NULL),
(989110775, NULL, NULL, NULL, NULL, 47760113272277272, NULL),
(989110776, NULL, NULL, NULL, NULL, 47760112800895757, NULL),
(989110777, NULL, NULL, NULL, NULL, 47760110334719244, NULL),
(989110778, NULL, NULL, NULL, NULL, 47760111825292518, NULL),
(989110779, NULL, NULL, NULL, NULL, 47760109433540933, NULL),
(989110792, NULL, NULL, NULL, NULL, 47760113630473393, NULL),
(989110793, NULL, NULL, NULL, NULL, 47760113142677444, NULL),
(989110796, NULL, NULL, NULL, NULL, 47760109983557490, NULL),
(989110797, NULL, NULL, NULL, NULL, 47760112033872800, NULL),
(989110798, NULL, NULL, NULL, NULL, 47760112185839377, NULL),
(989110799, NULL, NULL, NULL, NULL, 47760110458540144, NULL),
(989110800, NULL, NULL, NULL, NULL, 47760110575918156, NULL),
(989110801, NULL, NULL, NULL, NULL, 47760112448929926, NULL),
(989110802, NULL, NULL, NULL, NULL, 47760111231111203, NULL),
(989110808, NULL, NULL, NULL, NULL, 47760109447221258, NULL),
(989110809, NULL, NULL, NULL, NULL, 47760110448415427, NULL),
(989110810, NULL, NULL, NULL, NULL, 47760110950487166, NULL),
(989110811, NULL, NULL, NULL, NULL, 47760112951787281, NULL),
(989110812, NULL, NULL, NULL, NULL, 47760110474806762, NULL),
(989110814, NULL, NULL, NULL, NULL, 47760112763724425, NULL),
(989110815, NULL, NULL, NULL, NULL, 47760113268250051, NULL),
(989110816, NULL, NULL, NULL, NULL, 47760111173505922, NULL),
(989110818, NULL, NULL, NULL, NULL, 47760112022040189, NULL),
(989110819, NULL, NULL, NULL, NULL, 47760109932403221, NULL),
(989110820, NULL, NULL, NULL, NULL, 47760110294841903, NULL),
(989110821, NULL, NULL, NULL, NULL, 47760113217385270, NULL),
(989110822, NULL, NULL, NULL, NULL, 47760112226403561, NULL),
(989110827, NULL, NULL, NULL, NULL, 47760111223971195, NULL),
(989110828, NULL, NULL, NULL, NULL, 47760112568235981, NULL),
(989110831, NULL, NULL, NULL, NULL, 47760112178563440, NULL),
(989110832, NULL, NULL, NULL, NULL, 47760111396180570, NULL),
(989110838, NULL, NULL, NULL, NULL, 47760112303576889, NULL),
(989110864, NULL, NULL, NULL, NULL, 47760112968639326, NULL),
(989110865, NULL, NULL, NULL, NULL, 47760109505921658, NULL),
(989110867, NULL, NULL, NULL, NULL, 47760109798513455, NULL),
(989110868, NULL, NULL, NULL, NULL, 47760112047623616, NULL),
(989110870, NULL, NULL, NULL, NULL, 47760113180775689, NULL),
(989110871, NULL, NULL, NULL, NULL, 47760112710062548, NULL),
(989110873, NULL, NULL, NULL, NULL, 47760112391311912, NULL),
(989110874, NULL, NULL, NULL, NULL, 47760111425976606, NULL),
(989110877, NULL, NULL, NULL, NULL, 47760112591091170, NULL),
(989110880, NULL, NULL, NULL, NULL, 47760113509248921, NULL),
(989110881, NULL, NULL, NULL, NULL, 47760112186394750, NULL),
(989110882, NULL, NULL, NULL, NULL, 47760112100502337, NULL),
(989110883, NULL, NULL, NULL, NULL, 47760110749940648, NULL),
(989110887, NULL, NULL, NULL, NULL, 47760111111677438, NULL),
(989110888, NULL, NULL, NULL, NULL, 47760112521511626, NULL),
(989110889, NULL, NULL, NULL, NULL, 47760110487969881, NULL),
(989110893, NULL, NULL, NULL, NULL, 47760110151501584, NULL),
(989110894, NULL, NULL, NULL, NULL, 47760111754014115, NULL),
(989110896, 87703754, 746, NULL, NULL, NULL, NULL),
(989110897, 87703754, 748, NULL, NULL, NULL, NULL),
(989110898, 87703754, 751, NULL, NULL, NULL, NULL),
(989110899, 87703754, 753, NULL, NULL, NULL, NULL),
(989110900, 87703754, 755, NULL, NULL, NULL, NULL),
(989110901, 87703754, 757, NULL, NULL, NULL, NULL),
(989110902, 87703754, 758, NULL, NULL, NULL, NULL),
(989110903, 87703754, 761, NULL, NULL, NULL, NULL),
(989110904, 87703754, 763, NULL, NULL, NULL, NULL),
(989110905, 87703754, 765, NULL, NULL, NULL, NULL),
(989110912, 87703754, 782, NULL, NULL, NULL, NULL),
(989110913, 87703754, 784, NULL, NULL, NULL, NULL),
(989110914, 87703754, 786, NULL, NULL, NULL, NULL),
(989110917, 286558501, 793, NULL, NULL, NULL, NULL),
(989110918, 286558501, 795, NULL, NULL, NULL, NULL),
(989110919, 286558501, 798, NULL, NULL, NULL, NULL),
(989110920, 286558501, 800, NULL, NULL, NULL, NULL),
(989110924, NULL, NULL, NULL, NULL, 47760109567962995, NULL),
(989110925, NULL, NULL, NULL, NULL, 47760113624026602, NULL),
(989110927, NULL, NULL, NULL, NULL, 47760112517818079, NULL),
(989110928, NULL, NULL, NULL, NULL, 47760110090954590, NULL),
(989110929, NULL, NULL, NULL, NULL, 47760109371637533, NULL),
(989110940, 381717598, 838, NULL, NULL, NULL, NULL),
(989110941, 381717598, 840, NULL, NULL, NULL, NULL),
(989110942, 381717598, 843, NULL, NULL, NULL, NULL),
(989110943, 381717598, 845, NULL, NULL, NULL, NULL),
(989110944, 211654109, 847, NULL, NULL, NULL, NULL),
(989110945, 211654109, 849, NULL, NULL, NULL, NULL),
(989110946, 211654109, 852, NULL, NULL, NULL, NULL),
(989110947, 211654109, 854, NULL, NULL, NULL, NULL),
(989110948, 211654109, 856, NULL, NULL, NULL, NULL),
(989110949, 211654109, 858, NULL, NULL, NULL, NULL),
(989110950, 211654109, 860, NULL, NULL, NULL, NULL),
(989110951, 211654109, 862, NULL, NULL, NULL, NULL),
(989110952, 211654109, 864, NULL, NULL, NULL, NULL),
(989110953, 211654109, 866, NULL, NULL, NULL, NULL),
(989110954, 211654109, 868, NULL, NULL, NULL, NULL),
(989110955, 211654109, 870, NULL, NULL, NULL, NULL),
(989110958, NULL, NULL, NULL, NULL, 47760110385882946, NULL),
(989110960, NULL, NULL, NULL, NULL, 47760112000148408, NULL),
(989110962, NULL, NULL, NULL, NULL, 47760110893510026, NULL),
(989110966, NULL, NULL, NULL, NULL, 47760109945413341, NULL),
(989110967, NULL, NULL, NULL, NULL, 47760112792388178, NULL),
(989110983, 286558501, 924, NULL, NULL, NULL, NULL),
(989110984, 11120017, 926, NULL, NULL, NULL, NULL),
(989110985, 11120017, 928, NULL, NULL, NULL, NULL),
(989110986, 11120017, 931, NULL, NULL, NULL, NULL),
(989110987, 11120017, 933, NULL, NULL, NULL, NULL),
(989110988, 11120017, 935, NULL, NULL, NULL, NULL),
(989110989, 11120017, 937, NULL, NULL, NULL, NULL),
(989110990, 11120017, 939, NULL, NULL, NULL, NULL),
(989110991, 11120017, 941, NULL, NULL, NULL, NULL),
(989110992, 11120017, 943, NULL, NULL, NULL, NULL),
(989110993, 11120017, 945, NULL, NULL, NULL, NULL),
(989110994, 11120017, 947, NULL, NULL, NULL, NULL),
(989110995, 11120017, 949, NULL, NULL, NULL, NULL),
(989110996, 11120017, 951, NULL, NULL, NULL, NULL),
(989110997, NULL, NULL, NULL, NULL, 47760109891395381, NULL),
(989110998, NULL, NULL, NULL, NULL, 47760110429534463, NULL),
(989110999, NULL, NULL, NULL, NULL, 47760110050686714, NULL),
(989111000, 44750223, 956, NULL, NULL, NULL, NULL),
(989111001, 44750223, 958, NULL, NULL, NULL, NULL),
(989111002, 44750223, 961, NULL, NULL, NULL, NULL),
(989111003, 44750223, 963, NULL, NULL, NULL, NULL),
(989111004, 44750223, 965, NULL, NULL, NULL, NULL),
(989111005, 44750223, 966, NULL, NULL, NULL, NULL),
(989111006, 44750223, 967, NULL, NULL, NULL, NULL),
(989111007, 44750223, 970, NULL, NULL, NULL, NULL),
(989111008, 44750223, 972, NULL, NULL, NULL, NULL),
(989111009, 44750223, 974, NULL, NULL, NULL, NULL),
(989111010, 44750223, 976, NULL, NULL, NULL, NULL),
(989111011, 44750223, 978, NULL, NULL, NULL, NULL),
(989111012, 44750223, 980, NULL, NULL, NULL, NULL),
(989111013, 44750223, 982, NULL, NULL, NULL, NULL),
(989111014, 51161476, 984, NULL, NULL, NULL, NULL),
(989111015, 51161476, 986, NULL, NULL, NULL, NULL),
(989111016, 51161476, 989, NULL, NULL, NULL, NULL),
(989111017, 51161476, 991, NULL, NULL, NULL, NULL),
(989111018, 51161476, 993, NULL, NULL, NULL, NULL),
(989111019, 11120017, 995, NULL, NULL, NULL, NULL),
(989111020, 51161476, 997, NULL, NULL, NULL, NULL),
(989111021, 51161476, 999, NULL, NULL, NULL, NULL),
(989111022, 51161476, 1001, NULL, NULL, NULL, NULL),
(989111023, 51161476, 1003, NULL, NULL, NULL, NULL),
(989111024, 370140466, 1005, NULL, NULL, NULL, NULL),
(989111025, 370140466, 1007, NULL, NULL, NULL, NULL),
(989111026, 370140466, 1009, NULL, NULL, NULL, NULL),
(989111027, 370140466, 1011, NULL, NULL, NULL, NULL),
(989111028, 370140466, 1013, NULL, NULL, NULL, NULL),
(989111029, 11120017, 1015, NULL, NULL, NULL, NULL),
(989111030, 11120017, 1017, NULL, NULL, NULL, NULL),
(989111031, 11120017, 1019, NULL, NULL, NULL, NULL),
(989111032, 11120017, 1021, NULL, NULL, NULL, NULL),
(989111033, 11120017, 1023, NULL, NULL, NULL, NULL),
(989111034, 11120017, 1025, NULL, NULL, NULL, NULL),
(989111035, 11120017, 1027, NULL, NULL, NULL, NULL),
(989111036, 11120017, 1029, NULL, NULL, NULL, NULL),
(989111037, 11120017, 1031, NULL, NULL, NULL, NULL),
(989111038, 11120017, 1033, NULL, NULL, NULL, NULL),
(989111039, 11120017, 1035, NULL, NULL, NULL, NULL),
(989111040, 11120017, 1038, NULL, NULL, NULL, NULL),
(989111041, 11120017, 1040, NULL, NULL, NULL, NULL),
(989111042, 11120017, 1043, NULL, NULL, NULL, NULL),
(989111043, 11120017, 1045, NULL, NULL, NULL, NULL),
(989111044, 11120017, 1047, NULL, NULL, NULL, NULL),
(989111045, 11120017, 1049, NULL, NULL, NULL, NULL),
(989111046, 11120017, 1051, NULL, NULL, NULL, NULL),
(989111047, 11120017, 1053, NULL, NULL, NULL, NULL),
(989111048, 11120017, 1055, NULL, NULL, NULL, NULL),
(989111049, 11120017, 1057, NULL, NULL, NULL, NULL),
(989111050, 11120017, 1059, NULL, NULL, NULL, NULL),
(989111051, 11120017, 1061, NULL, NULL, NULL, NULL),
(989111052, 11120017, 1063, NULL, NULL, NULL, NULL),
(989111053, 11120017, 1066, NULL, NULL, NULL, NULL),
(989111054, 11120017, 1068, NULL, NULL, NULL, NULL),
(989111055, 11120017, 1070, NULL, NULL, NULL, NULL),
(989111056, 11120017, 1072, NULL, NULL, NULL, NULL),
(989111057, 11120017, 1074, NULL, NULL, NULL, NULL),
(989111058, NULL, NULL, NULL, NULL, 47760112490378856, NULL),
(989111059, NULL, NULL, NULL, NULL, 47760113449259445, NULL),
(989111060, 87703754, 1078, NULL, NULL, NULL, NULL),
(989111061, 87703754, 1080, NULL, NULL, NULL, NULL),
(989111062, 87703754, 1083, NULL, NULL, NULL, NULL),
(989111063, 87703754, 1085, NULL, NULL, NULL, NULL),
(989111064, 87703754, 1088, NULL, NULL, NULL, NULL),
(989111065, 87703754, 1090, NULL, NULL, NULL, NULL),
(989111066, 87703754, 1093, NULL, NULL, NULL, NULL),
(989111067, 87703754, 1095, NULL, NULL, NULL, NULL),
(989111068, 87703754, 1097, NULL, NULL, NULL, NULL),
(989111069, 87703754, 1099, NULL, NULL, NULL, NULL),
(989111070, 87703754, 1101, NULL, NULL, NULL, NULL),
(989111071, 87703754, 1103, NULL, NULL, NULL, NULL),
(989111072, 87703754, 1105, NULL, NULL, NULL, NULL),
(989111073, 44750223, 1108, NULL, NULL, NULL, NULL),
(989111074, 44750223, 1110, NULL, NULL, NULL, NULL),
(989111075, 87703754, 1113, NULL, NULL, NULL, NULL),
(989111076, 87703754, 1115, NULL, NULL, NULL, NULL),
(989111077, 44750223, 1118, NULL, NULL, NULL, NULL),
(989111078, 44750223, 1120, NULL, NULL, NULL, NULL),
(989111079, 44750223, 1121, NULL, NULL, NULL, NULL),
(989111080, NULL, NULL, NULL, NULL, 192200747072189110, NULL),
(989111081, NULL, NULL, NULL, NULL, 192200744296022316, NULL),
(989111082, NULL, NULL, NULL, NULL, 192200748235015553, NULL),
(989111083, NULL, NULL, NULL, NULL, 192200746187145731, NULL),
(989111084, NULL, NULL, NULL, NULL, 192200746764989970, NULL),
(989111085, NULL, NULL, NULL, NULL, 192200746140874778, NULL),
(989111086, 11120017, 1130, NULL, NULL, NULL, NULL),
(989111087, 11120017, 1132, NULL, NULL, NULL, NULL),
(989111088, NULL, NULL, NULL, NULL, 47760113482159183, NULL),
(989111089, 44750223, 1135, NULL, NULL, NULL, NULL),
(989111090, 11120017, 1138, NULL, NULL, NULL, NULL),
(989111091, NULL, NULL, NULL, NULL, 192200745513811338, NULL),
(989111092, NULL, NULL, NULL, NULL, 192200747446885695, NULL),
(989111093, 11120017, 1142, NULL, NULL, NULL, NULL),
(989111094, 11120017, 1144, NULL, NULL, NULL, NULL),
(989111095, 44750223, 1146, NULL, NULL, NULL, NULL),
(989111096, 44750223, 1148, NULL, NULL, NULL, NULL),
(989111097, 44750223, 1150, NULL, NULL, NULL, NULL),
(989111098, 44750223, 1152, NULL, NULL, NULL, NULL),
(989111099, 44750223, 1154, NULL, NULL, NULL, NULL),
(989111100, NULL, NULL, NULL, NULL, 192200745596093688, NULL),
(989111101, NULL, NULL, NULL, NULL, 192200747071524640, NULL),
(989111102, 87703754, 1159, NULL, NULL, NULL, NULL),
(989111103, 44750223, 1161, NULL, NULL, NULL, NULL),
(989111104, 44750223, 1163, NULL, NULL, NULL, NULL),
(989111105, 44750223, 1165, NULL, NULL, NULL, NULL),
(989111106, 44750223, 1167, NULL, NULL, NULL, NULL),
(989111107, 44750223, 1169, NULL, NULL, NULL, NULL),
(989111108, 44750223, 1172, NULL, NULL, NULL, NULL),
(989111109, NULL, NULL, NULL, NULL, 192200748106140452, NULL),
(989111110, NULL, NULL, NULL, NULL, 192200747184440826, NULL),
(989111111, 44750223, 1176, NULL, NULL, NULL, NULL),
(989111112, 44750223, 1178, NULL, NULL, NULL, NULL),
(989111113, 44750223, 1180, NULL, NULL, NULL, NULL),
(989111114, 44750223, 1182, NULL, NULL, NULL, NULL),
(989111115, 44750223, 1184, NULL, NULL, NULL, NULL),
(989111116, 44750223, 1186, NULL, NULL, NULL, NULL),
(989111117, 44750223, 1188, NULL, NULL, NULL, NULL),
(989111118, 44750223, 1190, NULL, NULL, NULL, NULL),
(989111119, 322277047, 1193, NULL, NULL, NULL, NULL),
(989111120, 322277047, 1195, NULL, NULL, NULL, NULL),
(989111121, 322277047, 1198, NULL, NULL, NULL, NULL),
(989111122, 322277047, 1200, NULL, NULL, NULL, NULL),
(989111123, NULL, NULL, NULL, NULL, 1384169377562257785, NULL),
(989111124, NULL, NULL, NULL, NULL, 1384169380398592159, NULL),
(989111125, 322277047, 1204, NULL, NULL, NULL, NULL),
(989111126, NULL, NULL, NULL, NULL, 1384169380398224321, NULL),
(989111127, NULL, NULL, NULL, NULL, 1384169378265056532, NULL),
(989111128, NULL, NULL, NULL, NULL, 1384169380157782540, NULL),
(989111129, NULL, NULL, NULL, NULL, 1384169377871953373, NULL),
(989111130, 322277047, 1211, NULL, NULL, NULL, NULL),
(989111131, NULL, NULL, NULL, NULL, 1384169377249939841, NULL),
(989111132, NULL, NULL, NULL, NULL, 1384169379301554378, NULL),
(989111133, 322277047, 1216, NULL, NULL, NULL, NULL),
(989111134, NULL, NULL, NULL, NULL, 1384169377880352095, NULL),
(989111135, 322277047, 1220, NULL, NULL, NULL, NULL),
(989111136, 11120017, 1221, NULL, NULL, NULL, NULL),
(989111137, NULL, NULL, NULL, NULL, 1384169380478262418, NULL),
(989111138, NULL, NULL, NULL, NULL, 1384169380778506732, NULL),
(989111139, NULL, NULL, NULL, NULL, 1384169380197196120, NULL),
(989111140, 322277047, 1227, NULL, NULL, NULL, NULL),
(989111141, 322277047, 1229, NULL, NULL, NULL, NULL),
(989111142, 322277047, 1231, NULL, NULL, NULL, NULL),
(989111143, 322277047, 1233, NULL, NULL, NULL, NULL),
(989111144, 322277047, 1235, NULL, NULL, NULL, NULL),
(989111145, 263488083, 1237, NULL, NULL, NULL, NULL),
(989111146, 11120017, 1238, NULL, NULL, NULL, NULL),
(989111147, 11120017, 1240, NULL, NULL, NULL, NULL),
(989111148, 11120017, 1242, NULL, NULL, NULL, NULL),
(989111149, 11120017, 1244, NULL, NULL, NULL, NULL),
(989111150, 11120017, 1246, NULL, NULL, NULL, NULL),
(989111151, 11120017, 1248, NULL, NULL, NULL, NULL),
(989111152, NULL, NULL, NULL, NULL, 47760113529054858, NULL),
(989111153, NULL, NULL, NULL, NULL, 47760110995474518, NULL),
(989111154, 11120017, 1253, NULL, NULL, NULL, NULL),
(989111155, NULL, NULL, NULL, NULL, 47760109454604512, NULL),
(989111156, NULL, NULL, NULL, NULL, 47760112753918303, NULL),
(989111157, NULL, NULL, NULL, NULL, 47760111885069746, NULL),
(989111158, 11120017, 1258, NULL, NULL, NULL, NULL),
(989111159, 322277047, 1260, NULL, NULL, NULL, NULL),
(989111160, NULL, NULL, NULL, NULL, 1384169380853332804, NULL),
(989111161, NULL, NULL, NULL, NULL, 1384169379934262267, NULL),
(989111162, 11120017, 1265, NULL, NULL, NULL, NULL),
(989111163, 11120017, 1266, NULL, NULL, NULL, NULL),
(989111164, 11120017, 1267, NULL, NULL, NULL, NULL),
(989111165, 11120017, 1269, NULL, NULL, NULL, NULL),
(989111166, 11120017, 1270, NULL, NULL, NULL, NULL),
(989111167, 11120017, 1272, NULL, NULL, NULL, NULL),
(989111168, 11120017, 1274, NULL, NULL, NULL, NULL),
(989111169, 11120017, 1275, NULL, NULL, NULL, NULL),
(989111170, 11120017, 1276, NULL, NULL, NULL, NULL),
(989111171, 11120017, 1277, NULL, NULL, NULL, NULL),
(989111172, 11120017, 1278, NULL, NULL, NULL, NULL),
(989111173, 11120017, 1280, NULL, NULL, NULL, NULL),
(989111174, 11120017, 1282, NULL, NULL, NULL, NULL),
(989111175, 11120017, 1284, NULL, NULL, NULL, NULL),
(989111176, 11120017, 1286, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_user`
--

CREATE TABLE `mktb_tgbot_user` (
  `id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Unique user identifier',
  `is_bot` tinyint(1) DEFAULT '0' COMMENT 'True if this user is a bot',
  `first_name` char(255) NOT NULL DEFAULT '' COMMENT 'User''s first name',
  `last_name` char(255) DEFAULT NULL COMMENT 'User''s last name',
  `username` char(191) DEFAULT NULL COMMENT 'User''s username',
  `language_code` char(10) DEFAULT NULL COMMENT 'User''s system language',
  `created_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date creation',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Entry date update',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `language_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_tgbot_user`
--

INSERT INTO `mktb_tgbot_user` (`id`, `is_bot`, `first_name`, `last_name`, `username`, `language_code`, `created_at`, `updated_at`, `phone`, `language_id`) VALUES
(11120017, 0, 'Ulugbek', 'Yusupxodjayev', 'smartweb_uz', 'ru-RU', '2018-09-18 12:30:43', '2018-09-22 13:53:28', '+998908081239', 1),
(44750223, 0, 'ГУЛБАХОР Бахтияровна', 'АХИ АБДУКАРИМОВА', 'ELFIYSAR', 'ru', '2018-09-17 16:49:11', '2018-09-21 13:30:53', '+998934430204', 2),
(51161476, 0, 'Максим', NULL, 'intromax', 'ru', '2018-09-18 06:57:23', '2018-09-18 06:58:10', '+998903263563', 1),
(87703754, 0, 'Umidjon', NULL, 'interintellect', 'en-us', '2018-09-21 12:53:17', '2018-09-21 13:16:57', '+998911660048', 2),
(211654109, 0, 'Фарруҳ', NULL, 'farruhkarimov', 'ru', '2018-09-16 19:58:22', '2018-09-16 20:01:22', '+998949343836', 2),
(263488083, 0, 'Заррина', 'Нарзуллоева', NULL, 'ru', '2018-09-22 05:49:37', '2018-09-22 05:49:37', '', 1),
(286558501, 0, 'SalamHotel', NULL, 'salamhotel', 'ru-RU', '2018-09-15 17:17:17', '2018-09-17 13:19:43', '+998903261137', 1),
(322277047, 0, 'Izzatillo', 'Ismoilov', NULL, 'ru', '2018-09-21 13:36:52', '2018-09-22 11:15:16', '+998916122080', 2),
(370140466, 0, 'KLeoPaTRa', '123', NULL, 'ru', '2018-09-04 05:45:05', '2018-09-18 11:53:34', '+998911667886', 1),
(381717598, 0, 'Bobur Kodirjonov', NULL, 'Internet_Marketing_SMM', 'ru', '2018-09-15 17:21:38', '2018-09-15 17:21:53', '+998946453799', 1),
(588857334, 1, 'Maktab', NULL, 'maktabuzbot', NULL, '2018-09-04 05:45:32', '2018-09-22 11:15:11', '', 1),
(691261462, 0, 'Бахром', 'Батыров', NULL, 'ru-RU', '2018-09-07 21:35:49', '2018-09-07 21:35:49', '', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tgbot_user_chat`
--

CREATE TABLE `mktb_tgbot_user_chat` (
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Unique user identifier',
  `chat_id` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Unique user or chat identifier'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_tgbot_user_chat`
--

INSERT INTO `mktb_tgbot_user_chat` (`user_id`, `chat_id`) VALUES
(11120017, 11120017),
(588857334, 11120017),
(44750223, 44750223),
(588857334, 44750223),
(51161476, 51161476),
(588857334, 51161476),
(87703754, 87703754),
(588857334, 87703754),
(211654109, 211654109),
(588857334, 211654109),
(263488083, 263488083),
(286558501, 286558501),
(588857334, 286558501),
(322277047, 322277047),
(588857334, 322277047),
(370140466, 370140466),
(588857334, 370140466),
(381717598, 381717598),
(588857334, 381717598),
(691261462, 691261462);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_translation`
--

CREATE TABLE `mktb_translation` (
  `id` int(11) NOT NULL,
  `lang` tinyint(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `context` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_translation`
--

INSERT INTO `mktb_translation` (`id`, `lang`, `name`, `content`, `context`) VALUES
(1, 1, 'news', 'Новость', 'back'),
(2, 1, 'news list', 'Список новостей', 'back'),
(3, 1, 'category list', 'Список категорий', 'back'),
(4, 1, 'category', 'Категория', 'back'),
(5, 1, 'category2', 'категорию', 'back'),
(6, 1, 'information', 'Текст', 'back'),
(7, 1, 'information list', 'Список текстов', 'back'),
(8, 1, 'manufacturer list', 'Список производителей', 'back'),
(9, 1, 'manufacturer', 'производитель', 'back'),
(10, 1, 'manufacturer2', 'производителя', 'back'),
(11, 1, 'product list', 'Список товаров', 'back'),
(13, 1, 'order list', 'Список заказов', 'back'),
(14, 1, 'order', 'заказ', 'back'),
(15, 1, 'menu item list', 'Меню', 'back'),
(16, 1, 'menu item', 'Пункт меню', 'back'),
(19, 1, 'product manufacturer', 'Производитель', 'back'),
(20, 1, 'product quantity', 'Количество', 'back'),
(22, 1, 'product price special', 'Цена со скидкой', 'back'),
(23, 1, 'product price discount', 'Скидка', 'back'),
(24, 1, 'product date', 'Дата изм.', 'back'),
(25, 1, 'search', 'Поиск', 'back'),
(26, 1, 'find', 'Найти', 'back'),
(27, 1, 'find product', 'Найти товар', 'back'),
(28, 1, 'find order', 'Найти заказ №', 'back'),
(29, 1, 'view in site', 'Посмотреть на сайте', 'back'),
(30, 1, 'order number', 'Номер заказа', 'back'),
(31, 1, 'order status', 'Статус', 'back'),
(32, 1, 'order status change', 'Статус вашего заказа №%s изменен', 'back'),
(33, 1, 'order name', 'Имя', 'back'),
(34, 1, 'order email', 'E-mail', 'back'),
(35, 1, 'order phone', 'Телефон', 'back'),
(36, 1, 'order sum', 'Сумма', 'back'),
(37, 1, 'order date', 'Дата', 'back'),
(38, 1, 'order comment', 'Комментарий', 'back'),
(39, 1, 'control panel', 'Панель управление', 'back'),
(40, 1, 'enter account', 'Вход в панель управления', 'back'),
(41, 1, 'welcome', 'Добро пожаловать', 'back'),
(42, 1, 'switch on', 'вкл', 'front'),
(43, 1, 'switch off', 'откл', 'front'),
(44, 1, 'success', 'Сохранено', 'back'),
(45, 1, 'check form', 'Ошибка сохранения. Проверьте форму', 'back'),
(46, 1, 'add', 'добавить', 'back'),
(47, 1, 'edit', 'изменить', 'back'),
(48, 1, 'delete', 'удалить', 'back'),
(49, 1, 'yes', 'да', 'back'),
(50, 1, 'no', 'нет', 'back'),
(51, 1, 'confirm', 'Вы уверены?', 'back'),
(52, 1, 'user', 'Пользователь', 'back'),
(53, 1, 'user list', 'Список пользователей', 'back'),
(54, 1, 'banner list', 'Список слайдов', 'back'),
(55, 1, 'banner', 'баннер', 'back'),
(56, 1, 'slide', 'слайд', 'back'),
(57, 1, 'configuration', 'Настройки', 'back'),
(58, 1, 'configuration edit', 'Изменение настроек сайта', 'back'),
(59, 1, 'article list', 'Статьи', 'back'),
(60, 1, 'article', 'статья', 'back'),
(61, 1, 'article2', 'статью', 'back'),
(62, 1, 'logout', 'Выйти', 'back'),
(63, 1, 'login', 'Войти', 'back'),
(64, 1, 'back', 'назад', 'back'),
(65, 1, 'save tree', 'сохранить сортировку и вложенность', 'back'),
(66, 1, 'save category tree', 'сохранить сортировку и вложенность категорий', 'back'),
(67, 1, 'save', 'сохранить', 'back'),
(68, 1, 'site', 'сайт', 'back'),
(69, 1, 'enable all', 'вкл. все', 'back'),
(70, 1, 'disable all', 'откл. все', 'back'),
(71, 1, 'error alias', 'неверное url название. только символы (a-z, 0-9, -)', 'back'),
(72, 1, 'error product alias exists', 'url название уже существует', 'back'),
(73, 1, 'error field required', 'обязательное поле', 'back'),
(74, 1, 'error only integer', 'только цифры', 'back'),
(75, 1, 'error price invalid', 'цена должна быть положительным числом', 'back'),
(76, 1, 'error choose category', 'Выберите категорию', 'back'),
(77, 1, 'error choose manufacturer', 'выберите производителя', 'back'),
(78, 1, 'error disable language', 'нельзя отключить все языки', 'back'),
(79, 1, 'error date invalid format', 'неверный формат даты', 'back'),
(80, 1, 'error date invalid', 'неверная дата', 'back'),
(81, 2, 'news', 'News', 'back'),
(82, 2, 'news list', 'News list', 'back'),
(83, 2, 'category list', 'Category list', 'back'),
(84, 2, 'category', 'Category', 'back'),
(85, 2, 'category2', 'категорию', 'back'),
(86, 2, 'information', 'Текст', 'back'),
(87, 2, 'information list', 'Список текстов', 'back'),
(88, 2, 'manufacturer list', 'Список производителей', 'back'),
(89, 2, 'manufacturer', 'производителя', 'back'),
(90, 2, 'manufacturer2', 'производителя', 'back'),
(91, 2, 'product list', 'Product list', 'back'),
(93, 2, 'order list', 'Список заказов', 'back'),
(94, 2, 'order', 'order', 'back'),
(95, 2, 'menu item list', 'Menu', 'back'),
(96, 2, 'menu item', 'Пункт меню', 'back'),
(97, 2, 'product name', 'Название', 'back'),
(98, 2, 'product category', 'Category', 'back'),
(99, 2, 'product manufacturer', 'Manufacturer', 'back'),
(100, 2, 'product quantity', 'Количество', 'back'),
(102, 2, 'product price special', 'Цена со скидкой', 'back'),
(103, 2, 'product price discount', 'Скидка', 'back'),
(104, 2, 'product date', 'Date mdf.', 'back'),
(105, 2, 'search', 'Поиск', 'back'),
(106, 2, 'find', 'Найти', 'back'),
(107, 2, 'find product', 'Найти товар', 'back'),
(108, 2, 'find order', 'Найти заказ №', 'back'),
(109, 2, 'view in site', 'Посмотреть на сайте', 'back'),
(110, 2, 'order number', 'Номер заказа', 'back'),
(111, 2, 'order status', 'Статус', 'back'),
(112, 2, 'order status change', 'Статус вашего заказа №%s изменен', 'back'),
(113, 2, 'order name', 'Имя', 'back'),
(114, 2, 'order email', 'E-mail', 'back'),
(115, 2, 'order phone', 'Телефон', 'back'),
(116, 2, 'order sum', 'Сумма', 'back'),
(117, 2, 'order date', 'Дата', 'back'),
(118, 2, 'order comment', 'Comment', 'back'),
(119, 2, 'control panel', 'Панель управление', 'back'),
(120, 2, 'enter account', 'Вход в панель управления', 'back'),
(121, 2, 'welcome', 'Добро пожаловать', 'back'),
(122, 2, 'switch on', 'on', 'back'),
(123, 2, 'switch off', 'off', 'back'),
(124, 2, 'success', 'Сохранено', 'back'),
(125, 2, 'check form', 'Ошибка сохранения. Проверьте форму', 'back'),
(126, 2, 'add', 'add', 'back'),
(127, 2, 'edit', 'edit', 'back'),
(128, 2, 'delete', 'удалить', 'back'),
(129, 2, 'yes', 'да', 'back'),
(130, 2, 'no', 'no', 'back'),
(131, 2, 'confirm', 'Вы уверены?', 'back'),
(132, 2, 'user', 'Users', 'back'),
(133, 2, 'user list', 'Users list', 'back'),
(134, 2, 'banner list', 'Список слайдов', 'back'),
(135, 2, 'banner', 'баннер', 'back'),
(136, 2, 'slide', 'слайд', 'back'),
(137, 2, 'configuration', 'Настройки', 'back'),
(138, 2, 'configuration edit', 'Edit Configuration', 'back'),
(139, 2, 'article list', 'Статьи', 'back'),
(140, 2, 'article', 'статья', 'back'),
(141, 2, 'article2', 'статью', 'back'),
(142, 2, 'logout', 'Logout', 'back'),
(143, 2, 'login', 'Login', 'back'),
(144, 2, 'back', 'назад', 'back'),
(145, 2, 'save tree', 'сохранить сортировку и вложенность', 'back'),
(146, 2, 'save category tree', 'сохранить сортировку и вложенность категорий', 'back'),
(147, 2, 'save', 'save', 'back'),
(148, 2, 'site', 'сайт', 'back'),
(149, 2, 'enable all', 'вкл. все', 'back'),
(150, 2, 'disable all', 'откл. все', 'back'),
(151, 2, 'error alias', 'неверное url название. только символы (a-z, 0-9, -)', 'back'),
(152, 2, 'error product alias exists', 'url already exists', 'back'),
(153, 2, 'error field required', 'обязательное поле', 'back'),
(154, 2, 'error only integer', 'только цифры', 'back'),
(155, 2, 'error price invalid', 'цена должна быть положительным числом', 'back'),
(156, 2, 'error choose category', 'Выберите категорию', 'back'),
(157, 2, 'error choose manufacturer', 'выберите производителя', 'back'),
(158, 2, 'error disable language', 'нельзя отключить все языки', 'back'),
(159, 2, 'error date invalid format', 'неверный формат даты', 'back'),
(160, 2, 'error date invalid', 'неверная дата', 'back'),
(161, 1, 'username', 'Имя пользователя', 'back'),
(162, 1, 'password', 'Пароль', 'back'),
(163, 2, 'username', 'Username', 'back'),
(164, 2, 'password', 'Password', 'back'),
(165, 2, 'error username empty', 'Введите имя пользователя', 'back'),
(166, 2, 'error password empty', 'Введите пароль', 'back'),
(167, 2, 'error no such username', 'Такого пользователя не существует', 'back'),
(168, 2, 'error password', 'Неверный пароль', 'back'),
(169, 1, 'error username empty', 'Введите имя пользователя', 'back'),
(170, 1, 'error password empty', 'Введите пароль', 'back'),
(171, 1, 'error no such username', 'Такого пользователя не существует', 'back'),
(172, 1, 'error password', 'Неверный пароль', 'back'),
(173, 2, 'error login', 'Ошибка входа пользователя', 'back'),
(174, 1, 'error login', 'Ошибка входа пользователя', 'back'),
(175, 1, 'main page', 'Главная', 'back'),
(176, 2, 'main page', 'Home', 'back'),
(177, 1, 'control panel', 'Панель управления', 'back'),
(178, 2, 'control panel', 'Control Panel', 'back'),
(179, 1, 'menu category', 'Категории', 'back'),
(180, 2, 'menu category', 'Categories', 'back'),
(181, 1, 'menu product', 'Продукция', 'back'),
(182, 2, 'menu product', 'Products', 'back'),
(183, 1, 'menu order', 'Заказы', 'back'),
(184, 2, 'menu order', 'Orders', 'back'),
(185, 1, 'menu user', 'Пользователи', 'back'),
(186, 2, 'menu user', 'Users', 'back'),
(187, 2, 'profile', 'Profile', 'back'),
(188, 1, 'profile', 'Профиль', 'back'),
(189, 2, '404 error', 'Error 404', 'back'),
(190, 1, '404 error', 'Ошибка 404', 'back'),
(191, 1, 'category page', 'Категории', 'back'),
(192, 2, 'category page', 'Categories', 'back'),
(193, 1, 'add category', 'Добавить категорию', 'back'),
(194, 2, 'add category', 'Add category', 'back'),
(195, 1, 'edit category', 'Редактировать категорию', 'back'),
(196, 2, 'edit category', 'Edit category', 'back'),
(197, 1, 'delete category', 'Удалить категорию', 'back'),
(198, 2, 'delete category', 'Delete category', 'back'),
(199, 1, 'category name', 'Название', 'back'),
(200, 2, 'category name', 'Name', 'back'),
(201, 1, 'meta data', 'Мета данные', 'back'),
(202, 2, 'meta data', 'Meta data', 'back'),
(203, 1, 'alias name', 'URL название', 'back'),
(204, 2, 'alias name', 'URL name', 'back'),
(205, 1, 'status', 'Статус', 'back'),
(206, 2, 'status', 'Status', 'back'),
(207, 1, 'descr short', 'Короткое описание', 'back'),
(208, 2, 'descr short', 'Short description', 'back'),
(209, 1, 'descr full', 'Полное описание', 'back'),
(210, 2, 'descr full', 'Full description', 'back'),
(211, 1, 'toggle on', 'Вкл', 'back'),
(212, 2, 'toggle on', 'On', 'back'),
(213, 1, 'toggle off', 'Откл', 'back'),
(214, 2, 'toggle off', 'Off', 'back'),
(215, 1, 'control buttons', 'Управление', 'back'),
(216, 2, 'control buttons', 'Control', 'back'),
(217, 1, 'category parent', 'Родительская категория', 'back'),
(218, 2, 'category parent', 'Parent category', 'back'),
(219, 1, 'are you sure', 'Вы уверены?', 'back'),
(220, 2, 'are you sure', 'Are you sure?', 'back'),
(221, 1, 'confirm yes', 'Да', 'back'),
(222, 2, 'confirm yes', 'Yes', 'back'),
(223, 1, 'confirm no', 'Нет', 'back'),
(224, 2, 'confirm no', 'No', 'back'),
(225, 1, 'btn save', 'Сохранить', 'back'),
(226, 2, 'btn save', 'Save', 'back'),
(227, 1, 'btn back', 'Назад', 'back'),
(228, 2, 'btn back', 'Back', 'back'),
(229, 1, 'btn add', 'Добавить', 'back'),
(230, 2, 'btn add', 'Add', 'back'),
(231, 1, 'btn edit', 'Редактировать', 'back'),
(232, 2, 'btn edit', 'Edit', 'back'),
(233, 1, 'btn delete', 'Удалить', 'back'),
(234, 2, 'btn delete', 'Delete', 'back'),
(235, 1, 'sorting', 'Сортировка', 'back'),
(236, 2, 'sorting', 'Sort', 'back'),
(237, 1, 'upload image', 'Загрузить картинку', 'back'),
(238, 2, 'upload image', 'Upload image', 'back'),
(239, 1, 'success edit category', 'Категория успешно сохранена', 'back'),
(240, 2, 'success edit category', 'Category has been successfully saved', 'back'),
(241, 1, 'error not alias', 'Только a-z 0-9', 'back'),
(242, 2, 'error not alias', 'Only a-z 0-9', 'back'),
(244, 2, 'error empty', 'Field must be filled', 'back'),
(245, 1, 'success add category', 'Категория успешно добавлена', 'back'),
(246, 2, 'success add category', 'Category has been successfully saved', 'back'),
(247, 1, 'error edit category', 'Ошибка при сохранении категории', 'back'),
(248, 2, 'error edit category', 'Error while saving category. Check form', 'back'),
(249, 1, 'error add category', 'Ошибка при сохранении категории', 'back'),
(250, 2, 'error add category', 'Error while saving category. Check form', 'back'),
(251, 1, 'error empty id', 'Ошибка. Ничего не выбрано', 'back'),
(252, 2, 'error empty id', 'Error. Nothing selected', 'back'),
(253, 1, 'success delete category', 'Категория успешно удалена', 'back'),
(254, 2, 'success delete category', 'Category has been successfully deleted', 'back'),
(255, 1, 'error not unique', 'Это значение в базе данных уже существует', 'back'),
(256, 2, 'error not unique', 'This value already exists in the database', 'back'),
(257, 1, 'error delete category', 'Ошибка. Ничего не выбрано', 'back'),
(258, 2, 'error delete category', 'Error. Nothing selected', 'back'),
(259, 1, 'sort', 'Сортировка', 'back'),
(260, 2, 'sort', 'Sorting', 'back'),
(261, 1, 'menu brand', 'Бренды', 'back'),
(262, 2, 'menu brand', 'Brands', 'back'),
(263, 1, 'brand page', 'Бренды', 'back'),
(264, 2, 'brand page', 'Developers', 'back'),
(265, 1, 'brand list', 'Бренды', 'back'),
(266, 2, 'brand list', 'Developers List', 'back'),
(267, 1, 'add brand', 'Добавить бренд', 'back'),
(268, 2, 'add brand', 'Add Developer', 'back'),
(269, 1, 'brand name', 'Название', 'back'),
(270, 2, 'brand name', 'Name', 'back'),
(272, 2, 'project use', 'Use', 'back'),
(274, 2, 'project life style', 'Life Style', 'back'),
(276, 2, 'project use 1', 'Residential', 'back'),
(278, 2, 'project use 2', 'Commercial', 'back'),
(280, 2, 'project life style 1', 'Standard', 'back'),
(282, 2, 'project life style 2', 'Luxury', 'back'),
(283, 1, 'product name', 'Название', 'back'),
(284, 2, 'product name', 'Name', 'back'),
(285, 1, 'product category', 'Категория', 'back'),
(286, 2, 'product category', 'Area', 'back'),
(287, 1, 'product brand', 'Бренд', 'back'),
(288, 2, 'product brand', 'Developer', 'back'),
(289, 1, 'product price', 'Цена', 'back'),
(290, 2, 'product price', 'Price', 'back'),
(291, 1, 'menu slider', 'Слайдер', 'back'),
(292, 2, 'menu slider', 'Slider', 'back'),
(293, 1, 'slide name', 'Название', 'back'),
(294, 2, 'slide name', 'Name', 'back'),
(295, 1, 'slide image', 'Изображение', 'back'),
(296, 2, 'slide image', 'image', 'back'),
(297, 1, 'slides list', 'Список слайдов', 'back'),
(298, 2, 'slides list', 'Slides list', 'back'),
(299, 1, 'add slide', 'Добавить слайд', 'back'),
(300, 2, 'add slide', 'Add slide', 'back'),
(301, 1, 'edit slide', 'Редактировать слайд', 'back'),
(302, 2, 'edit slide', 'Edit slide', 'back'),
(303, 1, 'slider page', 'Слайдер', 'back'),
(304, 2, 'slider page', 'Slider', 'back'),
(305, 1, 'projects', 'Все проекты', 'front'),
(306, 2, 'projects', 'All Projects', 'front'),
(307, 1, 'developers', 'Бренды', 'front'),
(308, 2, 'developers', 'Dubai Developers', 'front'),
(310, 2, 'areas', 'Dubai Areas', 'front'),
(311, 1, 'promotions', 'Акции', 'front'),
(312, 2, 'promotions', 'Promotions', 'front'),
(313, 1, 'map view', 'Карта', 'front'),
(314, 2, 'map view', 'Map View', 'front'),
(315, 1, 'add product', 'Добавить товар', 'back'),
(316, 2, 'add product', 'Add product', 'back'),
(317, 1, 'edit product', 'Редактировать товар', 'back'),
(318, 2, 'edit product', 'Edit product', 'back'),
(319, 1, 'product list', 'Список товаров', 'back'),
(320, 2, 'product list', 'Products list', 'back'),
(321, 1, 'product page', 'Продукция', 'back'),
(322, 2, 'product page', 'Products', 'back'),
(323, 1, 'logo', 'Logo', 'front'),
(324, 1, 'product quantity', 'Запас', 'back'),
(325, 1, 'date modify', 'Дата изм.', 'back'),
(326, 1, 'price', 'Цена', 'back'),
(327, 1, 'product unit', 'Ед.измер.', 'back'),
(328, 1, 'categories', 'Категории', 'front'),
(329, 1, 'my account', 'Мой аккаунт', 'front'),
(330, 1, 'contacts', 'Контакты', 'front'),
(331, 1, 'orders', 'Заказы', 'front'),
(332, 1, 'account', 'Аккаунт', 'front'),
(334, 1, 'company name', 'Название компании', 'back'),
(335, 1, 'username', 'Имя пользователя', 'back'),
(336, 1, 'user page', 'Пользователи', 'back'),
(337, 1, 'add user', 'Добавить пользователя', 'back'),
(338, 1, 'edit user', 'Редактировать пользователя', 'back'),
(339, 1, 'usergroup 1', 'Главный администратор', 'back'),
(340, 1, 'usergroup 2', 'Администратор', 'back'),
(341, 1, 'usergroup 3', 'Модератор', 'back'),
(342, 1, 'usergroup 4', 'Менеджер', 'back'),
(343, 1, 'user type', 'Роль', 'back'),
(344, 1, 'user balance', 'Средства', 'back'),
(345, 1, 'fio', 'Ф.И.О.', 'back'),
(346, 1, 'user name', 'Название', 'back'),
(347, 1, 'email', 'E-mail', 'back'),
(348, 1, 'firstname', 'Имя', 'back'),
(349, 1, 'lastname', 'Фамилия', 'back'),
(350, 1, 'middlename', 'Отчество', 'back'),
(351, 1, 'inn', 'ИНН', 'back'),
(352, 1, 'contract number', 'Номер договора', 'back'),
(353, 1, 'contract date start', 'Дата начала действия договора', 'back'),
(354, 1, 'contract date end', 'Дата конца действия договора', 'back'),
(355, 1, 'address jur', 'Юридический адрес', 'back'),
(356, 1, 'address phy', 'Физический адрес', 'back'),
(357, 1, 'license number', 'Номер лицензии', 'back'),
(358, 1, 'license date end', 'Дата окончания действия лицензии', 'back'),
(359, 1, 'phone', 'Телефон', 'back'),
(360, 1, 'upload avatar', 'Загрузить аватарку', 'back'),
(361, 1, 'new password', 'Новый пароль', 'back'),
(362, 1, 'error not username', 'Некорректное имя пользователя', 'back'),
(363, 1, 'error empty', 'Обязательное поле', 'back'),
(364, 1, 'error not unique', 'В базе уже есть такая запись', 'back'),
(365, 1, 'success add user', 'Пользователь успешно добавлен', 'back'),
(366, 1, 'success edit user', 'Пользователь успешно сохранен', 'back'),
(367, 1, 'error add user', 'Ошибка при добавлении пользователя', 'back'),
(368, 1, 'error edit user', 'Ошибка при редактировании пользователя', 'back'),
(369, 1, 'error not email', 'Некорректный e-mail', 'back'),
(370, 1, 'error not allowed file', 'Такой файл запрещен к загрузке', 'back'),
(371, 1, 'order status 1', 'Ожидание', 'back'),
(372, 1, 'order status 2', 'Обработка', 'back'),
(373, 1, 'order status 3', 'Выполнен', 'back'),
(374, 1, 'order status 4', 'Отменен', 'back'),
(375, 1, 'info', 'Инфо', 'back'),
(376, 1, 'date', 'Дата', 'back'),
(377, 1, 'id', 'ID', 'back'),
(378, 1, 'user id', 'ID пользователя', 'back'),
(379, 1, 'from', 'От', 'back'),
(380, 1, 'total', 'Итого', 'back'),
(381, 1, 'currency', 'у.е.', 'back'),
(382, 1, 'unit', 'шт', 'back'),
(383, 1, 'line total', 'Итого', 'back'),
(384, 1, 'dover', 'Доверенность', 'back'),
(385, 1, 'dover_date', 'Дата доверенности', 'back'),
(386, 1, 'comment', 'Коментарий', 'back'),
(387, 1, 'quantity', 'Количество', 'back'),
(388, 1, 'success add order', 'Заказ успешно добавлен', 'back'),
(389, 1, 'success edit order', 'Заказ успешно сохранен', 'back'),
(390, 1, 'error add order', 'Ошибка при добавлении заказа', 'back'),
(391, 1, 'error edit order', 'Ошибка при изменении заказа', 'back'),
(392, 1, 'member since', 'Дата регистрации', 'back'),
(393, 1, 'similar products', 'Похожие товары', 'front'),
(394, 1, 'latest products', 'Новые', 'front'),
(395, 1, 'upload images', 'Загрузить картинки', 'back'),
(396, 1, 'online', 'онлайн', 'back'),
(397, 1, 'login page', 'Вход в панель управления', 'back'),
(398, 1, 'new orders', 'Новых заказов', 'back'),
(399, 1, 'more info', 'Далее', 'back'),
(400, 1, 'bases', 'Баз', 'back'),
(401, 1, 'products2', 'Товаров', 'back'),
(402, 1, 'sale leader', 'Лидер продаж', 'back'),
(403, 1, 'sales monthly', 'Продажи по месяцам', 'back'),
(404, 1, 'sales by category', 'Продажи по категориям', 'back'),
(405, 1, 'calendar', 'Календарь', 'back'),
(406, 1, 'quantity', 'Количество', 'back'),
(407, 1, 'sum', 'Сумма', 'back'),
(408, 1, 'add to cart', 'Добавить в корзину', 'front'),
(409, 1, 'stock 1', 'Остаток', 'back'),
(410, 1, 'stock 2', 'Остаток 2', 'back'),
(411, 1, 'stock 3', 'Остаток 3', 'back'),
(412, 1, 'cart', 'Корзина', 'front'),
(413, 1, 'product', 'Товар', 'front'),
(414, 1, 'price', 'Цена', 'front'),
(415, 1, 'quantity', 'Количество', 'front'),
(416, 1, 'line total', 'Итог', 'front'),
(417, 1, 'cart empty', 'Корзина пуста', 'front'),
(418, 1, 'total', 'Итого', 'front'),
(419, 1, 'checkout', 'Оформление заказа', 'front'),
(420, 1, 'choose stock', 'выбрать склад', 'front'),
(421, 1, 'go shopping cart', 'Перейти в корзину', 'front'),
(422, 1, 'continue shopping', 'Продолжить покупки', 'front'),
(423, 1, 'product add to cart success', 'Товар успешно добавлен в корзину', 'front'),
(424, 1, 'product add to cart error', 'Ошибка при добавлении товара в корзину', 'front'),
(425, 1, 'product out of stock', 'Такого количества товара нет в наличии', 'front'),
(426, 1, 'in stock', 'В наличии', 'front'),
(427, 1, 'not enough', 'Недостаточно', 'front'),
(428, 1, 'checkout unavailable', 'Возникли проблемы с товарами в вашей корзине (указаны ниже).', 'front'),
(429, 1, 'go checkout', 'Перейти к оформлению', 'front'),
(430, 1, 'confirm checkout', 'Подтвердить заказ', 'front'),
(431, 1, 'cash available', 'Доступно средств', 'front'),
(432, 1, 'cash not available', 'Недостаточно средств', 'front'),
(434, 2, '404 not found', 'Oops! The Page you requested was not found!', 'front'),
(435, 1, 'go home', 'Перейти на главную', 'front'),
(436, 1, 'use search', 'Воспользуйтесь поиском', 'front'),
(437, 1, 'or', 'или', 'front'),
(438, 1, 'login', 'Войти', 'front'),
(439, 1, 'username', 'Имя пользователя', 'front'),
(440, 1, 'password', 'Пароль', 'front'),
(441, 1, 'logout', 'Выйти', 'front'),
(442, 1, 'payment details', 'Детали оплаты', 'front'),
(443, 1, 'additional information', 'Дополнительная информация', 'front'),
(444, 1, 'your order', 'Ваш заказ', 'front'),
(445, 1, 'lastname', 'Фамилия', 'front'),
(446, 1, 'firstname', 'Имя', 'front'),
(447, 1, 'middlename', 'Отчество', 'front'),
(448, 1, 'order comment', 'Примечание к заказу', 'front'),
(449, 1, 'order comment full', 'Примечания к вашему заказу, например, особые пожелания отделу заказов.', 'front'),
(450, 1, 'doverennost', 'Доверенность', 'front'),
(451, 1, 'from', 'от', 'front'),
(452, 1, 'phone', 'Телефон', 'front'),
(453, 1, 'contract balance', 'Сумма по договору', 'front'),
(454, 1, 'contract balance available', 'Доступно средств по договору', 'front'),
(455, 1, 'not enough balance', 'У вас недостаточно средств для оформления этого заказа', 'front'),
(456, 1, 'error empty', 'Обязательное поле', 'front'),
(457, 1, 'contract period', 'Срок действия договора', 'front'),
(458, 1, 'order page', 'Заказы', 'back'),
(459, 1, 'stock', 'Склад', 'back'),
(460, 1, 'order', 'Заказ', 'front'),
(461, 1, 'order info', 'Информация о заказе', 'front'),
(462, 1, 'client info', 'Информация о клиенте', 'front'),
(463, 1, 'payment address', 'Платёжный адрес', 'front'),
(468, 1, 'back to cart', 'вернуться в корзину', 'front'),
(469, 1, 'search', 'Поиск', 'front'),
(470, 1, 'found', 'Найдено', 'front'),
(471, 1, 'nothing found', 'Ничего не найдено', 'front'),
(472, 1, 'new products', 'Новые товары', 'front'),
(473, 1, 'success delete order', 'Заказ успешно удален', 'back'),
(474, 1, 'edit order', 'Редактировать заказ', 'back'),
(475, 1, 'add order', 'Добавить заказ', 'back'),
(476, 1, 'error edit slider', 'Ошибка при редактировании слайда', 'back'),
(477, 1, 'success edit slider', 'Слайд успешно изменен', 'back'),
(478, 1, 'error add slider', 'Ошибка при добавлении слайда', 'back'),
(479, 1, 'success add slider', 'Слайд успешно добавлен', 'back'),
(480, 1, 'page name', 'Название страницы', 'back'),
(481, 2, 'page name', 'Page name', 'back'),
(482, 1, 'page text name', 'Название для текста', 'back'),
(483, 2, 'page text name', 'Name for text', 'back'),
(484, 1, 'page nav name', 'Название для навигации', 'back'),
(485, 2, 'page nav name', 'Name for navigation', 'back'),
(486, 1, 'controller', 'Контроллер', 'back'),
(487, 2, 'controller', 'Controller', 'back'),
(488, 1, 'side', 'front/back', 'back'),
(489, 2, 'side', 'front/back', 'back'),
(490, 1, 'layout', 'Шаблон', 'back'),
(491, 2, 'layout', 'Layout', 'back'),
(492, 1, 'go site', 'Перейти на сайт', 'back'),
(493, 2, 'go site', 'Go to the site', 'back'),
(494, 1, 'additional settings', 'Дополнительные настройки', 'back'),
(495, 2, 'additional settings', 'Additional settings', 'back'),
(496, 1, 'common settings', 'Общие настройки', 'back'),
(497, 2, 'common settings', 'Common settings', 'back'),
(498, 1, 'settings', 'Настройки', 'back'),
(499, 2, 'settings', 'Settings', 'back'),
(500, 1, 'option name', 'Название опции', 'back'),
(501, 2, 'option name', 'Option name', 'back'),
(502, 1, 'option content', 'Содержимое', 'back'),
(503, 2, 'option content', 'Content', 'back'),
(504, 1, 'option comment', 'Комментарий', 'back'),
(505, 2, 'option comment', 'Сomment', 'back'),
(506, 1, 'error add option', 'Ошибка при добавлении опции', 'back'),
(507, 2, 'error add option', 'Error adding option', 'back'),
(508, 1, 'error edit option', 'Ошибка при редактировании опции', 'back'),
(509, 2, 'error edit option', 'Error editing option', 'back'),
(510, 1, 'success add option', 'Опция успешно добавлена', 'back'),
(511, 2, 'success add option', 'Option has been successfully added', 'back'),
(512, 1, 'success edit option', 'Опция успешно изменена', 'back'),
(513, 2, 'success edit option', 'Option has been successfully edited', 'back'),
(514, 1, 'add option', 'Добавить опцию', 'back'),
(515, 2, 'add option', 'Add option', 'back'),
(516, 1, 'edit option', 'Редактировать опцию', 'back'),
(517, 2, 'edit option', 'Edit option', 'back'),
(518, 1, 'option page', 'Опции', 'back'),
(519, 2, 'option page', 'Options', 'back'),
(520, 1, 'site under maintenance', 'Сайт в режиме обслуживания', 'back'),
(521, 2, 'site under maintenance', 'Site under maintenance', 'back'),
(522, 1, 'maintenance mode', 'Режим обслуживания', 'back'),
(523, 2, 'maintenance mode', 'Maintenance mode', 'back'),
(524, 1, 'cache size', 'Размер кеша', 'back'),
(525, 2, 'cache size', 'Cache size', 'back'),
(526, 1, 'clean', 'Очистить', 'back'),
(527, 2, 'clean', 'Clean', 'back'),
(528, 1, 'control', 'Управление', 'back'),
(529, 2, 'control', 'Control', 'back'),
(530, 1, 'requisites', 'Реквизиты', 'back'),
(531, 1, 'requisites', 'Реквизиты', 'front'),
(532, 1, 'your balance', 'Ваш баланс', 'front'),
(533, 1, 'contract year', 'Год', 'back'),
(534, 1, 'contract number', 'Номер контракта', 'back'),
(535, 1, 'add usercontract', 'Добавить контракт', 'back'),
(536, 1, 'edit usercontract', 'Редактировать контракт', 'back'),
(537, 1, 'usercontract page', 'Контракты', 'back'),
(538, 1, 'usercontract list', 'Список контрактов', 'back'),
(539, 1, 'menu usercontract', 'Контракты', 'back'),
(540, 1, 'usergroup 5', 'Учители', 'back'),
(541, 1, 'usergroup 6', 'Пользователь', 'back'),
(542, 1, 'error add usercontract', 'Ошибка при добавлении контракта', 'back'),
(543, 2, 'error add usercontract', 'Error while adding contract', 'back'),
(544, 1, 'error edit usercontract', 'Ошибка при редактриовании контракта', 'back'),
(545, 2, 'error edit usercontract', 'Error while editing contract', 'back'),
(546, 1, 'success add usercontract', 'Контракт успешно добавлен', 'back'),
(547, 2, 'success add usercontract', 'Contract has been successfully added', 'back'),
(548, 1, 'success edit usercontract', 'Контракт успешно изменен', 'back'),
(549, 2, 'success edit usercontract', 'Contract has been successfully edited', 'back'),
(550, 1, 'quarter', 'Квартал', 'back'),
(551, 1, 'menu stats', 'Статистика', 'back'),
(552, 2, 'menu stats', 'Statistics', 'back'),
(553, 1, 'contract completion', 'Контракты', 'back'),
(554, 2, 'contract completion', 'Contracts', 'back'),
(555, 1, 'stats page', 'Статистика', 'back'),
(556, 2, 'stats page', 'Statistics', 'back'),
(557, 1, 'btn view', 'Просмотр', 'back'),
(558, 2, 'btn view', 'View', 'back'),
(559, 1, 'by contract', 'По конт.', 'back'),
(560, 2, 'by contract', 'By cont.', 'back'),
(561, 1, 'in fact', 'По факту', 'back'),
(562, 2, 'in fact', 'In fact', 'back'),
(563, 1, 'difference', 'Разница', 'back'),
(564, 2, 'difference', 'Differ.', 'back'),
(565, 1, 'year', 'Год', 'back'),
(566, 2, 'year', 'Year', 'back'),
(567, 1, 'filter', 'Фильтр', 'back'),
(568, 2, 'filter', 'Filter', 'back'),
(569, 1, 'go admin', 'Перейти в админку', 'front'),
(570, 1, 'print', 'Печать', 'back'),
(571, 2, 'print', 'Print', 'back'),
(572, 1, 'no orders', 'Нет заказов', 'back'),
(573, 2, 'no orders', 'No orders', 'back'),
(574, 1, 'usercontract', 'Контракт', 'back'),
(575, 2, 'usercontract', 'Contract', 'back'),
(576, 1, 'all usercontracts', 'Все контракты', 'back'),
(577, 2, 'all usercontracts', 'All contracts', 'back'),
(578, 1, 'success delete user', 'Пользователь успешно удален', 'back'),
(579, 2, 'success delete user', 'User has been successfully deleted', 'back'),
(580, 1, 'error delete user', 'Ошибка при удалении пользователя', 'back'),
(581, 2, 'error delete user', 'Error while deleting user', 'back'),
(582, 1, 'sales', 'Продажи', 'back'),
(583, 2, 'sales', 'Sales', 'back'),
(584, 1, 'in fact quantity', 'Количество', 'back'),
(585, 2, 'in fact quantity', 'Quantity', 'back'),
(586, 1, 'in fact sum', 'Сумма', 'back'),
(587, 2, 'in fact sum', 'Sum', 'back'),
(588, 1, 'period', 'Период', 'back'),
(589, 2, 'period', 'Period', 'back'),
(590, 1, 'choose period', 'Выбрать период', 'back'),
(591, 2, 'choose period', 'Choose period', 'back'),
(592, 1, 'price for item', 'Цена за шт', 'back'),
(593, 1, 'price for block', 'Цена за блок', 'back'),
(594, 1, 'price for dal', 'Цена за декалитр', 'back'),
(595, 1, 'unit in block', 'шт в блоке', 'back'),
(596, 1, 'unit in dal', 'шт в декалитре', 'back'),
(597, 1, 'unit_dal', 'дал', 'back'),
(598, 1, 'error not int', 'Должно быть целым числом', 'back'),
(599, 1, 'error add product', 'Ошибка при добавлении товара', 'back'),
(600, 2, 'error add product', 'Error while adding product', 'back'),
(601, 1, 'error edit product', 'Ошибка при редактировании товара', 'back'),
(602, 2, 'error edit product', 'Error while editing product', 'back'),
(603, 1, 'success add product', 'Товар успешно добавлен', 'back'),
(604, 2, 'success add product', 'Product has been successfully added', 'back'),
(605, 1, 'success edit product', 'Товар успешно изменен', 'back'),
(606, 2, 'success edit product', 'Product has been successfully edited', 'back'),
(607, 1, 'excise', 'Акциз', 'back'),
(608, 1, 'nds', 'НДС, %', 'back'),
(609, 1, 'price for item original', '', 'back'),
(610, 1, 'checking account', 'Расчетный счет', 'back'),
(611, 1, 'ch.acc.', 'Р/сч', 'back'),
(612, 1, 'mfo', 'МФО', 'back'),
(613, 1, 'okonx', 'ОКОНХ', 'back'),
(614, 1, 'invoice', 'Счет фактура', 'back'),
(615, 1, 'invoice-waybill', 'Счет фактура накладная', 'back'),
(616, 1, 'chief director', 'Руководитель', 'back'),
(617, 1, 'chief accountant', 'Гл.Бухгалтер', 'back'),
(618, 1, 'goods released', 'Товар отпустил', 'back'),
(619, 1, 'goods accepted', 'Получил', 'back'),
(620, 1, 'through', 'через', 'back'),
(621, 1, 'cargo accepted to shipping', 'Груз к отправке принял', 'back'),
(622, 1, 'car state number', 'Автомобиль гос. номер', 'back'),
(623, 1, 'goods released sum', 'Всего отпущено на сумму', 'back'),
(624, 1, 'total payment', 'всего к оплате', 'back'),
(625, 1, 'qty', 'Кол-во', 'back'),
(626, 1, 'prod. unit', 'Ед.изм.', 'back'),
(627, 1, 'total with nds', 'Всего с НДС', 'back'),
(628, 1, 'total original', 'Стоимость поставки', 'back'),
(629, 1, 'for item', 'на ед', 'back'),
(630, 1, 'recipient', 'Получатель', 'back'),
(631, 1, 'supplier', 'Поставщик', 'back'),
(632, 1, 'options list', 'Список опций', 'back'),
(633, 1, 'accepted', 'Получил', 'back'),
(634, 1, 'bank name', 'Банк', 'back'),
(635, 1, 'address', 'Адрес', 'back'),
(636, 1, 'receipent', 'Получатель', 'back'),
(637, 1, 'price for item original', 'Цена - стоимость', 'back'),
(638, 2, 'page name', 'Page name', 'back'),
(639, 1, 'page name', 'Название страницы', 'back'),
(640, 2, 'edit page', 'Edit page', 'back'),
(641, 1, 'edit page', 'Редактировать страницу', 'back'),
(642, 2, 'add page', 'Add page', 'back'),
(643, 1, 'add page', 'Добавить страницу', 'back'),
(644, 2, 'page list', 'Pages list', 'back'),
(645, 1, 'page list', 'Список страниц', 'back'),
(646, 2, 'page page', 'Pages', 'back'),
(647, 1, 'page page', 'Страницы', 'back'),
(648, 2, 'error add page', 'Error adding Page', 'back'),
(649, 1, 'error add page', 'Ошибка при добавлении Страницы', 'back'),
(650, 2, 'error edit page', 'Error editing Page', 'back'),
(651, 1, 'error edit page', 'Ошибка при редактировании Страницы', 'back'),
(652, 2, 'success add page', 'Page has been successfully added', 'back'),
(653, 1, 'success add page', 'Страница успешно добавлена', 'back'),
(654, 2, 'success edit page', 'Page has been successfully edited', 'back'),
(655, 1, 'success delete product', 'Товар успешно удален', 'back'),
(656, 2, 'success delete product', 'Product has been successfully deleted', 'back'),
(657, 1, 'success edit page', 'Страница успешно изменена', 'back'),
(658, 2, 'success edit page', 'Page has been successfully added', 'back'),
(659, 1, 'success add brand', 'Бренд успешно добавлен', 'back'),
(660, 2, 'success add brand', 'Brand has been successfully added', 'back'),
(661, 1, 'success edit brand', 'Бренд успешно изменен', 'back'),
(662, 2, 'success edit brand', 'Brand has been successfully edited', 'back'),
(663, 1, 'success delete brand', 'Бренд успешно удален', 'back'),
(664, 2, 'success delete brand', 'Brand has been successfully deleted', 'back'),
(665, 1, 'error add brand', 'Ошибка при добавлении бренда', 'back'),
(666, 2, 'error add brand', 'Error while adding brand', 'back'),
(667, 1, 'error edit brand', 'Ошибка при редактировании бренда', 'back'),
(668, 2, 'error edit brand', 'Error while editing brand', 'back'),
(669, 1, 'error delete brand', 'Ошибка при удалении бренда', 'back'),
(670, 2, 'error delete brand', 'Error while deleting brand', 'back'),
(671, 1, 'edit brand', 'Редактировать бренд', 'back'),
(672, 2, 'edit brand', 'Edit brand', 'back'),
(673, 1, 'price base', 'Базовая цена', 'back'),
(674, 2, 'price base', 'Base price', 'back'),
(675, 1, 'price show', 'Цена', 'back'),
(676, 2, 'price show', 'Show price', 'back'),
(677, 1, 'choose filter', 'Выберите фильтр', 'back'),
(678, 2, 'choose filter', 'Сhoose filter', 'back'),
(679, 1, 'new radio option', 'Новая радио опция', 'back'),
(680, 2, 'new radio option', 'New radio option', 'back'),
(681, 1, 'new checkbox option', 'Новая чекбокс опция', 'back'),
(682, 2, 'new checkbox option', 'New checkbox option', 'back'),
(683, 1, 'new select option', 'Новая селект опция', 'back'),
(684, 2, 'new select option', 'New select option', 'back'),
(685, 1, 'option group name', 'Название группы опций', 'back'),
(686, 2, 'option group name', 'Option group name', 'back'),
(687, 1, 'option group values', 'Значения группы опций', 'back'),
(688, 2, 'option group values', 'Option group values', 'back'),
(689, 1, 'option price', 'Цена', 'back'),
(690, 2, 'option price', 'Price', 'back'),
(691, 1, 'product category type', 'Тип', 'back'),
(692, 2, 'product category type', 'Type', 'back'),
(693, 1, 'product options', 'Опции товара', 'back'),
(694, 2, 'product options', 'Product options', 'back'),
(695, 1, 'menu page', 'Страницы', 'back'),
(696, 2, 'menu page', 'Pages', 'back'),
(697, 1, 'menu filter', 'Фильтры товаров', 'back'),
(698, 2, 'menu filter', 'Product filters', 'back'),
(699, 1, 'filter page', 'Фильтры', 'back'),
(700, 2, 'filter page', 'Filters', 'back'),
(701, 1, 'filter list', 'Список фильтров', 'back'),
(702, 2, 'filter list', 'Filter list', 'back'),
(703, 1, 'filter name', 'Название фильтра', 'back'),
(704, 2, 'filter name', 'Filter name', 'back'),
(705, 1, 'add filter', 'Добавить фильтр', 'back'),
(706, 2, 'add filter', 'Add filter', 'back'),
(707, 1, 'edit filter', 'Редактировать фильтр', 'back'),
(708, 2, 'edit filter', 'Edit filter', 'back'),
(709, 1, 'filter value page', 'Значения фильтров', 'back'),
(710, 2, 'filter value page', 'Filter values', 'back'),
(711, 1, 'filter value list', 'Список значений фильтров', 'back'),
(712, 2, 'filter value list', 'Filter value list', 'back'),
(713, 1, 'filter value parent', 'Фильтр', 'back'),
(714, 2, 'filter value parent', 'Filter', 'back'),
(715, 1, 'filter value name', 'Значение фильтра', 'back'),
(716, 2, 'filter value name', 'Filter value name', 'back'),
(717, 1, 'add filter value', 'Добавить значение фильтра', 'back'),
(718, 2, 'add filter value', 'Add filter value', 'back'),
(719, 1, 'edit filter value', 'Редактировать значение фильтра', 'back'),
(720, 2, 'edit filter value', 'Edit filter value', 'back'),
(721, 1, 'filter color ', 'Цвет для фильтра', 'back'),
(722, 2, 'filter color ', 'Color for filter', 'back'),
(723, 1, 'sku', 'СКУ', 'back'),
(724, 2, 'sku', 'SKU', 'back'),
(725, 1, 'discount', 'Скидка', 'back'),
(726, 2, 'discount', 'Discount', 'back'),
(727, 1, 'tags', 'Теги', 'back'),
(728, 2, 'tags', 'Tags', 'back'),
(729, 1, 'register', 'Регистрация', 'front'),
(730, 2, 'register', 'Register', 'front'),
(731, 1, 'email', 'E-mail', 'front'),
(732, 2, 'email', 'E-mail', 'front'),
(733, 1, 'name', 'Имя', 'front'),
(734, 2, 'name', 'Name', 'front'),
(735, 1, 'password2', 'Повторите пароль', 'front'),
(736, 2, 'password2', 'Confirm password ', 'front'),
(737, 1, 'auth', 'Авторизация', 'front'),
(738, 2, 'auth', 'Auth', 'front'),
(739, 1, 'send', 'Отправить', 'front'),
(740, 2, 'send', 'Send', 'front'),
(741, 1, 'product details', 'Описание товара', 'front'),
(742, 2, 'product details', 'Product details', 'front'),
(743, 1, 'manufacturer details', 'Производитель', 'front'),
(744, 2, 'manufacturer details', 'Manufacturer details', 'front'),
(745, 1, 'success add filter value', 'Значение фильтра успешно добавлено', 'back'),
(746, 2, 'success add filter value', 'Filter value has been successfully added', 'back'),
(747, 1, 'success edit filter value', 'Значение фильтра успешно изменена', 'back'),
(748, 2, 'success edit filter value', 'Filter value has been successfully edited', 'back'),
(749, 1, 'error add filter value', 'Ошибка при добавлении значения фильтра', 'back'),
(750, 2, 'error add filter value', 'Error while adding filter value', 'back'),
(751, 1, 'error edit filter value', 'Ошибка при редактировании значения фильтра', 'back'),
(752, 2, 'error edit filter value', 'Error while editing filter value', 'back'),
(753, 1, 'filter color', 'Значение для фильтра цвет', 'back'),
(754, 2, 'filter color', 'Value for filter color', 'back'),
(755, 1, 'success add filter', 'Фильтр успешно добавлен', 'back'),
(756, 2, 'success add filter', 'Filter has been successfully added', 'back'),
(757, 1, 'success edit filter', 'Фильтр успешно изменен', 'back'),
(758, 2, 'success edit filter', 'Filter has been successfully edited', 'back'),
(759, 1, 'error add filter', 'Ошибка при добавлении фильтра', 'back'),
(760, 2, 'error add filter', 'Error while adding filter', 'back'),
(761, 1, 'error edit filter', 'Ошибка при редактировании фильтра', 'back'),
(762, 2, 'error edit filter', 'Error while editing filter', 'back'),
(763, 2, 'order 5', 'name z-a', 'front'),
(764, 1, 'order 5', 'по названию я-а', 'front'),
(765, 2, 'order 4', 'name', 'front'),
(766, 1, 'order 4', 'по названию', 'front'),
(767, 2, 'order 3', 'date', 'front'),
(768, 1, 'order 3', 'по новинкам', 'front'),
(769, 2, 'order 2', 'date', 'front'),
(770, 1, 'order 2', 'по дате f-l', 'front'),
(771, 2, 'order 1', 'views', 'front'),
(772, 1, 'order 1', 'по популярности', 'front'),
(773, 1, 'fio', 'Ф.И.О.', 'front'),
(774, 1, 'address', 'Адрес', 'front'),
(775, 1, 'shipping address', 'Адрес доставки', 'front'),
(776, 1, 'order view', 'Просмотр заказа', 'front'),
(777, 1, 'searching', 'Я ищу', 'front'),
(778, 1, 'date', 'Дата', 'front'),
(779, 1, 'no products', 'Товаров нет', 'front'),
(780, 1, 'error delete filter', 'Ошибка при удалении филтьтра', 'back'),
(781, 2, 'error delete filter', 'Error while deleteing filter', 'back'),
(782, 1, 'success delete filter', 'Фильтр успешно удален', 'back'),
(783, 2, 'success delete filter', 'Filter has been successfully deleted', 'back'),
(784, 1, 'error delete option', 'Ошибка при удалении опции', 'back'),
(785, 2, 'error delete option', 'Error while deleteing option', 'back'),
(786, 1, 'success delete option', 'Опция успешно удалена', 'back'),
(787, 2, 'success delete option', 'Option has been successfully deleted', 'back'),
(788, 1, 'you have been registered in', 'Вы зарегистрированны в', 'front'),
(789, 1, 'your login', 'Ваш логин', 'front'),
(790, 1, 'tour password', 'Ваш пароль', 'front'),
(791, 1, 'click link below to activate your account', 'Для подтверждения регистрации, нажмите пожалуйста на ссылку:', 'front'),
(792, 1, 'error while activating account', 'Ошибка при активации аккаунта!', 'front'),
(793, 1, 'account has been successfully activated', 'Ваш аккаунт успешно активирован!', 'front'),
(794, 1, 'error account hasnt been activated yet', 'Аккаунт не активирован', 'front'),
(795, 1, 'error no such username', 'Такого пользователя не существует', 'front'),
(796, 1, 'error password empty', 'Введите пароль', 'front'),
(797, 1, 'error password', 'Неправильный пароль', 'front'),
(798, 1, 'error name empty', 'Заполните это поле', 'front'),
(799, 1, 'error username already exist', 'Такой пользователь уже зарегистрирован', 'front'),
(800, 1, 'error password repeat empty', 'Подтвердите пароль', 'front'),
(801, 1, 'error passwords not equal', 'Пароли не совпадают', 'front'),
(802, 1, 'error not email', 'Введите ваш E-mail', 'front'),
(803, 1, 'register success confirm email', 'Вы успешно зарегистрированы! <br> На введённый Вами Email-адрес %s отправлено письмо со ссылкой, по которой Вы можете перейти, чтобы подтвердить свой Email.<br><br>Если вы не получили письмо проверьте папку Спам! Письмо могло попасть туда.', 'front'),
(804, 1, 'option value name', 'Значение', 'back'),
(805, 2, 'option value name', 'Value', 'back'),
(806, 1, 'specifications', 'Характеристики', 'back'),
(807, 1, 'specifications', 'Характеристики', 'front'),
(808, 1, 'checkout success', 'Ваш заказ принят!', 'front'),
(809, 1, 'your order ID', 'Номер вашего заказа', 'front'),
(810, 1, 'add comment', 'Добавить комментарий', 'back'),
(811, 1, 'new color option', 'Новая цветовая опция', 'back'),
(812, 1, 'option color', 'Цвет', 'back'),
(813, 1, 'order deleted', 'Заказ удален', 'back'),
(814, 1, 'order status 0', 'Заказ удален', 'back'),
(815, 1, 'all rights reserved', 'Все права защищены', 'front'),
(816, 1, 'get offers', 'Узнайте о выгодных предложениях', 'front'),
(817, 1, 'current status', 'Текущий статус', 'front'),
(818, 1, 'subscription', 'Подписка', 'front'),
(819, 1, 'customer service', 'Сервис', 'front'),
(820, 1, 'my account', 'Мой профиль', 'front'),
(821, 1, 'information', 'Информация', 'front'),
(822, 1, 'for user', 'Для пользователя', 'front'),
(823, 1, 'your email', 'Ваша электронная почта', 'front'),
(824, 1, 'developer', 'Разработка', 'front'),
(825, 1, 'tech service', 'Тех.поддержка', 'front'),
(826, 1, 'my account page', 'Личный кабинет', 'front'),
(827, 1, 'orders history', 'История заказов', 'front'),
(828, 1, 'featured products', 'Избранные товары', 'front'),
(829, 1, 'manufacturers', 'Производители', 'front'),
(830, 1, 'affiliate program', 'Партнерская программа', 'front'),
(831, 1, 'gift certificates', 'Подарочные сертификаты', 'front'),
(832, 1, 'our promotions', 'Наши акции', 'front'),
(833, 1, 'terms of payment', 'Условия оплаты', 'front'),
(834, 1, 'shipping policy', 'Условия доставки', 'front'),
(835, 1, 'return policy', 'Условия возврата', 'front'),
(836, 1, 'privacy policy', 'Конфиденциальность', 'front'),
(837, 1, 'certificates and partners', 'Сертификаты и партнеры', 'front'),
(838, 1, 'filters', 'Фильтры', 'front'),
(839, 1, 'apply', 'Применить', 'front'),
(840, 1, 'clear filter', 'Очистить фильтр', 'front'),
(841, 1, 'subscribe', 'Подписаться', 'front'),
(842, 1, 'popular products tab', 'Популярные товары', 'front'),
(843, 1, 'new products tab', 'Новинки магазина', 'front'),
(844, 1, 'bestseller products tab', 'Хиты продаж', 'front'),
(845, 1, 'special products tab', 'Акции и скидки', 'front'),
(846, 1, 'product category type', 'Тип', 'back'),
(847, 2, 'product category type', 'Type', 'back'),
(848, 1, 'categoryType list', 'Список типов категорий', 'back'),
(849, 2, 'categoryType list', 'Category types list', 'back'),
(850, 1, 'add categoryType', 'Добавить тип категории', 'back'),
(851, 2, 'add categoryType', 'Add category type', 'back'),
(852, 1, 'edit categoryType', 'Редактировать тип категории', 'back'),
(853, 2, 'edit categoryType', 'Edit category type', 'back'),
(854, 1, 'categoryType name', 'Название', 'back'),
(855, 2, 'categoryType name', 'Name', 'back'),
(856, 1, 'category type', 'Тип категории', 'back'),
(857, 2, 'category type', 'Category type', 'back'),
(858, 1, 'error add categoryType', 'Ошибка при добавлении типа категории', 'back'),
(859, 2, 'error add categoryType', 'Error while adding category type', 'back'),
(860, 1, 'error edit categoryType', 'Ошибка при редактировании типа категории', 'back'),
(861, 2, 'error edit categoryType', 'Error while editing category type', 'back'),
(862, 1, 'success add categoryType', 'Тип категории успешно добавлен', 'back'),
(863, 2, 'success add categoryType', 'Category type has been successfully added', 'back'),
(864, 1, 'success edit categoryType', 'Тип категории успешно изменен', 'back'),
(865, 2, 'success edit categoryType', 'Category type has been successfully edited', 'back'),
(866, 1, 'order 7', 'высокие цены', 'front'),
(867, 1, 'order 6', 'низкие цены', 'front'),
(868, 1, 'order 5', 'по названию я-а', 'front'),
(869, 1, 'order 4', 'по названию', 'front'),
(870, 1, 'order 3', 'по новинкам', 'front'),
(871, 1, 'order 2', 'по дате f-l', 'front'),
(872, 1, 'order 1', 'по популярности', 'front'),
(873, 1, 'users2', 'Пользователи', 'back'),
(874, 1, 'translation page', 'Переводы', 'back'),
(875, 1, 'add word', 'Добавить слово', 'back'),
(876, 1, 'words list', 'Список слов', 'back'),
(877, 1, 'word', 'Слово', 'back'),
(878, 1, 'content', 'Контент', 'back'),
(886, 1, 'home', 'Главная', 'front'),
(887, 1, 'view all products', 'Смотреть все товары', 'front'),
(888, 1, 'success delete translation', 'Перевод успешно удален', 'back'),
(889, 1, 'tags', 'Теги', 'front'),
(890, 1, 'error email invalid', 'Неверный e-mail', 'front'),
(892, 1, 'option', 'Опция', 'back'),
(893, 1, 'uzs', 'UZS', 'front'),
(894, 1, 'translations', 'Переводы', 'back'),
(895, 1, '404 not found', '404 страница не найдена', 'front'),
(896, 1, 'info menu', 'Информация', 'front'),
(897, 1, 'alias', 'алиас', 'back'),
(898, 1, 'method', 'Метод/функция', 'back'),
(899, 1, 'useredit', 'Редактирование пользователя', 'back'),
(900, 1, 'sort.', 'сорт.', 'back'),
(901, 1, 'importproducts page', 'Загрузка файла', 'back'),
(902, 1, 'import products page', 'Загрузка файла', 'back'),
(903, 1, 'products file upload', 'Загрузка файла XML', 'back'),
(904, 1, 'choose file', 'Выберите файл', 'back'),
(905, 1, 'upload file', 'Загрузить файл', 'back'),
(906, 1, 'product', 'Продукт', 'back'),
(907, 1, 'success file importproducts', 'Файл успешно загружен', 'back'),
(908, 1, 'xml file upload', 'Экспорт/Импорт', 'back'),
(909, 1, 'by', 'по', 'front'),
(910, 1, 'send request', 'Отправить', 'front'),
(911, 1, 'your name', 'Ваше имя', 'front'),
(912, 1, 'your phone', 'Номер телефона', 'front'),
(913, 1, 'your request has been sent', 'Ваш запрос отправлен', 'front'),
(914, 1, 'please fill in required fields', 'Пожалуйста заполните все обязательные поля', 'front'),
(915, 1, 'go product', 'Перейти', 'front'),
(916, 1, 'page', 'Страница', 'back'),
(917, 1, 'you have been subscribed', 'Вы успешно подписаны', 'front'),
(918, 1, 'review', 'Отзыв', 'front'),
(919, 1, 'add review', 'Добавить отзыв', 'front'),
(920, 1, 'reviews', 'Отзывы', 'front'),
(921, 1, 'no reviews', 'Отзывов нет', 'front'),
(922, 1, 'your password', 'Пароль', 'front'),
(923, 1, 'no-reply', 'Без ответа', 'front'),
(924, 1, 'please fill in all fields', 'Пожалуйста заполните все поля', 'front'),
(925, 1, 'you review accepted', 'Ваш отзыв принят', 'front'),
(926, 1, 'review page', 'Отзывы', 'back'),
(927, 1, 'add review', 'Добавить отзыв', 'back'),
(928, 1, 'review list', 'Отзывы', 'back'),
(929, 1, 'name', 'Имя', 'back'),
(930, 1, 'message', 'Сообщение', 'back'),
(931, 1, 'menu review', 'Отзывы', 'back'),
(932, 1, 'edit review', 'Редактировать отзыв', 'back'),
(933, 1, 'review', 'Отзыв', 'back'),
(934, 1, 'reviewer name', 'Автор отзыва', 'back'),
(935, 1, 'success edit review', 'Отзыв успешно изменен', 'back'),
(936, 1, 'error edit review', 'Ошибка при редактировании отзыва', 'back'),
(937, 1, 'request product', 'Товар по запросу', 'back'),
(939, 1, 'new request product order', 'Новый запрос', 'front'),
(940, 1, 'order details', 'Детали заказа', 'front'),
(941, 1, 'view in admin panel', 'Смотреть в админ панели', 'front'),
(942, 1, 'order id', 'ID заказа', 'front'),
(944, 1, 'new product order', 'Новый заказ', 'front'),
(945, 1, 'your order has been accepted', 'Ваш заказ принят', 'front'),
(946, 1, 'thank you for your order. we ll contact you soon', 'Мы свяжемся с вами в ближайшее время', 'front'),
(947, 1, 'your request has been accepted', 'Ваш запрос принят', 'front'),
(948, 1, 'video code', 'Код видео', 'back'),
(949, 1, 'menu news', 'Новости', 'back'),
(950, 1, 'news page', 'Новости', 'back'),
(951, 1, 'add news', 'Добавить новость', 'back'),
(952, 1, 'news name', 'Название', 'back'),
(953, 1, 'edit news', 'Редактировать новость', 'back'),
(954, 1, 'news date', 'Дата новости', 'back'),
(955, 1, 'recommended size', 'Рекомендованный размер', 'back'),
(956, 1, 'success edit news', 'Новость успешно изменен', 'back'),
(957, 1, 'error edit news', 'Ошибка при редактировании новости', 'back'),
(958, 1, 'error add news', 'Ошибка при добавлении новости', 'back'),
(959, 1, 'success delete news', 'Новость успешно удален', 'back'),
(960, 1, 'success delete review', 'Отзыв успешно удален', 'back'),
(961, 1, 'video', 'Видео', 'front'),
(962, 1, 'delete confirm category', 'Подтвердить удаление категории', 'back'),
(963, 1, 'btn confirm', 'Подтвердить', 'back'),
(964, 1, 'move products to category', 'Переместить товары в категорию', 'back'),
(965, 1, 'products in category', 'Товары этой категории', 'front'),
(966, 1, 'products in category', 'Товары этой категории', 'back'),
(967, 1, 'delete products in category', 'Удалить товары в категории', 'back'),
(968, 1, 'move products in category to', 'Переместить товары в категорию', 'back'),
(969, 1, 'export products', 'Экспорт товаров', 'back'),
(970, 1, 'export', 'Экспорт', 'back'),
(971, 1, 'menu gallery', 'Галерея', 'back'),
(972, 1, 'gallery page', 'Галерея', 'back'),
(973, 1, 'add file', 'Добавить файл', 'back'),
(974, 1, 'gallery list', 'Галерея', 'back'),
(975, 1, 'image', 'Картинка', 'back'),
(976, 1, 'path', 'Путь', 'back'),
(977, 1, 'file name', 'Название файла', 'back'),
(978, 1, 'alt name', 'Альт название', 'back'),
(979, 1, 'success delete gallery', 'Галерея успешно удалена', 'back'),
(980, 1, 'success delete gallery file', 'Файл успешно удален', 'back'),
(981, 1, 'add gallery file', 'Добавить файл', 'back'),
(982, 1, 'file category product', 'Продукт', 'back'),
(983, 1, 'file category category', 'Категория', 'back'),
(984, 1, 'file category brand', 'Бренд', 'back'),
(985, 1, 'file category post', 'Запись', 'back'),
(986, 1, 'edit gallery file', 'Редактировать файл', 'back'),
(987, 1, 'gallery', 'Галерея', 'back'),
(988, 1, 'gallery name', 'Название (альт)', 'back'),
(989, 1, 'success edit gallery file', 'Файл успешно изменен', 'back'),
(990, 1, 'all', 'Все', 'back'),
(991, 1, 'brand', 'Бренд', 'back'),
(992, 1, 'post', 'Запись', 'back'),
(993, 1, 'common', 'Общий', 'back'),
(994, 1, 'default', 'По умолчанию', 'back'),
(995, 1, 'common jen', 'Общая', 'back'),
(996, 1, 'close', 'Закрыть', 'back'),
(997, 1, 'gallery images', 'Картинки из галереи', 'back'),
(998, 1, 'add from gallery', 'Добавить из галереи', 'back'),
(999, 1, 'added from gallery images', 'Добавлено из галереи', 'back');
INSERT INTO `mktb_translation` (`id`, `lang`, `name`, `content`, `context`) VALUES
(1000, 1, 'import products result page', 'Страница результатов импорта', 'back'),
(1001, 1, 'products import results', 'Результаты импорта', 'back'),
(1002, 1, 'error file importproducts', 'Ошибка при импорте товаров', 'back'),
(1003, 1, 'error alias exist', 'Алиас занят', 'back'),
(1004, 1, 'error sku empty', 'Введите СКУ (артикул) товара', 'back'),
(1005, 1, 'updated', 'Обновлен', 'back'),
(1006, 1, 'inserted', 'Добавлен', 'back'),
(1007, 1, 'errors', 'Ошибки', 'back'),
(1008, 1, 'error enter category ID', 'Введите ID категории', 'back'),
(1009, 1, 'products import errors', 'Ошибка при импорте товаров', 'back'),
(1010, 1, 'category show in', 'Показывать в', 'back'),
(1011, 1, 'category show in 1', 'Главное меню', 'back'),
(1012, 1, 'product up sells', 'Апселлы', 'back'),
(1013, 1, 'product cross sells', 'Кросселлы', 'back'),
(1014, 1, 'error username empty', 'Введите имя пользователя', 'front'),
(1015, 2, 'popular 1', 'popular 1', 'front'),
(1016, 2, 'popular 2', 'popular 2', 'front'),
(1017, 2, 'popular 3', 'popular 3', 'front'),
(1018, 2, 'popular 4', 'popular 4', 'front'),
(1019, 2, 'popular 5', 'popular 5', 'front'),
(1020, 2, 'popular 6', 'popular 6', 'front'),
(1021, 2, 'popular 7', 'popular 7', 'front'),
(1022, 2, 'popular products tab', 'popular products tab', 'front'),
(1023, 2, 'new products tab', 'new products tab', 'front'),
(1024, 2, 'bestseller products tab', 'bestseller products tab', 'front'),
(1025, 2, 'special products tab', 'special products tab', 'front'),
(1026, 2, 'uzs', 'uzs', 'front'),
(1027, 2, 'go product', 'go product', 'front'),
(1028, 2, 'home', 'home', 'front'),
(1029, 2, 'search', 'search', 'front'),
(1030, 2, 'password', 'password', 'front'),
(1031, 2, 'login', 'login', 'front'),
(1032, 2, 'product add to cart success', 'product add to cart success', 'front'),
(1033, 2, 'continue shopping', 'continue shopping', 'front'),
(1034, 2, 'go shopping cart', 'go shopping cart', 'front'),
(1035, 2, 'customer service', 'customer service', 'front'),
(1036, 2, 'information', 'information', 'front'),
(1037, 2, 'for user', 'for user', 'front'),
(1038, 2, 'my account page', 'my account page', 'front'),
(1039, 2, 'orders history', 'orders history', 'front'),
(1040, 2, 'subscription', 'subscription', 'front'),
(1041, 2, 'get offers', 'get offers', 'front'),
(1042, 2, 'your email', 'your email', 'front'),
(1043, 2, 'subscribe', 'subscribe', 'front'),
(1044, 2, 'all rights reserved', 'all rights reserved', 'front'),
(1045, 2, 'developer', 'developer', 'front'),
(1046, 2, 'new products', 'new products', 'front'),
(1047, 2, 'view all products', 'view all products', 'front'),
(1048, 1, 'all categories', 'Все категории', 'back'),
(1049, 1, 'all categories', 'Все категории', 'front'),
(1050, 1, 'edit slider', 'Изменить слайдер', 'back'),
(1051, 1, 'slider', 'Слайдер', 'back'),
(1052, 1, 'url', 'URL', 'back'),
(1053, 1, 'our projects', 'Наши проекты', 'front'),
(1054, 1, 'category show in 2', 'Главная страница', 'back'),
(1055, 1, 'category show in 3', 'Главное меню и главная страница', 'back'),
(1056, 1, 'rub', 'р.', 'front'),
(1057, 1, 'menu video', 'Видеоролики', 'back'),
(1058, 1, 'video page', 'Видеоролики', 'back'),
(1059, 1, 'add video', 'Добавить видео', 'back'),
(1060, 1, 'video list', 'Список видео', 'back'),
(1061, 1, 'video name', 'Название', 'back'),
(1062, 1, 'video date', 'Дата', 'back'),
(1063, 1, 'error add video', 'Ошибка при добавлении видео', 'back'),
(1064, 1, 'success add video', 'Видео успешно добавлен', 'back'),
(1065, 1, 'edit video', 'Изменить видео', 'back'),
(1066, 1, 'video', 'Видео', 'back'),
(1067, 1, 'error edit video', 'Ошибка при изменении видео', 'back'),
(1068, 1, 'success edit video', 'Видео успешно изменен', 'back'),
(1070, 1, 'bottom after logo text', 'Магазин развивающих игрушек для детей', 'front'),
(1071, 1, 'information about2', 'Информация об', 'front'),
(1072, 1, 'personal data using', 'использовании персональных данных', 'front'),
(1073, 1, 'success add news', 'Новость успешно добавлен', 'back'),
(1074, 1, 'all news', 'Все новости', 'front'),
(1075, 1, 'view more', 'Подробнее', 'front'),
(1076, 1, 'new toy sets', 'Новые наборы игрушек', 'front'),
(1077, 1, 'all products', 'Все игрушки', 'front'),
(1078, 1, 'recommendeds', 'Рекомендуемые', 'front'),
(1079, 1, 'menu banner', 'Баннеры', 'back'),
(1080, 1, 'banner page', 'Баннеры', 'back'),
(1081, 1, 'add banner', 'Добавить баннер', 'back'),
(1082, 1, 'banner name', 'Название', 'back'),
(1083, 1, 'position name', 'Позиция', 'back'),
(1084, 1, 'banner position bottom', 'Перед футером', 'front'),
(1085, 1, 'success add banner', 'Баннер успешно добавлен', 'back'),
(1086, 1, 'banner position ', 'Позиция', 'front'),
(1087, 1, 'error add banner', 'Ошибка при добавлении баннера', 'back'),
(1088, 1, 'edit banner', 'Редактировать баннер', 'back'),
(1089, 1, 'success edit banner', 'Баннер успешно изменен', 'back'),
(1090, 1, 'error edit banner', 'Ошибка при изменении баннера', 'back'),
(1091, 1, 'recommended product', 'Рекомендованный товар', 'back'),
(1092, 1, 'view category', 'Просмотр категории', 'front'),
(1093, 1, 'toys', 'Игрушки', 'front'),
(1094, 1, 'filter category', 'Категория', 'back'),
(1095, 1, 'sort number', 'Сортировка', 'back'),
(1096, 1, 'sort_number', 'Сортировка', 'back'),
(1097, 1, 'by categories', 'По категориям', 'front'),
(1098, 1, 'by set', 'Комплект', 'front'),
(1099, 1, 'by age', 'По возрасту', 'front'),
(1100, 1, 'by color', 'По цвету', 'front'),
(1101, 1, 'qty', 'к-во', 'front'),
(1102, 1, 'by price', 'По цене', 'front'),
(1103, 1, 'product description short', 'Коротко о товаре', 'front'),
(1104, 1, 'discount', 'Скидка', 'front'),
(1106, 1, 'from brand', 'от', 'front'),
(1107, 1, 'happy customer reviews', 'Отзывы счастливых клиентов', 'front'),
(1108, 1, 'update', 'Обновить', 'front'),
(1109, 1, 'delete', 'Удалить', 'front'),
(1110, 1, 'send email to customer', 'Отправить сообщение покупателю', 'back'),
(1111, 1, 'order has been changed', 'Заказ изменен', 'back'),
(1112, 1, 'customer notified', 'Покупатель оповещен', 'back'),
(1113, 1, 'shopping cart', 'Корзина', 'front'),
(1114, 1, 'success delete page', 'Успешное удаление', 'back'),
(1115, 1, 'error min username length', 'Минимальная длина имени пользователя', 'front'),
(1116, 1, 'register btn', 'Зарегистрироваться', 'front'),
(1117, 1, 'error accept rules and privacy policy', 'Обязательное поле', 'front'),
(1118, 2, 'view category', 'view category', 'front'),
(1119, 2, 'recommendeds', 'recommendeds', 'front'),
(1120, 2, 'shopping cart', 'shopping cart', 'front'),
(1121, 2, 'register btn', 'register btn', 'front'),
(1122, 2, 'main bottom menu', 'main bottom menu', 'front'),
(1123, 2, 'bottom after logo text', 'bottom after logo text', 'front'),
(1124, 2, 'information about2', 'information about2', 'front'),
(1125, 2, 'personal data using', 'personal data using', 'front'),
(1126, 2, 'new toy sets', 'new toy sets', 'front'),
(1127, 2, 'all products', 'all products', 'front'),
(1128, 2, 'all news', 'all news', 'front'),
(1129, 2, 'view more', 'view more', 'front'),
(1130, 2, 'from brand', 'from brand', 'front'),
(1131, 2, 'rub', 'rub', 'front'),
(1132, 2, 'discount', 'discount', 'front'),
(1133, 2, 'add to cart', 'add to cart', 'front'),
(1134, 2, 'happy customer reviews', 'happy customer reviews', 'front'),
(1135, 2, 'no reviews', 'no reviews', 'front'),
(1136, 2, 'add review', 'add review', 'front'),
(1137, 2, 'your name', 'your name', 'front'),
(1138, 2, 'review', 'review', 'front'),
(1139, 2, 'similar products', 'similar products', 'front'),
(1141, 1, 'By clicking the \"Register\" button, I accept the terms of the %s User Agreement %s and agree to the processing of my personal information on the terms set forth in the %s Privacy Policy %s', 'Нажимая кнопку &quot;Регистрация&quot;, я принимаю условия %s Пользовательского соглашения %s и даю своё согласие  на обработку моей персональной информации на условиях, определенных %s Политикой конфиденциальности %s.', 'front'),
(1142, 1, 'contact us', 'Контакты', 'front'),
(1143, 1, 'our contacts and feedback', 'Наши контакты и обратная связь', 'front'),
(1144, 1, 'choose project', 'Выбрать проект', 'front'),
(1145, 1, 'your message', 'Сообщение', 'front'),
(1146, 1, 'contact form submit error', 'Ошибка при отправке сообщения', 'front'),
(1147, 1, 'contact form submit success', 'Сообщение успешно отправлено! Мы свяжемся с вами в ближайшее время', 'front'),
(1148, 1, 'menu contact', 'Контактная форма', 'back'),
(1149, 1, 'contact page', 'Контакты', 'back'),
(1150, 1, 'contact list', 'Список контактов', 'back'),
(1151, 1, 'contact name', 'Имя', 'back'),
(1152, 1, 'view contact', 'Контакт', 'back'),
(1153, 1, 'edit contact', 'Редактировать контакт', 'back'),
(1154, 1, 'contact', 'Контакт', 'back'),
(1156, 1, 'upsell products', 'Похожие товары', 'front'),
(1157, 1, 'cross products', 'С этим товаров покупают', 'front'),
(1158, 1, 'buy', 'Купить', 'front'),
(1159, 1, 'banner position bottom', 'Перед футером', 'back'),
(1160, 1, 'banner position news section', 'Раздел новостей', 'back'),
(1161, 1, 'upload videos', 'Загрузить видео', 'back'),
(1162, 1, 'recommended formats:', 'Рекомендуемые форматы:', 'back'),
(1163, 1, 'file category common', 'Общий', 'back'),
(1164, 1, 'forget password?', 'Забыли пароль?', 'front'),
(1165, 1, 'restore password', 'Восстановить пароль', 'front'),
(1166, 1, 'usergroup 10', 'Пользователи', 'back'),
(1167, 1, 'usergroup 11', 'Ученики', 'back'),
(1168, 1, 'context', 'Контекст', 'back'),
(1169, 1, 'choose usergroup', 'Выбрать группы пользователя', 'back'),
(1170, 1, 'teacher page', 'Учители', 'back'),
(1171, 1, 'menu class', 'Классы', 'back'),
(1172, 1, 'menu teacher', 'Учители', 'back'),
(1173, 1, 'menu student', 'Ученики', 'back'),
(1174, 1, 'add teacher', 'Добавить учителя', 'back'),
(1175, 1, 'teacher list', 'Учители', 'back'),
(1176, 1, 'error usergroup', 'Ошибка группы пользователя', 'back'),
(1177, 1, 'view teacher', 'Учитель', 'back'),
(1178, 1, 'teacher', 'Учитель', 'back'),
(1179, 1, 'edit teacher', 'Редактировать учителя', 'back'),
(1180, 1, 'error edit teacher', 'Ошибка сохранения', 'back'),
(1181, 1, 'error add teacher', 'Ошибка сохранения', 'back'),
(1182, 1, 'max size', 'Максимальный размер', 'back'),
(1183, 1, 'success edit teacher', 'Успешное сохранение', 'back'),
(1184, 1, 'error max image dimensions: x', 'error max image dimensions: x', 'back'),
(1185, 1, 'menu group', 'Классы', 'back'),
(1186, 1, 'student page', 'Ученики', 'back'),
(1187, 1, 'add student', 'Добавить ученика', 'back'),
(1188, 1, 'student list', 'Ученики', 'back'),
(1189, 1, 'cache synchro size', 'Размер кеша синхронизации', 'back'),
(1190, 1, 'view student', 'Ученик', 'back'),
(1191, 1, 'student', 'Учение', 'back'),
(1192, 1, 'error db', 'Ошибка базы данных', 'back'),
(1193, 1, 'group page', 'Классы', 'back'),
(1194, 1, 'error add student', 'Ошибка сохранения', 'back'),
(1195, 1, 'success edit student', 'Успешное сохранение', 'back'),
(1196, 1, 'add group', 'Добавить класс', 'back'),
(1197, 1, 'group list', 'Список классов', 'back'),
(1198, 1, 'group grade', 'Класс', 'back'),
(1199, 1, 'group name', 'Название', 'back'),
(1202, 1, 'group start year', 'Год начала учёбы', 'back'),
(1203, 1, 'group end year', 'Год окончания', 'back'),
(1204, 1, 'view group', 'Класс', 'back'),
(1205, 1, 'group', 'Класс', 'back'),
(1206, 1, 'success edit group', 'Успешное сохранение', 'back'),
(1207, 1, 'error add group', 'Ошибка сохранения', 'back'),
(1208, 1, 'error edit group', 'Ошибка сохранения', 'back'),
(1209, 1, 'study finished', 'Выпуск', 'back'),
(1210, 1, 'error edit student', 'Ошибка сохранения', 'back'),
(1211, 1, 'student group', 'Класс', 'back'),
(1212, 1, 'error delete student', 'Успешное удаление', 'back'),
(1213, 1, 'success delete student', 'Успешное удаление', 'back'),
(1214, 1, 'usergroup ', 'Группа', 'back'),
(1215, 1, 'menu subject', 'Предметы', 'back'),
(1216, 1, 'subject page', 'Предметы', 'back'),
(1217, 1, 'add subject', 'Добавить предмет', 'back'),
(1218, 1, 'subject list', 'Предметы', 'back'),
(1219, 1, 'subject name', 'Название', 'back'),
(1220, 1, 'view subject', 'Предмет', 'back'),
(1221, 1, 'subject', 'Предмет', 'back'),
(1222, 1, 'success edit subject', 'Успешное сохранение', 'back'),
(1223, 1, 'error add subject', 'Ошибка сохранения', 'back'),
(1224, 1, 'error edit subject', 'Ошибка сохранения', 'back'),
(1225, 1, 'teacher subjects', 'Предметы привязанные к учителю', 'back'),
(1226, 1, 'success delete teacher', 'Успешное удаление', 'back'),
(1227, 1, 'success delete subject', 'Успешное удаление', 'back'),
(1228, 1, 'menu study-period', 'Учебные периоды', 'back'),
(1230, 1, 'study period page', 'Учебные периоды', 'back'),
(1231, 1, 'add study period', 'Добавить учебный период', 'back'),
(1232, 1, 'study period list', 'Учебные периоды', 'back'),
(1233, 1, 'study period start year', 'Начало учебного года', 'back'),
(1234, 1, 'study period end year', 'Конец учебного периода', 'back'),
(1235, 1, 'study period name', 'Четверть', 'back'),
(1236, 1, 'study period start time', 'Начало учебного периода', 'back'),
(1237, 1, 'study period end time', 'Начало учебного периода', 'back'),
(1239, 1, 'study-period- page', 'Учебный период', 'back'),
(1241, 1, 'study-period page', 'Учебный период', 'back'),
(1242, 1, 'view study-period', 'Учебный период', 'back'),
(1243, 1, 'study-period', 'Учебный период', 'back'),
(1244, 1, 'view study period', 'Учебный период', 'back'),
(1245, 1, 'success edit study-period', 'Успешное сохранение', 'back'),
(1246, 1, 'error edit study-period', 'Ошибка сохранения', 'back'),
(1247, 1, 'error add study-period', 'Ошибка сохранения', 'back'),
(1248, 1, 'September', 'Сентябрь', 'back'),
(1249, 1, 'October', 'Октябрь', 'back'),
(1250, 1, 'November', 'Ноябрь', 'back'),
(1251, 1, 'December', 'Декабрь', 'back'),
(1252, 1, 'January', 'Январь', 'back'),
(1253, 1, 'March', 'Март', 'back'),
(1254, 1, 'April', 'Апрель', 'back'),
(1255, 1, 'August', 'Август', 'back'),
(1256, 1, 'success delete study-period', 'Успешное удаление', 'back'),
(1257, 1, 'sorry, page not found', 'Извините, странице не найдена', 'front'),
(1258, 1, 'profile', 'Профиль', 'front'),
(1259, 1, 'Такого пользователя не существует', 'Такого пользователя не существует', 'front'),
(1260, 1, 'Неправильный пароль', 'Неправильный пароль', 'front'),
(1261, 1, 'Введите пароль', 'Введите пароль', 'front'),
(1262, 1, 'Введите имя пользователя', 'Введите имя пользователя', 'front'),
(1263, 1, 'dashboard', 'Панель управления', 'front'),
(1264, 1, 'lessons', 'Уроки', 'front'),
(1266, 1, 'lesson', 'Урок', 'front'),
(1267, 1, 'group', 'Класс', 'front'),
(1268, 1, 'choose...', 'Выбрать...', 'front'),
(1269, 1, 'subject', 'Предмет', 'front'),
(1270, 1, 'lesson start time', 'Время начала урока', 'front'),
(1271, 1, 'error not this teacher group', 'Класс не привязан к учителю', 'front'),
(1272, 1, 'students list', 'Список учеников', 'front'),
(1273, 1, 'student attendance', 'Посещение', 'front'),
(1274, 1, 'student mark', 'Оценка', 'front'),
(1276, 1, 'choose group', 'Выбрать класс', 'front'),
(1277, 1, 'choose', 'Выбрать', 'front'),
(1278, 1, 'all', 'Все', 'front'),
(1279, 1, 'error not this teacher subject', 'Предмет не привязан к учителю', 'front'),
(1280, 1, 'error save lesson', 'Ошибка сохранинея', 'front'),
(1281, 1, 'success save lesson', 'Успешное сохранение', 'front'),
(1282, 1, 'are you sure?', 'Вы уверены?', 'front'),
(1283, 1, 'back', 'Назад', 'front'),
(1284, 1, 'error not belongs to', 'Не привязан', 'front'),
(1285, 1, 'success delete lesson', 'Успешное удаление', 'front'),
(1286, 1, 'edit', 'Редактировать', 'front'),
(1287, 1, 'student group', 'Класс', 'front'),
(1288, 1, 'add new lesson', 'Добавить новый урок', 'front'),
(1289, 1, 'view lessons', 'Просмотр уроков', 'front'),
(1290, 1, 'lesson home task', 'Домашнее задание', 'front'),
(1291, 1, 'view profile', 'Просмотр профиля', 'front'),
(1292, 1, 'birthday', 'День рождения', 'back'),
(1293, 1, 'view user', 'Просмотр пользователя', 'back'),
(1294, 1, 'teachers', 'Учители', 'back'),
(1295, 1, 'students', 'Ученики', 'back'),
(1296, 1, 'users', 'Пользователи', 'back'),
(1297, 1, 'lessons', 'Уроки', 'back'),
(1298, 1, 'subjects', 'Предметы', 'front'),
(1299, 1, 'groups', 'Классы', 'front'),
(1300, 1, 'teacher subjects', 'Предметы учителя', 'front'),
(1301, 1, 'teacher groups', 'Классы учителя', 'front'),
(1302, 1, 'user-request page', 'Запросы', 'back'),
(1303, 1, 'user-request list', 'Список запросов', 'back'),
(1305, 1, 'type', 'Тип', 'back'),
(1306, 1, 'target', 'Цель', 'back'),
(1308, 1, 'user_request_type add student to user', 'Добавить ученика к пользователю', 'back'),
(1309, 1, 'user_request_status 0', 'Ожидание', 'back'),
(1310, 1, 'user_request_status -1', 'Отказать', 'back'),
(1311, 1, 'user_request_status 1', 'Принять', 'back'),
(1312, 1, 'user_request_status_result 0', 'В ожидании', 'back'),
(1314, 1, 'user_request_status_result 1', 'Принято', 'back'),
(1316, 1, 'user_request_status_result -1', 'Отказано', 'back'),
(1317, 1, 'menu user-request', 'Запросы', 'back'),
(1318, 1, 'lesson page', 'Уроки', 'back'),
(1319, 1, 'view lesson', 'Урок', 'back'),
(1320, 1, 'lesson', 'Урок', 'back'),
(1321, 1, 'view lessons', 'Уроки', 'back'),
(1322, 1, 'lesson list', 'Уроки', 'back'),
(1323, 1, 'teacher', 'Учитель', 'front'),
(1324, 1, 'lesson start time', 'Время начала урока', 'back'),
(1325, 1, 'menu lesson', 'Уроки', 'back'),
(1326, 1, 'main bottom menu', 'main bottom menu', 'front'),
(1327, 1, 'success delete group', 'success delete group', 'back'),
(1328, 1, 'btn upload', 'btn upload', 'back'),
(1329, 1, 'error schedule file upload', 'error schedule file upload', 'back'),
(1330, 1, 'error file not uploaded', 'error file not uploaded', 'back'),
(1331, 1, 'success schedule file upload', 'success schedule file upload', 'back');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_url`
--

CREATE TABLE `mktb_url` (
  `id` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_url`
--

INSERT INTO `mktb_url` (`id`, `alias`, `route`) VALUES
(33, 'products', 'product/index'),
(96, '', 'home/index/1'),
(522, 'contact', 'contact/index/21'),
(553, 'rules.html', 'information/view/24');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_user`
--

CREATE TABLE `mktb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `usergroup` smallint(6) NOT NULL DEFAULT '10',
  `email` varchar(255) NOT NULL,
  `rank` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `info` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `activity_at` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `date_birth` int(11) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `inn` varchar(32) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `checking_account` varchar(255) NOT NULL,
  `mfo` varchar(255) NOT NULL,
  `okonx` varchar(255) NOT NULL,
  `requisites` text NOT NULL,
  `contract_number` varchar(255) NOT NULL,
  `contract_date_start` varchar(32) NOT NULL,
  `contract_date_end` varchar(32) NOT NULL,
  `address_jur` varchar(1000) NOT NULL,
  `address_phy` varchar(1000) NOT NULL,
  `license_number` varchar(255) NOT NULL,
  `license_date_end` varchar(32) NOT NULL,
  `balance` bigint(15) NOT NULL,
  `forgetkey` varchar(255) NOT NULL,
  `activationkey` varchar(32) NOT NULL,
  `last_login` int(11) NOT NULL,
  `last_ip` varchar(255) NOT NULL,
  `phpsessid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_user`
--

INSERT INTO `mktb_user` (`id`, `username`, `password`, `usergroup`, `email`, `rank`, `status`, `image`, `phone`, `address`, `info`, `created_at`, `updated_at`, `activity_at`, `avatar`, `date_birth`, `gender`, `name`, `firstname`, `lastname`, `middlename`, `company_name`, `inn`, `bank_name`, `checking_account`, `mfo`, `okonx`, `requisites`, `contract_number`, `contract_date_start`, `contract_date_end`, `address_jur`, `address_phy`, `license_number`, `license_date_end`, `balance`, `forgetkey`, `activationkey`, `last_login`, `last_ip`, `phpsessid`) VALUES
(1, 'admin', 'f5c67f2fb8ef39fc764da654adaddb51', 2, 'info@domain.com', 'AdminS', 1, 'user/user_1.jpg', '1234567', '', '', 1489106941, 0, 1537613032, '', 0, 1, 'Администратор', 'Иван', 'Иванов', 'Иванович', '', '111111111', '', '', '', '', '', '1', '2017/01/01', '2020/01/01', 'г.Ташкент, ул.Тест, 1.', 'г.Ташкент, ул.Тест, 1.', '11111', '', 15001185, '', '', 1537613032, '217.29.114.102', 'gv4cq0hk45q8klavu0v85onpo7'),
(2, 'admin2', '778e8245dd04fe3dce6522bad90fc1d6', 1, 'ulugbek.yu@gmail.com', 'Модератор', 1, '', '', '', '', 1489306941, 0, 1537019848, '', 0, 1, '', 'Улугбек', 'Юсупходжаев', '', '', '', '', '', '', '', '', '', '0', '0', 'г.Ташкент, ул.Тест, 4.', 'г.Ташкент, ул.Тест, 4.', '5555', '0', 0, '', '', 1537019848, '217.29.114.102', '5tcsoqth9fbsgob4cvda7o2dm6'),
(13, 'olimov-aziz-2009', '0992a103ec11bc5618c10f2cc7d5c775', 11, '', '', 1, '', '', '', '', 1534574994, 1535626118, 0, '', 1230750000, 0, '', 'Aziz', 'Olimov', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', ''),
(14, 'saidova-dilnoza-2009', '0992a103ec11bc5618c10f2cc7d5c775', 11, 'sa1@test.com', '', 1, '', '', '', '', 1534575515, 1535626106, 1535375356, '', 1230836400, 0, '', 'Dilnoza', 'Saidova', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 1535375356, '127.0.0.1', 'e5jdfndfj7q3vek1d2hr8c3po5'),
(22, 'test2', '0992a103ec11bc5618c10f2cc7d5c775', 10, '', '', 1, '', '', '', '', 1534598344, 1534598344, 0, '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', ''),
(25, 'xamidova-zilola-2009', '0992a103ec11bc5618c10f2cc7d5c775', 11, '', '', 1, '', '', '', '', 1535282739, 1535626141, 0, '', 1236020400, 0, '', 'Zilola', 'Xamidova', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', ''),
(26, 'test-student-2010', '0992a103ec11bc5618c10f2cc7d5c775', 11, '', '', 1, '', '', '', '', 1535283043, 1535626130, 0, '', 1272654000, 0, '', 'student', 'test', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', ''),
(27, 'abdurahimov-abdurayim', '0992a103ec11bc5618c10f2cc7d5c775', 11, '', '', 1, '', '', '', '', 1535626765, 1535626765, 0, '', 1, 0, '', 'Abdurayim', 'Abdurahimov', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', ''),
(28, 'test', '5a5b2fccb9259c5975a0c6c7de7e0cb7', 10, '', '', 1, '', '', '', '', 1535630559, 1535630665, 0, '', 431802000, 0, '', 'test', 'test', 'test', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', ''),
(29, '+998911667886', 'fd1710261f03135079fde2be41b053ae', 10, '', '', 1, '', '', '', '', 1536029265, 1536029265, 0, '', 0, 0, '', 'KLeoPaTRa', '123', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', ''),
(32, 'kii', 'fea261f0e2605506cf9f36a6eb6641b2', 5, '', '', 1, 'teacher/teacher_32.png', '+98982000', '', '', 1536416568, 1536416568, 0, '', 15, 0, '', 'saa', 'sdsc', 'sdd', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', ''),
(33, '007', '97a66b52704f1b1a1d4d6b4dfb44d00e', 5, '', '', 1, 'teacher/teacher_33.png', '', '', '', 1536417380, 1536417419, 0, '', 1, 0, '', 'kd', 'ko', 'ks', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', ''),
(34, 'salom', '6f7b5f1b3f9ad925cd0bf94e741f7508', 5, '', '', 1, 'teacher/teacher_34.png', '', '', '', 1536417536, 1536417536, 1536418334, '', 15, 0, '', 'kl', 'dk', 'ko', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 1536418334, '213.230.94.107', '5f2ighrkda8th3rafbalhaleu5'),
(38, '+998908081239', 'a2a45bac796268f0a7d504ff9f778e4a', 10, '', '', 1, '', '+998908081239', '', '', 1537263046, 1537263046, 0, '', 0, 0, '', 'Ulugbek', 'Yusupxodjayev', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', ''),
(39, '+998934430204', '56123db50a244ca4e5da4c76a477099d', 10, '', '', 1, '', '+998934430204', '', '', 1537523740, 1537523740, 0, '', 0, 0, '', 'ГУЛБАХОР Бахтияровна', 'АХИ АБДУКАРИМОВА', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', ''),
(40, 'umidjon', 'a9f8aef266682cd21c4437321dfeba42', 5, 'umidahun@gmail.com', '', 1, '', '911660048', 'andijon', '', 1537525504, 1537525504, 1537525554, '', 589654800, 0, '', 'Umid', 'Ahunjonov', 'Maxamadumarov', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 1537525554, '213.230.78.185', '5f2ighrkda8th3rafbalhaleu5'),
(41, '+998916122080', 'c6fe972df5eccb491691138fb0d977a6', 10, '', '', 1, '', '+998916122080', '', '', 1537526248, 1537526248, 0, '', 0, 0, '', 'Izzatillo', 'Ismoilov', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 0, '', ''),
(43, 'umid', '6f07ae7c298989731cdf5f4d3cd0fbda', 4, '', '', 1, '', '22222', 'ddd', '', 1537527672, 1537527672, 1537527693, '', 433702800, 0, '', 'Umid', 'Ahun', 'Maxammadumarovich', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', 1537527693, '213.230.78.185', '5f2ighrkda8th3rafbalhaleu5');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_usercontract`
--

CREATE TABLE `mktb_usercontract` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contract_year` smallint(4) NOT NULL,
  `contract_number` varchar(255) NOT NULL,
  `quarter_1` text NOT NULL,
  `quarter_2` text NOT NULL,
  `quarter_3` text NOT NULL,
  `quarter_4` text NOT NULL,
  `price` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_usercontract`
--

INSERT INTO `mktb_usercontract` (`id`, `user_id`, `contract_year`, `contract_number`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `price`) VALUES
(3, 4, 2017, '60', '{\"17\":1000,\"16\":4000,\"18\":500}', '{\"17\":2000,\"16\":5000,\"18\":500}', '{\"17\":2000,\"16\":5000,\"18\":500}', '{\"17\":1000,\"16\":4000,\"18\":500}', '{\"17\":65000,\"16\":190000,\"18\":386000}'),
(4, 3, 2017, '20', '{\"17\":4000,\"16\":13000,\"18\":1000}', '{\"17\":3500,\"16\":12000,\"18\":500}', '{\"17\":3500,\"16\":12000,\"18\":500}', '{\"17\":4000,\"16\":13000,\"18\":1000}', '{\"17\":65000,\"16\":190000,\"18\":386000}'),
(5, 5, 2017, '55', '{\"17\":2000,\"16\":7000,\"18\":600}', '{\"17\":1500,\"16\":6000,\"18\":400}', '{\"17\":1500,\"16\":6000,\"18\":400}', '{\"17\":2000,\"16\":7000,\"18\":600}', '{\"17\":65000,\"16\":190000,\"18\":386000}');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_usergroup`
--

CREATE TABLE `mktb_usergroup` (
  `id` tinyint(2) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_usergroup`
--

INSERT INTO `mktb_usergroup` (`id`, `alias`, `name`) VALUES
(1, 'owner', 'Владелец'),
(2, 'administrator', 'Администратор'),
(3, 'moderator', 'Модератор'),
(4, 'director', 'Директор'),
(5, 'teacher', 'Учитель'),
(10, 'user', 'Пользователь'),
(11, 'student', 'Студент');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_user_request`
--

CREATE TABLE `mktb_user_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_id` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `information` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mktb_user_request`
--

INSERT INTO `mktb_user_request` (`id`, `user_id`, `type`, `target_id`, `date`, `status`, `information`) VALUES
(2, 38, 'add student to user', 27, 1537263147, 1, '{\"source\":\"telegram-bot\",\"chat_id\":11120017}'),
(3, 39, 'add student to user', 26, 1537524418, 1, '{\"source\":\"telegram-bot\",\"chat_id\":44750223}'),
(4, 39, 'add student to user', 13, 1537524885, 1, '{\"source\":\"telegram-bot\",\"chat_id\":44750223}'),
(5, 41, 'add student to user', 13, 1537526266, 1, '{\"source\":\"telegram-bot\",\"chat_id\":322277047}'),
(6, 38, 'add student to user', 13, 1537596692, 0, '{\"source\":\"telegram-bot\",\"chat_id\":11120017}');

-- --------------------------------------------------------

--
-- Структура таблицы `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `paycom_transaction_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `paycom_time` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `paycom_time_datetime` datetime NOT NULL,
  `create_time` datetime NOT NULL,
  `perform_time` datetime DEFAULT NULL,
  `cancel_time` datetime DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `state` tinyint(2) NOT NULL,
  `reason` tinyint(2) DEFAULT NULL,
  `receivers` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'JSON array of receivers',
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `mktb_banner`
--
ALTER TABLE `mktb_banner`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_brand`
--
ALTER TABLE `mktb_brand`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_category`
--
ALTER TABLE `mktb_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_category_name`
--
ALTER TABLE `mktb_category_name`
  ADD PRIMARY KEY (`category_id`,`lang_id`);

--
-- Индексы таблицы `mktb_category_search`
--
ALTER TABLE `mktb_category_search`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`category_id`);
ALTER TABLE `mktb_category_search` ADD FULLTEXT KEY `search_text` (`search_text`);

--
-- Индексы таблицы `mktb_contact`
--
ALTER TABLE `mktb_contact`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_file`
--
ALTER TABLE `mktb_file`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_file_name`
--
ALTER TABLE `mktb_file_name`
  ADD PRIMARY KEY (`file_id`,`lang_id`);

--
-- Индексы таблицы `mktb_filter`
--
ALTER TABLE `mktb_filter`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_filter_to_category`
--
ALTER TABLE `mktb_filter_to_category`
  ADD PRIMARY KEY (`filter_id`,`category_id`);

--
-- Индексы таблицы `mktb_filter_to_product`
--
ALTER TABLE `mktb_filter_to_product`
  ADD PRIMARY KEY (`filter_value_id`,`product_id`);

--
-- Индексы таблицы `mktb_filter_value`
--
ALTER TABLE `mktb_filter_value`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_group`
--
ALTER TABLE `mktb_group`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_lang`
--
ALTER TABLE `mktb_lang`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_lesson`
--
ALTER TABLE `mktb_lesson`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_module`
--
ALTER TABLE `mktb_module`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_module_to_usergroup`
--
ALTER TABLE `mktb_module_to_usergroup`
  ADD PRIMARY KEY (`usergroup_id`,`module_id`);

--
-- Индексы таблицы `mktb_option`
--
ALTER TABLE `mktb_option`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_order`
--
ALTER TABLE `mktb_order`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_order_change`
--
ALTER TABLE `mktb_order_change`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_page`
--
ALTER TABLE `mktb_page`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_page_module`
--
ALTER TABLE `mktb_page_module`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_post`
--
ALTER TABLE `mktb_post`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_product`
--
ALTER TABLE `mktb_product`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_product_name`
--
ALTER TABLE `mktb_product_name`
  ADD PRIMARY KEY (`product_id`,`lang_id`);

--
-- Индексы таблицы `mktb_product_option`
--
ALTER TABLE `mktb_product_option`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_product_option_to_product`
--
ALTER TABLE `mktb_product_option_to_product`
  ADD PRIMARY KEY (`product_option_value_id`,`product_id`);

--
-- Индексы таблицы `mktb_product_option_value`
--
ALTER TABLE `mktb_product_option_value`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_product_search`
--
ALTER TABLE `mktb_product_search`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`);
ALTER TABLE `mktb_product_search` ADD FULLTEXT KEY `search_text` (`search_text`);

--
-- Индексы таблицы `mktb_review`
--
ALTER TABLE `mktb_review`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_slider`
--
ALTER TABLE `mktb_slider`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_student_attendance`
--
ALTER TABLE `mktb_student_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_student_mark`
--
ALTER TABLE `mktb_student_mark`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_student_to_group`
--
ALTER TABLE `mktb_student_to_group`
  ADD PRIMARY KEY (`student_id`,`group_id`);

--
-- Индексы таблицы `mktb_student_to_user`
--
ALTER TABLE `mktb_student_to_user`
  ADD PRIMARY KEY (`student_id`,`user_id`);

--
-- Индексы таблицы `mktb_study_period`
--
ALTER TABLE `mktb_study_period`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_subject`
--
ALTER TABLE `mktb_subject`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_subject_to_teacher`
--
ALTER TABLE `mktb_subject_to_teacher`
  ADD PRIMARY KEY (`subject_id`,`teacher_id`);

--
-- Индексы таблицы `mktb_subscribe`
--
ALTER TABLE `mktb_subscribe`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_tag`
--
ALTER TABLE `mktb_tag`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_tag_to_product`
--
ALTER TABLE `mktb_tag_to_product`
  ADD PRIMARY KEY (`tag_id`,`product_id`);

--
-- Индексы таблицы `mktb_teacher_to_group`
--
ALTER TABLE `mktb_teacher_to_group`
  ADD PRIMARY KEY (`teacher_id`,`group_id`);

--
-- Индексы таблицы `mktb_tgbot_api_token`
--
ALTER TABLE `mktb_tgbot_api_token`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_tgbot_botan_shortener`
--
ALTER TABLE `mktb_tgbot_botan_shortener`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `mktb_tgbot_callback_query`
--
ALTER TABLE `mktb_tgbot_callback_query`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `message_id` (`message_id`),
  ADD KEY `chat_id_2` (`chat_id`,`message_id`);

--
-- Индексы таблицы `mktb_tgbot_chat`
--
ALTER TABLE `mktb_tgbot_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `old_id` (`old_id`);

--
-- Индексы таблицы `mktb_tgbot_chosen_inline_result`
--
ALTER TABLE `mktb_tgbot_chosen_inline_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `mktb_tgbot_conversation`
--
ALTER TABLE `mktb_tgbot_conversation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `status` (`status`);

--
-- Индексы таблицы `mktb_tgbot_edited_message`
--
ALTER TABLE `mktb_tgbot_edited_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `message_id` (`message_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `chat_id_2` (`chat_id`,`message_id`);

--
-- Индексы таблицы `mktb_tgbot_file`
--
ALTER TABLE `mktb_tgbot_file`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_tgbot_information`
--
ALTER TABLE `mktb_tgbot_information`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_tgbot_inline_query`
--
ALTER TABLE `mktb_tgbot_inline_query`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `mktb_tgbot_message`
--
ALTER TABLE `mktb_tgbot_message`
  ADD PRIMARY KEY (`chat_id`,`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `forward_from` (`forward_from`),
  ADD KEY `forward_from_chat` (`forward_from_chat`),
  ADD KEY `reply_to_chat` (`reply_to_chat`),
  ADD KEY `reply_to_message` (`reply_to_message`),
  ADD KEY `left_chat_member` (`left_chat_member`),
  ADD KEY `migrate_from_chat_id` (`migrate_from_chat_id`),
  ADD KEY `migrate_to_chat_id` (`migrate_to_chat_id`),
  ADD KEY `reply_to_chat_2` (`reply_to_chat`,`reply_to_message`);

--
-- Индексы таблицы `mktb_tgbot_request_limiter`
--
ALTER TABLE `mktb_tgbot_request_limiter`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_tgbot_store_cart`
--
ALTER TABLE `mktb_tgbot_store_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `mktb_tgbot_store_cart_item`
--
ALTER TABLE `mktb_tgbot_store_cart_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `mktb_tgbot_store_order`
--
ALTER TABLE `mktb_tgbot_store_order`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_tgbot_store_order_item`
--
ALTER TABLE `mktb_tgbot_store_order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `mktb_tgbot_store_product`
--
ALTER TABLE `mktb_tgbot_store_product`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_tgbot_telegram_update`
--
ALTER TABLE `mktb_tgbot_telegram_update`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`chat_id`,`message_id`),
  ADD KEY `inline_query_id` (`inline_query_id`),
  ADD KEY `chosen_inline_result_id` (`chosen_inline_result_id`),
  ADD KEY `callback_query_id` (`callback_query_id`),
  ADD KEY `edited_message_id` (`edited_message_id`);

--
-- Индексы таблицы `mktb_tgbot_user`
--
ALTER TABLE `mktb_tgbot_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Индексы таблицы `mktb_tgbot_user_chat`
--
ALTER TABLE `mktb_tgbot_user_chat`
  ADD PRIMARY KEY (`user_id`,`chat_id`),
  ADD KEY `chat_id` (`chat_id`);

--
-- Индексы таблицы `mktb_translation`
--
ALTER TABLE `mktb_translation`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_url`
--
ALTER TABLE `mktb_url`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`alias`),
  ADD UNIQUE KEY `route` (`route`);

--
-- Индексы таблицы `mktb_user`
--
ALTER TABLE `mktb_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Индексы таблицы `mktb_usercontract`
--
ALTER TABLE `mktb_usercontract`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_usergroup`
--
ALTER TABLE `mktb_usergroup`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mktb_user_request`
--
ALTER TABLE `mktb_user_request`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `mktb_banner`
--
ALTER TABLE `mktb_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_brand`
--
ALTER TABLE `mktb_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_category`
--
ALTER TABLE `mktb_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_category_search`
--
ALTER TABLE `mktb_category_search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT для таблицы `mktb_contact`
--
ALTER TABLE `mktb_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_file`
--
ALTER TABLE `mktb_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `mktb_filter`
--
ALTER TABLE `mktb_filter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_filter_value`
--
ALTER TABLE `mktb_filter_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_group`
--
ALTER TABLE `mktb_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `mktb_lang`
--
ALTER TABLE `mktb_lang`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `mktb_lesson`
--
ALTER TABLE `mktb_lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `mktb_module`
--
ALTER TABLE `mktb_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `mktb_option`
--
ALTER TABLE `mktb_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT для таблицы `mktb_order`
--
ALTER TABLE `mktb_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_order_change`
--
ALTER TABLE `mktb_order_change`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_page`
--
ALTER TABLE `mktb_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `mktb_page_module`
--
ALTER TABLE `mktb_page_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_post`
--
ALTER TABLE `mktb_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_product`
--
ALTER TABLE `mktb_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_product_option`
--
ALTER TABLE `mktb_product_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_product_option_value`
--
ALTER TABLE `mktb_product_option_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_product_search`
--
ALTER TABLE `mktb_product_search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT для таблицы `mktb_review`
--
ALTER TABLE `mktb_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_slider`
--
ALTER TABLE `mktb_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_student_attendance`
--
ALTER TABLE `mktb_student_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT для таблицы `mktb_student_mark`
--
ALTER TABLE `mktb_student_mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT для таблицы `mktb_study_period`
--
ALTER TABLE `mktb_study_period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `mktb_subject`
--
ALTER TABLE `mktb_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `mktb_subscribe`
--
ALTER TABLE `mktb_subscribe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `mktb_tag`
--
ALTER TABLE `mktb_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_api_token`
--
ALTER TABLE `mktb_tgbot_api_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_botan_shortener`
--
ALTER TABLE `mktb_tgbot_botan_shortener`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this entry';

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_chosen_inline_result`
--
ALTER TABLE `mktb_tgbot_chosen_inline_result`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this entry';

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_conversation`
--
ALTER TABLE `mktb_tgbot_conversation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this entry', AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_edited_message`
--
ALTER TABLE `mktb_tgbot_edited_message`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this entry', AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_file`
--
ALTER TABLE `mktb_tgbot_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_information`
--
ALTER TABLE `mktb_tgbot_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_request_limiter`
--
ALTER TABLE `mktb_tgbot_request_limiter`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for this entry', AUTO_INCREMENT=655;

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_store_cart`
--
ALTER TABLE `mktb_tgbot_store_cart`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Unique cart identifier';

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_store_cart_item`
--
ALTER TABLE `mktb_tgbot_store_cart_item`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Unique cart item identifier';

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_store_order`
--
ALTER TABLE `mktb_tgbot_store_order`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Unique cart identifier';

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_store_order_item`
--
ALTER TABLE `mktb_tgbot_store_order_item`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Order item identifier';

--
-- AUTO_INCREMENT для таблицы `mktb_tgbot_store_product`
--
ALTER TABLE `mktb_tgbot_store_product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Unique product identifier';

--
-- AUTO_INCREMENT для таблицы `mktb_translation`
--
ALTER TABLE `mktb_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1332;

--
-- AUTO_INCREMENT для таблицы `mktb_url`
--
ALTER TABLE `mktb_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=554;

--
-- AUTO_INCREMENT для таблицы `mktb_user`
--
ALTER TABLE `mktb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT для таблицы `mktb_usercontract`
--
ALTER TABLE `mktb_usercontract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `mktb_usergroup`
--
ALTER TABLE `mktb_usergroup`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `mktb_user_request`
--
ALTER TABLE `mktb_user_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `mktb_tgbot_botan_shortener`
--
ALTER TABLE `mktb_tgbot_botan_shortener`
  ADD CONSTRAINT `mktb_tgbot_botan_shortener_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mktb_tgbot_user` (`id`);

--
-- Ограничения внешнего ключа таблицы `mktb_tgbot_callback_query`
--
ALTER TABLE `mktb_tgbot_callback_query`
  ADD CONSTRAINT `mktb_tgbot_callback_query_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mktb_tgbot_user` (`id`),
  ADD CONSTRAINT `mktb_tgbot_callback_query_ibfk_2` FOREIGN KEY (`chat_id`,`message_id`) REFERENCES `mktb_tgbot_message` (`chat_id`, `id`);

--
-- Ограничения внешнего ключа таблицы `mktb_tgbot_chosen_inline_result`
--
ALTER TABLE `mktb_tgbot_chosen_inline_result`
  ADD CONSTRAINT `mktb_tgbot_chosen_inline_result_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mktb_tgbot_user` (`id`);

--
-- Ограничения внешнего ключа таблицы `mktb_tgbot_conversation`
--
ALTER TABLE `mktb_tgbot_conversation`
  ADD CONSTRAINT `mktb_tgbot_conversation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mktb_tgbot_user` (`id`),
  ADD CONSTRAINT `mktb_tgbot_conversation_ibfk_2` FOREIGN KEY (`chat_id`) REFERENCES `mktb_tgbot_chat` (`id`);

--
-- Ограничения внешнего ключа таблицы `mktb_tgbot_edited_message`
--
ALTER TABLE `mktb_tgbot_edited_message`
  ADD CONSTRAINT `mktb_tgbot_edited_message_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `mktb_tgbot_chat` (`id`),
  ADD CONSTRAINT `mktb_tgbot_edited_message_ibfk_2` FOREIGN KEY (`chat_id`,`message_id`) REFERENCES `mktb_tgbot_message` (`chat_id`, `id`),
  ADD CONSTRAINT `mktb_tgbot_edited_message_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `mktb_tgbot_user` (`id`);

--
-- Ограничения внешнего ключа таблицы `mktb_tgbot_inline_query`
--
ALTER TABLE `mktb_tgbot_inline_query`
  ADD CONSTRAINT `mktb_tgbot_inline_query_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mktb_tgbot_user` (`id`);

--
-- Ограничения внешнего ключа таблицы `mktb_tgbot_message`
--
ALTER TABLE `mktb_tgbot_message`
  ADD CONSTRAINT `mktb_tgbot_message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mktb_tgbot_user` (`id`),
  ADD CONSTRAINT `mktb_tgbot_message_ibfk_2` FOREIGN KEY (`chat_id`) REFERENCES `mktb_tgbot_chat` (`id`),
  ADD CONSTRAINT `mktb_tgbot_message_ibfk_3` FOREIGN KEY (`forward_from`) REFERENCES `mktb_tgbot_user` (`id`),
  ADD CONSTRAINT `mktb_tgbot_message_ibfk_4` FOREIGN KEY (`forward_from_chat`) REFERENCES `mktb_tgbot_chat` (`id`),
  ADD CONSTRAINT `mktb_tgbot_message_ibfk_5` FOREIGN KEY (`reply_to_chat`,`reply_to_message`) REFERENCES `mktb_tgbot_message` (`chat_id`, `id`),
  ADD CONSTRAINT `mktb_tgbot_message_ibfk_6` FOREIGN KEY (`forward_from`) REFERENCES `mktb_tgbot_user` (`id`),
  ADD CONSTRAINT `mktb_tgbot_message_ibfk_7` FOREIGN KEY (`left_chat_member`) REFERENCES `mktb_tgbot_user` (`id`);

--
-- Ограничения внешнего ключа таблицы `mktb_tgbot_store_cart`
--
ALTER TABLE `mktb_tgbot_store_cart`
  ADD CONSTRAINT `mktb_tgbot_store_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mktb_tgbot_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `mktb_tgbot_store_cart_item`
--
ALTER TABLE `mktb_tgbot_store_cart_item`
  ADD CONSTRAINT `mktb_tgbot_store_cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `mktb_tgbot_store_cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mktb_tgbot_store_cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `mktb_tgbot_store_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `mktb_tgbot_store_order_item`
--
ALTER TABLE `mktb_tgbot_store_order_item`
  ADD CONSTRAINT `mktb_tgbot_store_order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `mktb_tgbot_store_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `mktb_tgbot_telegram_update`
--
ALTER TABLE `mktb_tgbot_telegram_update`
  ADD CONSTRAINT `mktb_tgbot_telegram_update_ibfk_1` FOREIGN KEY (`chat_id`,`message_id`) REFERENCES `mktb_tgbot_message` (`chat_id`, `id`),
  ADD CONSTRAINT `mktb_tgbot_telegram_update_ibfk_2` FOREIGN KEY (`inline_query_id`) REFERENCES `mktb_tgbot_inline_query` (`id`),
  ADD CONSTRAINT `mktb_tgbot_telegram_update_ibfk_3` FOREIGN KEY (`chosen_inline_result_id`) REFERENCES `mktb_tgbot_chosen_inline_result` (`id`),
  ADD CONSTRAINT `mktb_tgbot_telegram_update_ibfk_4` FOREIGN KEY (`callback_query_id`) REFERENCES `mktb_tgbot_callback_query` (`id`),
  ADD CONSTRAINT `mktb_tgbot_telegram_update_ibfk_5` FOREIGN KEY (`edited_message_id`) REFERENCES `mktb_tgbot_edited_message` (`id`);

--
-- Ограничения внешнего ключа таблицы `mktb_tgbot_user_chat`
--
ALTER TABLE `mktb_tgbot_user_chat`
  ADD CONSTRAINT `mktb_tgbot_user_chat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mktb_tgbot_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mktb_tgbot_user_chat_ibfk_2` FOREIGN KEY (`chat_id`) REFERENCES `mktb_tgbot_chat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
