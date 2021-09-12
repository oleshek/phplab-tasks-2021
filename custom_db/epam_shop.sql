CREATE DATABASE epam_shop;
USE epam_shop;

CREATE TABLE `measurement_unit` (
  `id` int(11) UNSIGNED NOT NULL,
  `short_name` varchar(25) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','not active') NOT NULL DEFAULT 'active',
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB AVG_ROW_LENGTH=1170 DEFAULT CHARSET=utf8;

INSERT INTO `measurement_unit` (`id`, `short_name`, `name`, `description`, `status`, `deleted`) VALUES
(1, 'кг.', 'Кілограми', NULL, 'active', 0),
(2, 'г.', 'Грами', NULL, 'active', 0),
(3, 'т.', 'Тони', NULL, 'active', 0),
(4, 'шт.', 'Штуки', NULL, 'active', 0),
(5, 'уп.', 'Упаковки', NULL, 'active', 0),
(6, 'ящ.', 'Ящики', NULL, 'active', 0),
(7, 'в.', 'Відра', NULL, 'active', 0),
(8, 'л.', 'Літри', NULL, 'active', 0);


CREATE TABLE `order` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','not active') NOT NULL DEFAULT 'active',
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `payment_method` varchar(50) DEFAULT NULL,
  `sum_ordered` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=16384 DEFAULT CHARSET=utf8;

INSERT INTO `order` (`id`, `name`, `description`, `date_created`, `status`, `deleted`, `payment_method`, `sum_ordered`) VALUES
(1, 'order #1', 'small order', '2021-08-10 22:10:10', 'active', 0, 'cash', '123.00'),
(2, 'order #2', 'not so small order', '2021-08-10 22:12:05', 'active', 0, 'card', '255.00'),
(3, 'order #3', 'last order before break', '2021-09-10 22:12:05', 'active', 0, 'check', '43.50'),
(4, 'order #4', NULL, '2021-09-10 22:12:57', 'active', 0, 'cash', '83.90'),
(5, 'order #5', NULL, '2021-09-10 22:12:57', 'active', 0, 'card', '555.00'),
(6, 'order #6', 'the biggest order', '2021-09-10 22:14:47', 'active', 0, 'card', '1345.00'),
(7, 'order #7', 'order for boss', '2021-10-10 22:14:47', 'active', 0, 'check', '352.10');


CREATE TABLE `order_product` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `count` float(11,3) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `order_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `measurement_unit_id` int(11) UNSIGNED NOT NULL,
  `price_for_one` decimal(11,2) NOT NULL,
  `sum_ordered` decimal(11,2) NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=4096 DEFAULT CHARSET=utf8;

INSERT INTO `order_product` (`id`, `name`, `description`, `count`, `deleted`, `order_id`, `product_id`, `measurement_unit_id`, `price_for_one`, `sum_ordered`) VALUES
(1, 'Крабові палички', NULL, 2.000, 0, 1, 2, 1, '25.00', '50.00'),
(2, 'Оливкова олія', NULL, 3.000, 0, 1, 3, 8, '99.99', '279.00'),
(3, 'Сир Фета', NULL, 4.000, 0, 2, 4, 5, '30.00', '120.00'),
(4, 'Виноград білий', NULL, 2.000, 0, 2, 6, 5, '15.00', '0.00'),
(5, 'Виноград білий', NULL, 1.000, 0, 3, 6, 5, '20.00', '20.00'),
(6, 'Виноград червоний', NULL, 1.000, 0, 3, 5, 5, '15.00', '15.00'),
(7, 'Креветка королівська', NULL, 3.000, 0, 4, 1, 1, '120.00', '360.00'),
(8, 'Крабові палички', NULL, 12.000, 0, 5, 2, 4, '11.00', '131.00'),
(9, 'Оливкова Олія', NULL, 1.000, 0, 5, 3, 4, '123.00', '123.00'),
(10, 'Креветка королівська', NULL, 0.500, 0, 5, 1, 1, '100.00', '50.00');


CREATE TABLE `product` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','not active') NOT NULL DEFAULT 'active',
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `default_measurement_unit` int(11) UNSIGNED NOT NULL,
  `default_price` decimal(11,2) UNSIGNED NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=540 DEFAULT CHARSET=utf8;

INSERT INTO `product` (`id`, `name`, `description`, `status`, `deleted`, `default_measurement_unit`, `default_price`) VALUES
(1, 'Креветка королівська', 'Краща креветка України', 'active', 0, 1, '19.99'),
(2, 'Крабові палички', 'Крабові палички вироблені з Одеських крабів', 'active', 0, 5, '49.99'),
(3, 'Оливкова олія', '100% оливкова', 'active', 0, 8, '99.99'),
(4, 'Сир Фетта', 'Свіжо вижатий', 'active', 0, 1, '30.99'),
(5, 'Виноград червоний', 'Чудово підійде до сиру та меду', 'active', 0, 1, '12.50'),
(6, 'Виноград білий', 'Жується замість сємок', 'active', 0, 2, '15.50');


ALTER TABLE `measurement_unit`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `measurement_unit_id` (`measurement_unit_id`);

ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `default_measurement_unit` (`default_measurement_unit`);

ALTER TABLE `measurement_unit`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `order`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `order_product`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `product`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `order_product_ibfk_3` FOREIGN KEY (`measurement_unit_id`) REFERENCES `measurement_unit` (`id`);

ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`default_measurement_unit`) REFERENCES `measurement_unit` (`id`);