<?php
session_start();
include "db.php";

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];  // From dropdown

// Sanitize input
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);
$role = mysqli_real_escape_string($conn, $role);

// Determine table and redirect path based on role
switch ($role) {
    case 'participant':
        $table = "users";
        $redirect = "profile.php";
        break;

    case 'admin':
        $table = "admins";
        $redirect = "admin_dashboard.php";
        break;

    case 'judge':
        $table = "judges";
        $redirect = "judge_scoring.php";
        break;

    default:
        echo "<script>alert('Invalid role selected'); window.location.href='login.php';</script>";
        exit;
}

// Check if user exists
$sql = "SELECT * FROM $table WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    if ($user['password'] === $password) {
        // Set session variables based on role
        if ($role === 'participant') {
            $_SESSION['user'] = [
                'email' => $email,
                'name' => $user['name'],
                'delegate_id' => $user['delegate_id'],
            ];
        } elseif ($role === 'admin') {
            $_SESSION['admin'] = $email;
            $_SESSION['admin_name'] = $user['name'];
        } elseif ($role === 'judge') {
            $_SESSION['user'] = [
                'email' => $email,
                'name' => $user['name'],
                'judge_id' => $user['judge_id'],
            ];
        }

        $_SESSION['role'] = $role; // Store role for global access
        header("Location: $redirect");
        exit;
    } else {
        echo "<script>alert('Incorrect password'); window.location.href='login.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('User not found'); window.location.href='login.php';</script>";
    exit;
}