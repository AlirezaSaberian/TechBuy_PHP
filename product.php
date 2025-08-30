<!-- product.php -->
<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>TechBuy - Product Details</title>
</head>

<body>
    <?php include 'include/header.php'; ?>
    <div class="container">
        <?php
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM products WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $product = $result->fetch_assoc();
                echo '<div class="product">';
                echo '<img src="' . $product["image"] . '" alt="' . $product["name"] . '">';
                echo '<h3>' . $product["name"] . '</h3>';
                echo '<p>Price: $' . $product["price"] . '</p>';
                echo '<p>Description: ' . $product["description"] . '</p>';
                echo '<a href="index.php">Back to products</a>';
                echo '</div>';
            } else {
                echo '<p>Product not found.</p>';
                echo '<a href="index.php">Back to products</a>';
            }
        } else {
            echo '<p>No product ID specified.</p>';
            echo '<a href="index.php">Back to products</a>';
        }
        ?>
    </div>
</body>

</html>