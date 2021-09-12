-- Методи оплати за конкретний день
SELECT DISTINCT payment_method FROM `order` WHERE date_created LIKE '2021-08-10%';

-- Сума замовлень певних товарів та середнє значення суми замовлень
SELECT SUM(sum_ordered), AVG(sum_ordered) FROM order_product WHERE product_id IN (5, 6);

-- К-сть, ціна та одиниці виміру (останнє не обов'язково) замовлених продуктів по назві
SELECT op.count,op.price_for_one, mu.name, mu.description
FROM order_product op
JOIN product p ON p.id = op.product_id
LEFT JOIN measurement_unit mu ON mu.id = op.measurement_unit_id
WHERE p.name LIKE '%виноград%';

-- Вивести дані про замовлення товарів які продавалися по відмінній від дефолтної ціни та відмінній від дефолтної одиниці виміру
SELECT o.name, o.payment_method, p.name, mu.short_name, mu.name
FROM order_product op
JOIN product p  ON p.id = op.product_id
JOIN `order` o ON o.id = op.order_id
JOIN measurement_unit mu ON mu.id = op.measurement_unit_id
WHERE op.price_for_one != p.default_price AND op.measurement_unit_id != p.default_measurement_unit

-- Показати замовлення в яких замовляли більше 2 товарів
SELECT o.id, o.name, COUNT(o.id)
FROM order_product op
JOIN `order` o ON o.id = op.order_id
GROUP BY op.order_id
HAVING COUNT(op.id) > 2

-- Дістати 5 продуктів з найбільшою дефолтною ціною або найбільшою ціною за 1
SELECT name, default_price as price FROM product
UNION
SELECT name, price_for_one FROM order_product
GROUP BY name
ORDER BY price DESC
LIMIT 5

-- Показати найменшу та найбільшу ціну по якій продавалися товари
SELECT id, name,
(SELECT MAX(price_for_one) FROM order_product WHERE product.id = order_product.product_id ) as max_price,
(SELECT MIN(price_for_one) FROM order_product WHERE product.id = order_product.product_id ) as min_price
FROM product

-- Вюшка для зручного перегляду продуктів та їх дефотних одиниць виміру
CREATE VIEW product_to_measurement_unit as
SELECT p.id, p.name as product, mu.short_name, mu.name
FROM product p
JOIN measurement_unit mu ON mu.id = p.default_measurement_unit