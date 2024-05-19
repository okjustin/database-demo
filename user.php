<?php

require_once 'Models/User.php';
require_once 'Database/Connection.php';

$userId = $_GET['id'];

$query = "SELECT * FROM users WHERE id = $userId LIMIT 1";

$result = pg_query($connection, $query);

$row = pg_fetch_assoc($result);

$user = new User($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['password']);

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

    <p><a href="index.php">Back</a></p>#

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