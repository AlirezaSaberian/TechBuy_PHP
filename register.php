<!-- register.php -->
<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        // Using Prepared Statements
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username; // Store the username in session
        $_SESSION['message'] = "You have successfully registered!";

        // Handle duplicate username (1062) or other errors
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $error = "Username already exists. Please choose another one.";
        } else {
            $error = "Error during registration. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>TechBuy - Register</title>
</head>

<body>
    <?php include 'include/header.php'; ?>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error))
            echo '<p class="error" style="color: red">' . $error . '</p>';
        ?>
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>