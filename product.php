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
    <link rel="stylesheet" type="text/css" href="styles.css">

    <title><?= $product->name ?></title>
</head>
<body>
    <h1><?= $product->name ?></h1>

    <p><a href="index.php">Back</a></p>

    <p><strong>Price:</strong> <?= $product->price ?></p>

    <p><strong>Description:</strong> <?= $product->description ?></p>
</body>
</html>