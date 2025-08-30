<!-- index.php -->
<?php include 'db.php'; ?>
<?php session_start(); // Start session to access session variables ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>TechBuy - Home</title>
    <style>
        .alert {
            padding: 15px;
            background-color: rgb(56, 59, 59);
            color: white;
            margin-top: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php include 'include/header.php'; ?>
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert" id="alert">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']); // Clear message after displaying it
                ?>
            </div>
        <?php endif; ?>
        <h2>Products</h2>
        <?php
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($product = $result->fetch_assoc()) {
                echo '<div class="product">';
                echo '<img src="' . $product["image"] . '" alt="' . $product["name"] . '">';
                echo '<h3>' . $product["name"] . '</h3>';
                echo '<p>Price: $' . $product["price"] . '</p>';
                echo '<a href="product.php?id=' . $product["id"] . '">View Details</a> | ';
                echo '<a href="cart.php?add=' . $product["id"] . '">Add to Cart</a>';
                echo '</div>';
            }
        } else {
            echo "No products found.";
        }
        ?>
    </div>
    <script>
        // Function to hide the alert after 3 seconds
        setTimeout(function () {
            var alert = document.getElementById('alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);
    </script>
</body>

</html>