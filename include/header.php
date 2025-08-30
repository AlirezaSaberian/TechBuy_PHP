<!-- include/header.php -->
<header>
    <h1>Welcome to TechBuy :)</h1>
    <nav>
        <a href="index.php">Home</a> |
        <a href="cart.php">Cart</a> |
        <a href="register.php">Register</a> |
        <?php if (!isset($_SESSION['loggedin'])): ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['loggedin'])): ?>
            <a href="profile.php">Profile</a> |
            <a href="logout.php">Logout</a>
        <?php endif; ?>
    </nav>
</header>