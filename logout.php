<!-- logout.php -->
<?php
session_start();
session_unset();
session_destroy();
session_start(); // Start new session to set the message
$_SESSION['message'] = "You have successfully logged out!";
header('Location: index.php');
exit;
?>