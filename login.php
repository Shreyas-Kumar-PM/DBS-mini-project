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
    <title>Login - Revels 2025</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="icon" type="image/x-icon" href="assets/icon.png">
    <style>
        body {
            margin: 0;
            background: linear-gradient(to right, #0f0f0f, #331c1c);
            font-family: 'Segoe UI', sans-serif;
            color: orange;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(255, 165, 0, 0.5);
            width: 350px;
        }

        .form-title {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .input-field, .role-select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            background-color: #222;
            color: orange;
        }

        .btn {
            background-color: orange;
            color: #000;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

        .btn:hover {
            background-color: #ff9900;
        }

        .switch-link {
            margin-top: 15px;
            font-size: 14px;
        }

        .switch-link a {
            color: orange;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="form-title">Login</h2>
        <form method="POST" action="validate_login.php">
            <input type="email" name="email" placeholder="Email" required class="input-field">
            <input type="password" name="password" placeholder="Password" required class="input-field">
            
            <!-- Role Selection Dropdown -->
            <select name="role" class="role-select" required style="width: 340px;">
                <option value="participant" selected>Participant</option>
                <option value="admin">Admin</option>
                <option value="judge">Judge</option>
            </select>
            <br><br>
            <button type="submit" class="btn">Login</button>
            <p class="switch-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
        </form>
    </div>
</body>
</html>