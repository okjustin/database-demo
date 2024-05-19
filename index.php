<?php

// Require the necessary files
require_once 'Models/User.php';
require_once 'Database/Connection.php';

// Fetch all users
$query = 'SELECT * FROM users';
$result = pg_query($connection, $query);
$users = [];
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
    <title>Users</title>
</head>
<body>
    <h1>Users</h1>
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
</body>
</html>