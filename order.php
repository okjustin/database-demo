<?php

// Require the necessary files
require_once 'Models/User.php';
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
    <link rel="stylesheet" type="text/css" href="styles.css">

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
</body>
</html>