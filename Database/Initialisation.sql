-- Create users table
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
)

-- Create orders table
CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    date DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
)

-- Create order_products table
CREATE TABLE order_products (
    id SERIAL PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
)

-- Create products table
CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT NOT NULL
)

-- Seed the users table
INSERT INTO users (first_name, last_name, email, password)
VALUES ('Alice', 'Smith', 'alice@email.com', 'password'),
       ('Bob', 'Jones', 'bob@email.com', 'password'),
       ('Charlie', 'Brown', 'charlie@email.com', 'password')

-- Seed the products table
INSERT INTO products (name, price, description)
VALUES ('Apple', 0.50, 'Fresh and juicy apple'),
       ('Banana', 0.30, 'Sweet and ripe banana'),
       ('Orange', 0.40, 'Tangy and refreshing orange')

-- Seed the orders table
INSERT INTO orders (user_id, date, total)
VALUES (1, '2024-05-09', 1.00),
       (2, '2024-05-10', 0.60),
       (3, '2024-05-11', 1.20)

-- Seed the order_products table
INSERT INTO order_products (order_id, product_id, quantity)
VALUES (1, 1, 2),
       (2, 2, 2),
       (3, 3, 3)