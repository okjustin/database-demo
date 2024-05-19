# Guide to Viewing Relational Data with PHP

## Introduction

Welcome to the guide on how to view relational data with PHP. This guide will help you set up a PostgreSQL database, create PHP classes to represent your data model, and create web pages to display the data. Even if you are new to databases, PHP, or web development, this guide will provide step-by-step instructions to get you up and running.

### Step 1: Setting Up a PostgreSQL Database

1. **Open PgAdmin4:** Launch the PgAdmin4 application.

2. **Create a Database:**
  - Connect to a database server (either on your local machine or with the provided credentials) and expand it with the drop-down arrow icon
  - Right-click on "Databases" and select "Create" > "Database...".
  - Enter a name for your database (e.g., `demo`) and click "Save".

3. **Open the Query Tool:**
   - Select your newly created database from the navigation pane.
   - Click on the "Tools" menu and select "Query Tool".
4. **Execute the SQL Script:**
   - Copy and paste the following SQL script into the query tool to create and seed the necessary tables.

```sql
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

-- Seed the users table with dummy data
INSERT INTO users (first_name, last_name, email, password)
VALUES
    ('Alice', 'Smith', 'alice@email.com', 'password'),
    ('Bob', 'Jones', 'bob@email.com', 'password'),
    ('Charlie', 'Brown', 'charlie@email.com', 'password'),
    ('David', 'Clark', 'david@email.com', 'password'),
    ('Eva', 'Green', 'eva@email.com', 'password');

-- Seed the products table with dummy data
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

-- Seed the orders table with dummy data
INSERT INTO orders (user_id, date, total)
VALUES
    (1, '2024-05-09', 5.00),
    (2, '2024-05-10', 6.00),
    (3, '2024-05-11', 10.20),
    (4, '2024-05-12', 8.50),
    (5, '2024-05-13', 4.00);

-- Seed the order_products table with dummy data
INSERT INTO order_products (order_id, product_id, quantity)
VALUES
    (1, 1, 2),
    (1, 2, 1),
    (2, 3, 2),
    (2, 4, 2),
    (3, 5, 1),
    (3, 6, 1),
    (3, 7, 3),
    (4, 8, 2),
    (4, 9, 1),
    (5, 10, 1),
    (5, 1, 4);

```

5. **Execute the Script:**
   - Click the "Execute" button (play icon) to run the script and create the tables with the initial data.

6. **View the Data:**
   - You can explore the tables and the inserted data by right-clicking the tables and selecting "View/Edit Data".

Congratulations. You've created a new PostgreSQL database, and created multiple tables which relate to one another, using primary and foreign keys. We will now move over to PHP land, and write some code to create a website where we can view this data in a more user-friendly format.

### Step 2: Creating the Data Model Classes in PHP

Let's create the PHP classes that will represent our data model. Data models are just that - they are models or formats for data we want to represent, such as a user. This makes the data easier to deal with when we want to show it on our website.

#### User Model

Start by creating a folder to hold the code for the website, and within that folder create another folder called `Models`, which will hold - you guessed it - our data models.

Create a new file named `User.php`, and add the following code:

```php
<?php

class User {
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $password;

    public function __construct($id, $firstName, $lastName, $email, $password) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }
}

?>
```

- **Explanation:** This class represents a user in our database. Each user has an ID, first name, last name, email, and password. The constructor initialises these properties.

#### Product Model

Create a new file named `Product.php` in the `Models` directory and add the following code:

```php
<?php

class Product {
    public $id;
    public $name;
    public $price;
    public $description;

    public function __construct($id, $name, $price, $description) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
    }
}

?>
```

- **Explanation:** This class represents a product in our database. Each product has an ID, name, price, and description. The constructor initialises these properties.

#### Order Model

Create a new file named `Order.php` in the `Models` directory and add the following code:

```php
<?php

class Order {
    public $id;
    public $userId;
    public $date;
    public $total;

    public function __construct($id, $userId, $date, $total) {
        $this->id = $id;
        $this->userId = $userId;
        $this->date = $date;
        $this->total = $total;
    }
}

?>
```

- **Explanation:** This class represents an order in our database. Each order has an ID, user ID, date, and total. The constructor initializes these properties.

#### OrderProduct Model

Create a new file named `OrderProduct.php` in the `Models` directory and add the following code:

```php
<?php

class OrderProduct {
    public $id;
    public $orderId;
    public $productId;
    public $quantity;
    public $productName;
    public $productPrice;

    public function __construct($id, $orderId, $productId, $quantity) {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
}

?>
```

- **Explanation:** This class represents the relationship between orders and products in our database. Each order-product relationship has an ID, order ID, product ID, and quantity. The constructor initialises these properties.

You've now created the data models for the website.

### Step 3: Creating the Web Pages

#### Index Page

Create a new file named `index.php` and add the following code:

```php
<?php

// Require the necessary files
require_once 'Models/User.php';
require_once 'Database/Connection.php';

// Initialize users array
$users = [];

// Check if the search form has been submitted
if (isset($_GET['email'])) {
    $email = $_GET['email'];
    // Sanitize input to prevent SQL injection
    $email = pg_escape_string($connection, $email);
    // Fetch users by email
    $query = "SELECT * FROM users WHERE email ILIKE '%$email%'";
} else {
    // Fetch all users
    $query = 'SELECT * FROM users';
}

$result = pg_query($connection, $query);

while ($row = pg_fetch_assoc($result)) {
    $user = new User($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);
    $users[] = $user;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Users</title>
</head>
<body>
    <h1>Users</h1>

    <form method="get" action="index.php">
        <label for="email">Search by Email:</label>
        <input type="text" id="email" name="email">
        <button type="submit">Search</button>
    </form>

    <br><br>

    <?php if (count($users) == 0): ?>
        <p>No users found</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user->firstName; ?></td>
                        <td><?php echo $user->lastName; ?></td>
                        <td><?php echo $user->email; ?></td>
                        <td>
                            <a href="user.php?id=<?php echo $user->id; ?>">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
```

