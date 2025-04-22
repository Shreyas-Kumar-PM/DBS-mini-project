<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user'];
$res = $conn->query("SELECT * FROM users WHERE email='$email'");
$user = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile - Revels 2025</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="icon" type="image/x-icon" href="assets/icon.png">
</head>
<body>
    <div class="navbar">
        <img src="assets/mit_image.jpg" class="logo">
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="register_event.php">Register</a>
        <a href="payment.php">Payment</a>
        <a href="logout.php" class="signin-btn">Logout</a>
    </div>

    <div class="content">
        <h1 class="revels-title">Welcome, <?= htmlspecialchars($user['name']) ?>!</h1>
        <img src="assets/revelsImage.jpg" class="poster" alt="Revels Poster" style="height: 300px; width:600px;">
        <p class="tagline">
            Email: <?= htmlspecialchars($user['email']) ?><br><br>
            <strong>Delegate ID: <?= htmlspecialchars($user['delegate_id']) ?></strong><br><br>
            THANK YOU FOR REGISTERING. YOU ARE OFFICIALLY REVELIFIED!
        </p>

        <?php
        // Display session messages
        if (isset($_SESSION['message'])) {
            echo '<div class="message">' . htmlspecialchars($_SESSION['message']) . '</div>';
            unset($_SESSION['message']); // Clear the message after displaying it
        }
        ?>
    </div>
</body>
</html>