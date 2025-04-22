<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user'];

// Fetch user data with error handling
$res = $conn->prepare("SELECT * FROM users WHERE email = ?");
if (!$res) {
    die("Error preparing SQL statement: " . $conn->error);
}
$res->bind_param("s", $email);
$res->execute();
$userResult = $res->get_result();
if ($userResult->num_rows === 0) {
    die("No user found with email: " . $email);
}
$user = $userResult->fetch_assoc();

// Fetch registered events for the user
$eventQuery = "
    SELECT e.event_name, e.event_schedule, e.venue
    FROM events e
    JOIN registrations r ON e.event_id = r.event_id
    WHERE r.user_email = ?
";
$stmt = $conn->prepare($eventQuery);
if (!$stmt) {
    die("Error preparing event query: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$eventRes = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Revels 2025</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="navbar">
        <img src="assets/mit_image.jpg" class="logo">
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="register_event.php">Register</a>
        <a href="payment.php">Payment</a>
        <a href="logout.php" class="signin-btn">Logout</a>
    </div>

    <div class="content">
        <h2>Your Registered Events</h2>
        <?php if ($eventRes->num_rows > 0): ?>
            <table class="event-table">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Event Schedule</th>
                        <th>Venue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($event = $eventRes->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($event['event_name']) ?></td>
                            <td><?= htmlspecialchars($event['event_schedule']) ?></td>
                            <td><?= htmlspecialchars($event['venue']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have not registered for any events yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>

