<?php
$conn = new mysqli("localhost", "root", "", "revels");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
