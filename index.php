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