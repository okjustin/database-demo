-- Create users table
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
);

-- Create products table
CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT NOT NULL
);

-- Create orders table
CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    date DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create order_products table
CREATE TABLE order_products (
    id SERIAL PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Seed the users table
INSERT INTO users (first_name, last_name, email, password)
VALUES 
    ('Alice', 'Smith', 'alice@email.com', 'password'),
    ('Bob', 'Jones', 'bob@email.com', 'password'),
    ('Charlie', 'Brown', 'charlie@email.com', 'password'),
    ('David', 'Clark', 'david@email.com', 'password'),
    ('Eva', 'Green', 'eva@email.com', 'password');

-- Seed the products table
INSERT INTO products (name, price, description)
VALUES 
    ('Apple', 0.50, 'Fresh and juicy apple'),
    ('Banana', 0.30, 'Sweet and ripe banana'),
    ('Orange', 0.40, 'Tangy and refreshing orange'),
    ('Pear', 0.60, 'Crisp and sweet pear'),
    ('Grapes', 1.20, 'Fresh green grapes'),
    ('Pineapple', 2.00, 'Tropical pineapple'),
    ('Strawberry', 1.50, 'Sweet strawberries'),
    ('Blueberry', 1.80, 'Fresh blueberries'),
    ('Mango', 1.00, 'Juicy mango'),
    ('Watermelon', 3.00, 'Refreshing watermelon');

-- Seed the orders table
INSERT INTO orders (user_id, date, total)
VALUES 
    (1, '2024-05-09', 5.00),
    (2, '2024-05-10', 6.00),
    (3, '2024-05-11', 7.20),
    (4, '2024-05-12', 3.80),
    (5, '2024-05-13', 4.50),
    (1, '2024-05-14', 8.00),
    (2, '2024-05-15', 9.00),
    (3, '2024-05-16', 10.20),
    (4, '2024-05-17', 5.50),
    (5, '2024-05-18', 6.60);

-- Seed the order_products table
INSERT INTO order_products (order_id, product_id, quantity)
VALUES 
    (1, 1, 2),
    (1, 2, 3),
    (1, 3, 1),
    (2, 2, 4),
    (2, 3, 2),
    (2, 4, 1),
    (3, 1, 1),
    (3, 5, 3),
    (3, 6, 2),
    (4, 3, 2),
    (4, 7, 1),
    (4, 8, 2),
    (5, 4, 3),
    (5, 9, 2),
    (5, 10, 1),
    (6, 1, 2),
    (6, 2, 1),
    (6, 3, 4),
    (6, 5, 2),
    (7, 6, 1),
    (7, 7, 3),
    (7, 8, 2),
    (8, 9, 1),
    (8, 10, 2),
    (8, 1, 3),
    (9, 2, 2),
    (9, 3, 3),
    (9, 4, 1),
    (10, 5, 2),
    (10, 6, 3),
    (10, 7, 1);
