<!-- cart.php -->
<?php
session_start();
include 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['add'])) {
    $product_id = intval($_GET['add']);
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 0;
    }
    $_SESSION['cart'][$product_id]++;
    header('Location: cart.php');
    exit;
}

if (isset($_GET['remove'])) {
    $product_id = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]--;
        if ($_SESSION['cart'][$product_id] <= 0) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>TechBuy - Cart</title>
</head>

<body>
    <?php include 'include/header.php'; ?>
    <div class="container">
        <h2>Shopping Cart</h2>
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <?php foreach ($_SESSION['cart'] as $product_id => $quantity): ?>
                <?php
                $sql = "SELECT * FROM products WHERE id = $product_id";
                $result = $conn->query($sql);
                $product = $result->fetch_assoc();
                ?>
                <div class="cart-item">
                    <h3><?php echo $product['name']; ?></h3>
                    <p>Quantity: <?php echo $quantity; ?></p>
                    <p>Price: $<?php echo $product['price']; ?></p>
                    <a href="cart.php?remove=<?php echo $product_id; ?>">Remove one</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <a href="index.php">Continue shopping</a>
    </div>
</body>

</html>