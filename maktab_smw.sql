-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 04 2018 г., 16:27
-- Версия сервера: 5.6.31
-- Версия PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `maktab_smw`
--

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_attendance`
--

CREATE TABLE IF NOT EXISTS `mktb_attendance` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `present` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_banner`
--

CREATE TABLE IF NOT EXISTS `mktb_banner` (
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

CREATE TABLE IF NOT EXISTS `mktb_brand` (
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

CREATE TABLE IF NOT EXISTS `mktb_category` (
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

CREATE TABLE IF NOT EXISTS `mktb_category_name` (
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `lang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_category_search`
--

CREATE TABLE IF NOT EXISTS `mktb_category_search` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `search_text` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_class`
--

CREATE TABLE IF NOT EXISTS `mktb_class` (
  `id` int(11) NOT NULL,
  `grade` tinyint(2) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_year` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_contact`
--

CREATE TABLE IF NOT EXISTS `mktb_contact` (
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

CREATE TABLE IF NOT EXISTS `mktb_file` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `sort_number` int(11) NOT NULL,
  `name` text NOT NULL,
  `mime` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_file`
--

INSERT INTO `mktb_file` (`id`, `path`, `sort_number`, `name`, `mime`) VALUES
(11, 'common/file.jpg', 0, 'bg_home.jpg', 'image/jpeg');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_file_name`
--

CREATE TABLE IF NOT EXISTS `mktb_file_name` (
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

CREATE TABLE IF NOT EXISTS `mktb_filter` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_filter_to_category`
--

CREATE TABLE IF NOT EXISTS `mktb_filter_to_category` (
  `filter_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_filter_to_product`
--

CREATE TABLE IF NOT EXISTS `mktb_filter_to_product` (
  `filter_value_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_filter_value`
--

CREATE TABLE IF NOT EXISTS `mktb_filter_value` (
  `id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `sort_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_lang`
--

CREATE TABLE IF NOT EXISTS `mktb_lang` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lang_prefix` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `main` tinyint(1) NOT NULL,
  `sort_number` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_lang`
--

INSERT INTO `mktb_lang` (`id`, `name`, `lang_prefix`, `icon`, `status`, `main`, `sort_number`) VALUES
(1, 'Русский', 'ru', 'lang/ru.jpg', 1, 1, 1),
(2, 'English', 'en', 'lang/en.jpg', 0, 0, 3),
(3, 'Казахский', 'kz', 'lang/kz.jpg', 0, 0, 4),
(4, 'O''zbek', 'uz', 'lang/uz.jpg', 0, 0, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_lesson`
--

CREATE TABLE IF NOT EXISTS `mktb_lesson` (
  `id` int(11) NOT NULL,
  `study_period_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_mark`
--

CREATE TABLE IF NOT EXISTS `mktb_mark` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `mark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_module`
--

CREATE TABLE IF NOT EXISTS `mktb_module` (
  `id` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `access` int(11) NOT NULL,
  `sort_order` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `show_menu` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_module`
--

INSERT INTO `mktb_module` (`id`, `alias`, `name`, `access`, `sort_order`, `status`, `show_menu`) VALUES
(1, 'category', 'Категории', 2, 10, 0, 0),
(2, 'product', 'Товары', 2, 20, 0, 0),
(3, 'page', 'Страницы', 2, 30, 1, 1),
(4, 'user', 'Пользователи', 3, 90, 1, 1),
(5, 'configuration', 'Настройки', 2, 301, 1, 0),
(6, 'blog', 'Блог', 3, 50, 0, 0),
(9, 'chapter', 'Главы', 3, 25, 0, 0),
(10, 'music', 'Песни', 3, 60, 0, 0),
(11, 'clip', 'Клипы', 3, 70, 0, 0),
(12, 'slider', 'Слайдер', 2, 100, 1, 1),
(13, 'lexicon', 'Словарь', 3, 90, 0, 0),
(14, 'illustrationbook', 'Иллюстрации', 3, 95, 0, 0),
(15, 'symphony', 'Симфония', 3, 85, 0, 0),
(16, 'news', 'Новости', 3, 51, 0, 0),
(17, 'project', 'Проекты', 3, 10, 0, 0),
(18, 'gallery', 'Галерея', 3, 80, 1, 1),
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
(31, 'banner', 'Баннеры', 3, 60, 1, 1),
(32, 'contact', 'Контакты', 3, 60, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_module_to_usergroup`
--

CREATE TABLE IF NOT EXISTS `mktb_module_to_usergroup` (
  `module_id` int(11) NOT NULL,
  `usergroup_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_option`
--

CREATE TABLE IF NOT EXISTS `mktb_option` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `comment` varchar(255) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_option`
--

INSERT INTO `mktb_option` (`id`, `name`, `content`, `comment`, `visible`) VALUES
(1, 'default_controller', 'home', 'Страница по умолчанию', 0),
(2, 'default_action', 'index', 'Функция по умолчанию', 0),
(3, 'theme', 'maktab', 'Тема', 1),
(4, 'theme_admin', 'default', '', 0),
(5, 'phone1', '+7 (915) 006 1881', 'Телефон 1', 1),
(6, 'phone2', '+7 (915) 006 1881', 'Телефон 2', 1),
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
(37, 'phone3', '+7 (915) 006 1881', 'Телефон 3', 1),
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
(53, 'map_lng', '1', 'Координаты карты (долгота)', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_order`
--

CREATE TABLE IF NOT EXISTS `mktb_order` (
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

CREATE TABLE IF NOT EXISTS `mktb_order_change` (
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

CREATE TABLE IF NOT EXISTS `mktb_page` (
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_page`
--

INSERT INTO `mktb_page` (`id`, `controller`, `method`, `side`, `layout`, `status`, `alias`, `name`, `text_name`, `nav_name`, `descr`, `descr_full`, `meta_t`, `meta_d`, `meta_k`) VALUES
(1, 'home', 'index', 'front', 'default', 1, '', '{"1":"2work"}', '{"1":"2work"}', '{"1":"Главная"}', '{"1":""}', '{"1":"&lt;p&gt;2work&lt;\\/p&gt;"}', '{"1":"2work - Поможем найти надежного исполнителя для любых задач"}', '{"1":""}', '{"1":""}'),
(2, 'category', 'index', 'front', 'default', 1, 'category', '{"1":"Каталог"}', '{"1":"Каталог"}', '{"1":"Каталог"}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}'),
(3, 'brand', 'index', 'front', 'default', 1, 'brand', '{"1":"Производители"}', '{"1":"Производители"}', '{"1":"Производители"}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}'),
(4, 'product', 'index', 'front', 'default', 1, 'product', '{"1":"Продукция"}', '{"1":"Продукция"}', '{"1":"Продукция"}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}'),
(5, 'cart', 'index', 'front', 'default', 1, 'cart', '{"1":"Корзина","2":"Cart"}', '', '{"1":"Корзина","2":"Cart"}', '', '', '', '', ''),
(7, 'information', 'view', 'front', 'default', 1, 'about.html', '{"1":"О нас"}', '{"1":"О нас"}', '{"1":"О нас"}', '{"1":""}', '{"1":"&lt;div&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex alias aliquam commodi nisi sequi mollitia quae, voluptatibus veniam non voluptate ipsa eius magni, aliquid ratione sit odio, reprehenderit in quis!&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Deleniti amet consequatur veritatis ducimus in aliquam magnam voluptatibus, ullam libero fugiat temporibus, at, aliquid explicabo placeat eligendi, assumenda magni? Iure id soluta aliquam, praesentium dicta aliquid autem cum impedit.&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Ab iure enim totam dolor! Debitis itaque deleniti, esse ut adipisci officiis, nulla. Doloribus esse tenetur eos, provident quam quasi maxime tempore. Possimus nostrum neque voluptas, tempora laudantium dicta, laborum.&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Iure fuga esse facere, adipisci debitis, iste nulla facilis perspiciatis voluptates delectus corrupti sint. Itaque, consequuntur modi. Placeat molestias cumque harum, aspernatur, beatae consequuntur quisquam qui accusantium obcaecati provident vel!&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Eius ipsa, et esse ipsum animi id, placeat fuga fugit reprehenderit, minima facere asperiores aperiam sequi labore voluptatibus nam excepturi incidunt nulla eum. Officiis, maxime vel at, numquam quod quae.&lt;\\/div&gt;"}', '{"1":""}', '{"1":""}', '{"1":""}'),
(8, 'information', 'view', 'front', 'default', 1, 'terms-of-payment.html', '{"1":"Условия оплаты"}', '{"1":"Условия оплаты"}', '{"1":"Условия оплаты"}', '{"1":""}', '{"1":"&lt;div&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex alias aliquam commodi nisi sequi mollitia quae, voluptatibus veniam non voluptate ipsa eius magni, aliquid ratione sit odio, reprehenderit in quis!&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Deleniti amet consequatur veritatis ducimus in aliquam magnam voluptatibus, ullam libero fugiat temporibus, at, aliquid explicabo placeat eligendi, assumenda magni? Iure id soluta aliquam, praesentium dicta aliquid autem cum impedit.&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Ab iure enim totam dolor! Debitis itaque deleniti, esse ut adipisci officiis, nulla. Doloribus esse tenetur eos, provident quam quasi maxime tempore. Possimus nostrum neque voluptas, tempora laudantium dicta, laborum.&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Iure fuga esse facere, adipisci debitis, iste nulla facilis perspiciatis voluptates delectus corrupti sint. Itaque, consequuntur modi. Placeat molestias cumque harum, aspernatur, beatae consequuntur quisquam qui accusantium obcaecati provident vel!&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Eius ipsa, et esse ipsum animi id, placeat fuga fugit reprehenderit, minima facere asperiores aperiam sequi labore voluptatibus nam excepturi incidunt nulla eum. Officiis, maxime vel at, numquam quod quae.&lt;\\/div&gt;"}', '{"1":""}', '{"1":""}', '{"1":""}'),
(9, 'information', 'view', 'front', 'default', 1, 'shipping-policy.html', '{"1":"Условия доставки"}', '{"1":"Условия доставки"}', '{"1":"Условия доставки"}', '{"1":""}', '{"1":"&lt;div&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex alias aliquam commodi nisi sequi mollitia quae, voluptatibus veniam non voluptate ipsa eius magni, aliquid ratione sit odio, reprehenderit in quis!&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Deleniti amet consequatur veritatis ducimus in aliquam magnam voluptatibus, ullam libero fugiat temporibus, at, aliquid explicabo placeat eligendi, assumenda magni? Iure id soluta aliquam, praesentium dicta aliquid autem cum impedit.&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Ab iure enim totam dolor! Debitis itaque deleniti, esse ut adipisci officiis, nulla. Doloribus esse tenetur eos, provident quam quasi maxime tempore. Possimus nostrum neque voluptas, tempora laudantium dicta, laborum.&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Iure fuga esse facere, adipisci debitis, iste nulla facilis perspiciatis voluptates delectus corrupti sint. Itaque, consequuntur modi. Placeat molestias cumque harum, aspernatur, beatae consequuntur quisquam qui accusantium obcaecati provident vel!&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Eius ipsa, et esse ipsum animi id, placeat fuga fugit reprehenderit, minima facere asperiores aperiam sequi labore voluptatibus nam excepturi incidunt nulla eum. Officiis, maxime vel at, numquam quod quae.&lt;\\/div&gt;"}', '{"1":""}', '{"1":""}', '{"1":""}'),
(10, 'information', 'view', 'front', 'default', 1, 'return-policy.html', '{"1":"Условия возврата"}', '{"1":"Условия возврата"}', '{"1":"Условия возврата"}', '{"1":""}', '{"1":"&lt;div&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex alias aliquam commodi nisi sequi mollitia quae, voluptatibus veniam non voluptate ipsa eius magni, aliquid ratione sit odio, reprehenderit in quis!&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Deleniti amet consequatur veritatis ducimus in aliquam magnam voluptatibus, ullam libero fugiat temporibus, at, aliquid explicabo placeat eligendi, assumenda magni? Iure id soluta aliquam, praesentium dicta aliquid autem cum impedit.&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Ab iure enim totam dolor! Debitis itaque deleniti, esse ut adipisci officiis, nulla. Doloribus esse tenetur eos, provident quam quasi maxime tempore. Possimus nostrum neque voluptas, tempora laudantium dicta, laborum.&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Iure fuga esse facere, adipisci debitis, iste nulla facilis perspiciatis voluptates delectus corrupti sint. Itaque, consequuntur modi. Placeat molestias cumque harum, aspernatur, beatae consequuntur quisquam qui accusantium obcaecati provident vel!&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Eius ipsa, et esse ipsum animi id, placeat fuga fugit reprehenderit, minima facere asperiores aperiam sequi labore voluptatibus nam excepturi incidunt nulla eum. Officiis, maxime vel at, numquam quod quae.&lt;\\/div&gt;"}', '{"1":""}', '{"1":""}', '{"1":""}'),
(11, 'information', 'view', 'front', 'default', 1, 'privacy-policy.html', '{"1":"Конфиденциальность"}', '{"1":"Политика конфиденциальности"}', '{"1":"Конфиденциальность"}', '{"1":""}', '{"1":"&lt;div&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex alias aliquam commodi nisi sequi mollitia quae, voluptatibus veniam non voluptate ipsa eius magni, aliquid ratione sit odio, reprehenderit in quis!&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Deleniti amet consequatur veritatis ducimus in aliquam magnam voluptatibus, ullam libero fugiat temporibus, at, aliquid explicabo placeat eligendi, assumenda magni? Iure id soluta aliquam, praesentium dicta aliquid autem cum impedit.&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Ab iure enim totam dolor! Debitis itaque deleniti, esse ut adipisci officiis, nulla. Doloribus esse tenetur eos, provident quam quasi maxime tempore. Possimus nostrum neque voluptas, tempora laudantium dicta, laborum.&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Iure fuga esse facere, adipisci debitis, iste nulla facilis perspiciatis voluptates delectus corrupti sint. Itaque, consequuntur modi. Placeat molestias cumque harum, aspernatur, beatae consequuntur quisquam qui accusantium obcaecati provident vel!&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Eius ipsa, et esse ipsum animi id, placeat fuga fugit reprehenderit, minima facere asperiores aperiam sequi labore voluptatibus nam excepturi incidunt nulla eum. Officiis, maxime vel at, numquam quod quae.&lt;\\/div&gt;\\r\\n\\r\\n&lt;p&gt;&amp;nbsp;&lt;\\/p&gt;"}', '{"1":""}', '{"1":""}', '{"1":""}'),
(12, 'information', 'view', 'front', 'default', 1, 'certificates.html', '{"1":"Сертификаты"}', '{"1":"Сертификаты"}', '{"1":"Сертификаты"}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}'),
(13, 'information', 'view', 'front', 'default', 0, 'affiliate-program.html', '{"1":"Партнерская программа"}', '{"1":"Партнерская программа"}', '{"1":"Партнерская программа"}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}'),
(15, 'information', 'view', 'front', 'default', 1, 'promotions.html', '{"1":"Наши акции"}', '{"1":"Наши акции"}', '{"1":"Наши акции"}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}'),
(16, 'information', 'view', 'front', 'default', 1, 'services.html', '{"1":"Услуги"}', '{"1":"Услуги"}', '{"1":"Услуги"}', '{"1":""}', '{"1":"&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus odit rerum necessitatibus saepe asperiores, commodi porro doloribus ipsum aspernatur architecto sequi reprehenderit officia magni. Praesentium aliquid odit minus, cumque molestias.&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Numquam eligendi eum ratione reiciendis nesciunt quia fugit totam dignissimos quaerat dicta, voluptatibus temporibus sit dolorum quibusdam expedita, natus recusandae vel perferendis cumque incidunt hic. Recusandae minus autem odio sint!&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Excepturi, molestiae quas minus, assumenda similique nisi dolorem autem natus, sint reiciendis omnis distinctio asperiores eligendi fugiat consequuntur amet facere hic nesciunt rem deserunt? Quia quasi, at quos totam eaque.&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Corrupti iusto est beatae magni, ducimus illum optio quas perferendis quo alias atque dignissimos quod facere ipsam ad excepturi deserunt adipisci fuga mollitia aliquid earum, assumenda reiciendis deleniti veniam at?&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Saepe impedit placeat eos delectus, corrupti, assumenda, vel id animi reiciendis quod repellat dolorum quas amet cum rerum ut nostrum iste a. Officiis doloremque non vitae eaque sint omnis odit!&lt;\\/p&gt;"}', '{"1":""}', '{"1":""}', '{"1":""}'),
(20, 'news', 'index', 'front', 'default', 1, 'news', '{"1":"Новости"}', '{"1":"Новости"}', '{"1":"Новости"}', '{"1":""}', '{"1":"&lt;div&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex alias aliquam commodi nisi sequi mollitia quae, voluptatibus veniam non voluptate ipsa eius magni, aliquid ratione sit odio, reprehenderit in quis!&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Deleniti amet consequatur veritatis ducimus in aliquam magnam voluptatibus, ullam libero fugiat temporibus, at, aliquid explicabo placeat eligendi, assumenda magni? Iure id soluta aliquam, praesentium dicta aliquid autem cum impedit.&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Ab iure enim totam dolor! Debitis itaque deleniti, esse ut adipisci officiis, nulla. Doloribus esse tenetur eos, provident quam quasi maxime tempore. Possimus nostrum neque voluptas, tempora laudantium dicta, laborum.&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Iure fuga esse facere, adipisci debitis, iste nulla facilis perspiciatis voluptates delectus corrupti sint. Itaque, consequuntur modi. Placeat molestias cumque harum, aspernatur, beatae consequuntur quisquam qui accusantium obcaecati provident vel!&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;&amp;nbsp;&lt;\\/div&gt;\\r\\n\\r\\n&lt;div&gt;Eius ipsa, et esse ipsum animi id, placeat fuga fugit reprehenderit, minima facere asperiores aperiam sequi labore voluptatibus nam excepturi incidunt nulla eum. Officiis, maxime vel at, numquam quod quae.&lt;\\/div&gt;"}', '{"1":""}', '{"1":""}', '{"1":""}'),
(21, 'contact', 'index', 'front', 'default', 1, 'contact', '{"1":"Контакты"}', '{"1":"Связаться с нами"}', '{"1":"Контакты"}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}', '{"1":""}'),
(22, 'video', 'index', 'front', 'default', 1, 'video', '{"1":"Видеоролики","2":"Видеоролики"}', '{"1":"Видеоролики","2":"Видеоролики"}', '{"1":"Видеоролики","2":"Видеоролики"}', '{"1":"","2":""}', '{"1":"","2":""}', '{"1":"","2":""}', '{"1":"","2":""}', '{"1":"","2":""}'),
(23, 'information', 'view', 'front', 'default', 1, 'guarantee', '{"1":"Гарантия","2":"Guarantee"}', '{"1":"Гарантия","2":"Guarantee"}', '{"1":"Гарантия","2":"Guarantee"}', '{"1":"","2":""}', '{"1":"","2":""}', '{"1":"","2":""}', '{"1":"","2":""}', '{"1":"","2":""}'),
(24, 'information', 'view', 'front', 'default', 1, 'rules.html', '{"1":"Пользовательское соглашение"}', '{"1":"Пользовательское соглашение"}', '{"1":"Пользовательское соглашение"}', '{"1":""}', '{"1":"&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati fuga itaque debitis dolorum veritatis deserunt sit illum rerum fugit voluptatem, at odio, reprehenderit, dolores deleniti dignissimos qui dolor repudiandae ullam.&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Praesentium modi voluptatibus velit excepturi qui reprehenderit rerum, totam, nesciunt, obcaecati neque quos quisquam! Ab molestiae qui veniam voluptatem deleniti in inventore, maxime itaque cumque recusandae odit nisi ut. Repellat!&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Qui molestias culpa ipsam rem, saepe. Inventore aliquam ab ducimus accusamus reiciendis saepe quidem nisi aliquid earum maiores voluptatum repellat dolore sequi magnam, labore dolorum placeat enim suscipit laborum veniam.&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Fuga incidunt neque distinctio aliquid ut, ipsam officiis deleniti magni eveniet est dolor quam ab id, atque doloremque eos repudiandae architecto possimus minima nulla ea labore consequatur maxime cum. Dolores.&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Sapiente harum rem reprehenderit ex accusamus, vero ducimus. Accusantium ullam quia, et id nam tempora nulla recusandae eligendi minima perspiciatis nostrum, numquam molestias, repellat fuga distinctio autem, consequatur dolorem. Iste.&lt;\\/p&gt;\\r\\n\\r\\n&lt;p&gt;Odio molestiae harum aperiam officiis hic, at assumenda, incidunt iusto est totam commodi quidem perspiciatis dolorum ab ducimus recusandae eius doloribus! Molestias quasi ea suscipit, perspiciatis numquam quos itaque obcaecati.&lt;\\/p&gt;"}', '{"1":""}', '{"1":""}', '{"1":""}');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_page_module`
--

CREATE TABLE IF NOT EXISTS `mktb_page_module` (
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

CREATE TABLE IF NOT EXISTS `mktb_post` (
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

CREATE TABLE IF NOT EXISTS `mktb_product` (
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

CREATE TABLE IF NOT EXISTS `mktb_product_name` (
  `product_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `lang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_product_option`
--

CREATE TABLE IF NOT EXISTS `mktb_product_option` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_product_option_to_product`
--

CREATE TABLE IF NOT EXISTS `mktb_product_option_to_product` (
  `product_option_value_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_product_option_value`
--

CREATE TABLE IF NOT EXISTS `mktb_product_option_value` (
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

CREATE TABLE IF NOT EXISTS `mktb_product_search` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `search_text` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_review`
--

CREATE TABLE IF NOT EXISTS `mktb_review` (
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

CREATE TABLE IF NOT EXISTS `mktb_slider` (
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
-- Структура таблицы `mktb_study_period`
--

CREATE TABLE IF NOT EXISTS `mktb_study_period` (
  `id` int(11) NOT NULL,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_subject`
--

CREATE TABLE IF NOT EXISTS `mktb_subject` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_subscribe`
--

CREATE TABLE IF NOT EXISTS `mktb_subscribe` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subscribe` tinyint(1) NOT NULL,
  `type` tinyint(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_subscribe`
--

INSERT INTO `mktb_subscribe` (`id`, `email`, `subscribe`, `type`) VALUES
(1, 'test@test.com', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tag`
--

CREATE TABLE IF NOT EXISTS `mktb_tag` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `lang_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_tag_to_product`
--

CREATE TABLE IF NOT EXISTS `mktb_tag_to_product` (
  `tag_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_teacher`
--

CREATE TABLE IF NOT EXISTS `mktb_teacher` (
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
-- Структура таблицы `mktb_translation`
--

CREATE TABLE IF NOT EXISTS `mktb_translation` (
  `id` int(11) NOT NULL,
  `lang` tinyint(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `context` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1169 DEFAULT CHARSET=utf8;

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
(72, 1, 'error product alias exists', 'url названием уже существует', 'back'),
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
(271, 1, 'project use', 'Use', 'back'),
(272, 2, 'project use', 'Use', 'back'),
(273, 1, 'project life style', 'Life Style', 'back'),
(274, 2, 'project life style', 'Life Style', 'back'),
(275, 1, 'project use 1', 'Residential', 'back'),
(276, 2, 'project use 1', 'Residential', 'back'),
(277, 1, 'project use 2', 'Commercial', 'back'),
(278, 2, 'project use 2', 'Commercial', 'back'),
(279, 1, 'project life style 1', 'Standard', 'back'),
(280, 2, 'project life style 1', 'Standard', 'back'),
(281, 1, 'project life style 2', 'Luxury', 'back'),
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
(323, 1, 'logo', 'Magazin', 'front'),
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
(436, 1, 'use search', 'воспользуйтесь поиском', 'front'),
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
(540, 1, 'usergroup 5', 'Пользователь', 'back'),
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
(879, 1, 'popular 1', 'popular 1', 'front'),
(880, 1, 'popular 2', 'popular 2', 'front'),
(881, 1, 'popular 3', 'popular 3', 'front'),
(882, 1, 'popular 4', 'popular 4', 'front'),
(883, 1, 'popular 5', 'popular 5', 'front'),
(884, 1, 'popular 6', 'popular 6', 'front'),
(885, 1, 'popular 7', 'popular 7', 'front'),
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
(923, 1, 'no-reply', 'no-reply', 'front'),
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
(943, 1, 'server configurator', 'server configurator', 'front'),
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
(985, 1, 'file category post', 'Запись', 'back');
INSERT INTO `mktb_translation` (`id`, `lang`, `name`, `content`, `context`) VALUES
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
(999, 1, 'added from gallery images', 'Добавлено из галереи', 'back'),
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
(1011, 1, 'category show in 1', 'category show in 1', 'back'),
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
(1054, 1, 'category show in 2', 'category show in 2', 'back'),
(1055, 1, 'category show in 3', 'category show in 3', 'back'),
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
(1069, 1, 'main bottom menu', 'main bottom menu', 'front'),
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
(1108, 1, 'update', 'update', 'front'),
(1109, 1, 'delete', 'delete', 'front'),
(1110, 1, 'send email to customer', 'send email to customer', 'back'),
(1111, 1, 'order has been changed', 'order has been changed', 'back'),
(1112, 1, 'customer notified', 'customer notified', 'back'),
(1113, 1, 'shopping cart', 'shopping cart', 'front'),
(1114, 1, 'success delete page', 'success delete page', 'back'),
(1115, 1, 'error min username length', 'error min username length', 'front'),
(1116, 1, 'register btn', 'register btn', 'front'),
(1117, 1, 'error accept rules and privacy policy', 'error accept rules and privacy policy', 'front'),
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
(1141, 1, 'By clicking the "Register" button, I accept the terms of the %s User Agreement %s and agree to the processing of my personal information on the terms set forth in the %s Privacy Policy %s', 'Нажимая кнопку &quot;Регистрация&quot;, я принимаю условия %s Пользовательского соглашения %s и даю своё согласие  на обработку моей персональной информации на условиях, определенных %s Политикой конфиденциальности %s.', 'front'),
(1142, 1, 'contact us', 'Контакты', 'front'),
(1143, 1, 'our contacts and feedback', 'Наши контакты и обратная связь', 'front'),
(1144, 1, 'choose project', 'choose project', 'front'),
(1145, 1, 'your message', 'Сообщение', 'front'),
(1146, 1, 'contact form submit error', 'Ошибка при отправке сообщения', 'front'),
(1147, 1, 'contact form submit success', 'Сообщение успешно отправлено! Мы свяжемся с вами в ближайшее время', 'front'),
(1148, 1, 'menu contact', 'Контактная форма', 'back'),
(1149, 1, 'contact page', 'contact page', 'back'),
(1150, 1, 'contact list', 'contact list', 'back'),
(1151, 1, 'contact name', 'contact name', 'back'),
(1152, 1, 'view contact', 'view contact', 'back'),
(1153, 1, 'edit contact', 'edit contact', 'back'),
(1154, 1, 'contact', 'contact', 'back'),
(1155, 1, 'contact form name', 'contact form name', 'back'),
(1156, 1, 'upsell products', 'upsell products', 'front'),
(1157, 1, 'cross products', 'cross products', 'front'),
(1158, 1, 'buy', 'buy', 'front'),
(1159, 1, 'banner position bottom', 'Перед футером', 'back'),
(1160, 1, 'banner position news section', 'banner position news section', 'back'),
(1161, 1, 'upload videos', 'upload videos', 'back'),
(1162, 1, 'recommended formats:', 'recommended formats:', 'back'),
(1163, 1, 'file category common', 'file category common', 'back'),
(1164, 1, 'forget password?', 'forget password?', 'front'),
(1165, 1, 'restore password', 'restore password', 'front'),
(1166, 1, 'usergroup 10', 'usergroup 10', 'back'),
(1167, 1, 'usergroup 11', 'usergroup 11', 'back'),
(1168, 1, 'context', 'context', 'back');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_url`
--

CREATE TABLE IF NOT EXISTS `mktb_url` (
  `id` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=554 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_url`
--

INSERT INTO `mktb_url` (`id`, `alias`, `route`) VALUES
(19, 'category', 'category/index/2'),
(33, 'products', 'product/index'),
(96, '', 'home/index/1'),
(127, 'about.html', 'information/view/7'),
(179, 'terms-of-payment.html', 'information/view/8'),
(180, 'shipping-policy.html', 'information/view/9'),
(181, 'return-policy.html', 'information/view/10'),
(182, 'privacy-policy.html', 'information/view/11'),
(183, 'certificates.html', 'information/view/12'),
(184, 'affiliate-program.html', 'information/view/13'),
(186, 'promotions.html', 'information/view/15'),
(187, 'brand', 'brand/index/3'),
(238, 'services.html', 'information/view/16'),
(248, 'product', 'product/index/4'),
(254, 'news', 'news/index/20'),
(522, 'contact', 'contact/index/21'),
(525, 'video', 'video/index/22'),
(528, 'guarantee', 'information/view/23'),
(553, 'rules.html', 'information/view/24');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_user`
--

CREATE TABLE IF NOT EXISTS `mktb_user` (
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
  `date_reg` int(11) NOT NULL,
  `date_activity` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_user`
--

INSERT INTO `mktb_user` (`id`, `username`, `password`, `usergroup`, `email`, `rank`, `status`, `image`, `phone`, `address`, `info`, `date_reg`, `date_activity`, `avatar`, `date_birth`, `gender`, `name`, `firstname`, `lastname`, `middlename`, `company_name`, `inn`, `bank_name`, `checking_account`, `mfo`, `okonx`, `requisites`, `contract_number`, `contract_date_start`, `contract_date_end`, `address_jur`, `address_phy`, `license_number`, `license_date_end`, `balance`, `forgetkey`, `activationkey`, `last_login`, `last_ip`, `phpsessid`) VALUES
(1, 'admin', 'f5c67f2fb8ef39fc764da654adaddb51', 2, 'info@domain.com', 'AdminS', 1, 'user/user_1.jpg', '1234567', '', '', 1489106941, 1533364802, '', 0, 1, 'Администратор', 'Иван', 'Иванов', 'Иванович', '', '111111111', '', '', '', '', '', '1', '2017/01/01', '2020/01/01', 'г.Ташкент, ул.Тест, 1.', 'г.Ташкент, ул.Тест, 1.', '11111', '', 15001185, '', '1', 1533364802, '127.0.0.1', '8vp0a8q42omuap2c6aotphm673'),
(2, 'admin2', '778e8245dd04fe3dce6522bad90fc1d6', 1, 'ulugbek.yu@gmail.com', 'Модератор', 1, '', '', '', '', 1489306941, 1533387945, '', 0, 1, '', 'Имя', 'Фамилия', 'Отчество', '', '', '', '', '', '', '', '', '0', '0', 'г.Ташкент, ул.Тест, 4.', 'г.Ташкент, ул.Тест, 4.', '5555', '0', 0, '', '1', 1533387945, '127.0.0.1', '8vp0a8q42omuap2c6aotphm673');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_usercontract`
--

CREATE TABLE IF NOT EXISTS `mktb_usercontract` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contract_year` smallint(4) NOT NULL,
  `contract_number` varchar(255) NOT NULL,
  `quarter_1` text NOT NULL,
  `quarter_2` text NOT NULL,
  `quarter_3` text NOT NULL,
  `quarter_4` text NOT NULL,
  `price` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `mktb_usercontract`
--

INSERT INTO `mktb_usercontract` (`id`, `user_id`, `contract_year`, `contract_number`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `price`) VALUES
(3, 4, 2017, '60', '{"17":1000,"16":4000,"18":500}', '{"17":2000,"16":5000,"18":500}', '{"17":2000,"16":5000,"18":500}', '{"17":1000,"16":4000,"18":500}', '{"17":65000,"16":190000,"18":386000}'),
(4, 3, 2017, '20', '{"17":4000,"16":13000,"18":1000}', '{"17":3500,"16":12000,"18":500}', '{"17":3500,"16":12000,"18":500}', '{"17":4000,"16":13000,"18":1000}', '{"17":65000,"16":190000,"18":386000}'),
(5, 5, 2017, '55', '{"17":2000,"16":7000,"18":600}', '{"17":1500,"16":6000,"18":400}', '{"17":1500,"16":6000,"18":400}', '{"17":2000,"16":7000,"18":600}', '{"17":65000,"16":190000,"18":386000}');

-- --------------------------------------------------------

--
-- Структура таблицы `mktb_usergroup`
--

CREATE TABLE IF NOT EXISTS `mktb_usergroup` (
  `id` tinyint(2) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

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
-- Структура таблицы `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
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
-- Индексы таблицы `mktb_attendance`
--
ALTER TABLE `mktb_attendance`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `product_id` (`category_id`),
  ADD FULLTEXT KEY `search_text` (`search_text`);

--
-- Индексы таблицы `mktb_class`
--
ALTER TABLE `mktb_class`
  ADD PRIMARY KEY (`id`);

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
-- Индексы таблицы `mktb_mark`
--
ALTER TABLE `mktb_mark`
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
  ADD UNIQUE KEY `product_id` (`product_id`),
  ADD FULLTEXT KEY `search_text` (`search_text`);

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
-- Индексы таблицы `mktb_teacher`
--
ALTER TABLE `mktb_teacher`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `email` (`email`),
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
-- Индексы таблицы `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `mktb_attendance`
--
ALTER TABLE `mktb_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT для таблицы `mktb_class`
--
ALTER TABLE `mktb_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `mktb_contact`
--
ALTER TABLE `mktb_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `mktb_file`
--
ALTER TABLE `mktb_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
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
-- AUTO_INCREMENT для таблицы `mktb_lang`
--
ALTER TABLE `mktb_lang`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `mktb_lesson`
--
ALTER TABLE `mktb_lesson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `mktb_mark`
--
ALTER TABLE `mktb_mark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `mktb_module`
--
ALTER TABLE `mktb_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT для таблицы `mktb_option`
--
ALTER TABLE `mktb_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
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
-- AUTO_INCREMENT для таблицы `mktb_study_period`
--
ALTER TABLE `mktb_study_period`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `mktb_subject`
--
ALTER TABLE `mktb_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `mktb_subscribe`
--
ALTER TABLE `mktb_subscribe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `mktb_tag`
--
ALTER TABLE `mktb_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `mktb_teacher`
--
ALTER TABLE `mktb_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `mktb_translation`
--
ALTER TABLE `mktb_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1169;
--
-- AUTO_INCREMENT для таблицы `mktb_url`
--
ALTER TABLE `mktb_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=554;
--
-- AUTO_INCREMENT для таблицы `mktb_user`
--
ALTER TABLE `mktb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `mktb_usercontract`
--
ALTER TABLE `mktb_usercontract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `mktb_usergroup`
--
ALTER TABLE `mktb_usergroup`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;