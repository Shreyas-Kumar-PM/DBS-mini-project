<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: profile.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up - Revels 2025</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="form-container">
        <h2 class="form-title">Sign Up</h2>
        <form method="POST" action="process_signup.php">
            <input type="text" name="name" placeholder="Full Name" required class="input-field"><br>
            <input type="email" name="email" placeholder="Email" required class="input-field"><br>
            <input type="password" name="password" placeholder="Password" required class="input-field"><br>
            <button type="submit" class="btn">Sign Up</button>
            <p class="switch-link">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
