<!-- profile.php -->
<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

// Get the user information
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $new_username = $_POST['username'];
        $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssi", $new_username, $new_password, $user['id']);

        if ($stmt->execute()) {
            $_SESSION['username'] = $new_username;
            $success = "Your information has been updated successfully.";
        } else {
            $error = "Error updating your information. Please try again.";
        }
    } elseif (isset($_POST['delete'])) {
        // Delete user account
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user['id']);
        if ($stmt->execute()) {
            session_destroy();
            header('Location: index.php');
            exit;
        } else {
            $error = "Error deleting your account. Please try again.";
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
    <title>TechBuy - Profile</title>
</head>

<body>
    <?php include 'include/header.php'; ?>
    <div class="container">
        <h2>Profile</h2>
        <?php if (isset($success))
            echo '<p class="success" style="color: green">' . $success . '</p>';
        ?>
        <?php if (isset($error))
            echo '<p class="error" style="color: red">' . $error . '</p>';
        ?>
        <form action="profile.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="update">Update Profile</button>
        </form>
        <form action="profile.php" method="post">
            <button type="submit" name="delete"
                style="padding: 8px;background-color: red;border-radius: 6px;color: #fff;border: none;margin-top: 25px;">Delete
                Account</button>
        </form>
    </div>
</body>

</html>