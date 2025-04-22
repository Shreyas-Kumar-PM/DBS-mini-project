<?php
session_start();
include "db.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Sanitize
$name = mysqli_real_escape_string($conn, $name);
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);

// Check if user exists
$res = $conn->query("SELECT * FROM users WHERE email='$email'");
if ($res->num_rows > 0) {
    echo "<script>alert('Email already registered!'); window.location.href='signup.php';</script>";
    exit;
}

// Generate delegate ID
$delegate_id = "REV" . rand(10000, 99999);

// Ensure uniqueness
$check = $conn->query("SELECT * FROM users WHERE delegate_id='$delegate_id'");
while ($check->num_rows > 0) {
    $delegate_id = "REV" . rand(10000, 99999);
    $check = $conn->query("SELECT * FROM users WHERE delegate_id='$delegate_id'");
}

// Insert new user
$sql = "INSERT INTO users (name, email, password, delegate_id) VALUES ('$name', '$email', '$password', '$delegate_id')";
if ($conn->query($sql)) {
    $_SESSION['user'] = $email;
    $_SESSION['username'] = $name;
    $_SESSION['delegate_id'] = $delegate_id;
    header("Location: profile.php");
} else {
    echo "Error: " . $conn->error;
}
?>