- **Explanation:** This page fetches all users from the database and displays them in a table. Each row in the table has a "View" link that takes the user to a detailed view of the selected user. There is also functionality to allow the users to search for users in the database based on their email address.

#### User Page

Create a new file named `user.php` and add the following code:

```php
<?php

// Require the necessary files
require_once 'Models/User.php';
require_once 'Models/Order.php';
require_once 'Database/Connection.php';

// Get the user ID from the URL
$userId = $_GET['id'];

// Fetch the user details
$query = "SELECT * FROM users WHERE id = $userId LIMIT 1";
$result = pg_query($connection, $query);
$row = pg_fetch_assoc($result);
$user = new User($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);

// Fetch the orders for the user
$query = "SELECT * FROM orders WHERE user_id = $userId";
$result = pg_query($connection, $query);
$orders = [];
while ($row = pg_fetch_assoc($result)) {
    $order = new Order($row['id'], $row['user_id'], $row['date'], $row['total']);
    $orders[] = $order;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User details</title>
</head>
<body>
    <h1>User details</h1>

    <p><a href="index.php">Back</a></p>

    <p><strong>First Name:</strong> <?php echo $user->firstName; ?></p>

    <p><strong>Last Name:</strong> <?php echo $user->lastName; ?></p>

    <p><strong>Email:</strong> <?php echo $user->email; ?></p>

    <h2>Orders</h2>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order->id; ?></td>
                    <td><?php echo $order->date; ?></td>
                    <td><?php echo $order->total; ?></td>
                    <td>
                        <a href="order.php?id=<?php echo $order->id; ?>">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
```

- **Explanation:** This page fetches and displays the details of a specific user, including their orders. Each order has a "View" link that takes the user to a detailed view of the selected order.

#### Order Page

Create a new file named `order.php` and add the following code:

```php
<?php

// Require the necessary files
require_once 'Models/Order.php';
require_once 'Models/OrderProduct.php';
require_once 'Database/Connection.php';

// Get the order ID from the URL
$orderId = $_GET['id'];

// Fetch the order details
$query = "SELECT * FROM orders WHERE id = $orderId LIMIT 1";
$result = pg_query($connection, $query);
$row = pg_fetch_assoc($result);


$order = new Order($row['id'], $row['user_id'], $row['date'], $row['total']);

// Fetch the order products along with the product details
$query = "
    SELECT order_products.id, order_products.order_id, order_products.product_id, order_products.quantity, products.name AS product_name, products.price AS product_price
    FROM order_products
    JOIN products ON order_products.product_id = products.id
    WHERE order_products.order_id = $orderId";

$result = pg_query($connection, $query);
$orderProducts = [];

while ($row = pg_fetch_assoc($result)) {
    $orderProduct = new OrderProduct($row['id'], $row['order_id'], $row['product_id'], $row['quantity']);
    $orderProduct->productName = $row['product_name'];
    $orderProduct->productPrice = $row['product_price'];
    $orderProducts[] = $orderProduct;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order details</title>
</head>
<body>
    <h1>Order details</h1>

    <p><a href="index.php">Back</a></p>

    <p><strong>Date:</strong> <?php echo $order->date; ?></p>

    <p><strong>Total:</strong> <?php echo $order->total; ?></p>

    <h2>Products</h2>

    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderProducts as $orderProduct): ?>
                <tr>
                    <td><?php echo $orderProduct->productId; ?></td>
                    <td><?php echo $orderProduct->productName; ?></td>
                    <td><?php echo $orderProduct->productPrice; ?></td>
                    <td><?php echo $orderProduct->quantity; ?></td>
                    <td>
                        <a href="product.php?id=<?php echo $orderProduct->productId; ?>">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
```

- **Explanation:** This page fetches and displays the details of a specific order, including the products in the order. Each product has a "View" link that takes the user to a detailed view of the selected product.

#### Product Page

Create a new file named `product.php` and add the following code:

```php
<?php

// Require the necessary files
require_once 'Models/Product.php';
require_once 'Database/Connection.php';

// Get the product ID from the URL
$id = $_GET['id'];

// Fetch the product details
$query = "SELECT * FROM products WHERE id = $id";
$result = pg_query($connection, $query);
$row = pg_fetch_assoc($result);
$product = new Product($row['id'], $row['name'], $row['price'], $row['description']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product->name; ?></title>
</head>
<body>
    <h1><?php echo $product->name; ?></h1>

    <p><a href="index.php">Back</a></p>

    <p><strong>Price:</strong> <?php echo $product->price; ?></p>

    <p><strong>Description:</strong> <?php echo $product->description; ?></p>
</body>
</html>
```

- **Explanation:** This page fetches and displays the details of a specific product.

## Conclusion

Congratulations! You've created a simple PHP application that interacts with a PostgreSQL database. This application allows you to view users, their orders, and the products in those orders.

For those who already have experience with databases and web development, you will rightly notice that this application does not follow best practices. The demonstration was written such that it could be understood as easily as possible.

I encourage you to play around with your code. Change things, break things, and extend it with new functionality. The best way to learn is by doing.