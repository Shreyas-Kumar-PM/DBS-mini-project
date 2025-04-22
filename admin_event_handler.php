<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include "db.php";

// Check if the user is logged in as admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Create Stored Procedure if it doesn't exist (PLSQL code in PHP)
$createProcedure = "
    DELIMITER //

    CREATE PROCEDURE UpdateEventTime(IN event_id INT, IN new_time TIME)
    BEGIN
        UPDATE events
        SET event_time = new_time
        WHERE event_id = event_id;
    END //

    DELIMITER ;
";

// Execute the procedure creation query
$conn->query($createProcedure);

// Add Event (Handle form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_event'])) {
    $event_name = $_POST['event_name'];
    $event_schedule = $_POST['event_schedule'];
    $event_time = $_POST['event_time'];

    $stmt = $conn->prepare("INSERT INTO events (event_name, event_schedule, event_time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $event_name, $event_schedule, $event_time);
    $stmt->execute();
    $stmt->close();
}

// Delete Event (Handle delete request)
if (isset($_GET['delete_event_id'])) {
    $event_id = $_GET['delete_event_id'];

    $stmt = $conn->prepare("DELETE FROM events WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();
}

// Update Event Time (Handle update request)
if (isset($_POST['update_event_time'])) {
    $event_id = $_POST['event_id'];
    $event_time = $_POST['event_time'];

    // Call the stored procedure to update event time
    $query = "CALL UpdateEventTime(?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $event_id, $event_time); // 'i' for integer and 's' for string (time)
    $stmt->execute();
    $stmt->close();
}

// Fetch total events
$eventCount = $conn->query("SELECT total_events FROM (SELECT COUNT(*) AS total_events FROM events) AS subquery")->fetch_assoc()['total_events'];


// Fetch total registrations
$registrationCount = $conn->query("SELECT total_regs FROM (SELECT COUNT(*) AS total_regs FROM registrations) AS subquery")->fetch_assoc()['total_regs'];


// Fetch total revenue
$revenueResult = $conn->query("SELECT total_revenue FROM (SELECT SUM(amount) AS total_revenue FROM payment) AS subquery");
$totalRevenue = $revenueResult->fetch_assoc()['total_revenue'] ?? 0;

// Fetch upcoming events
$upcomingEvents = $conn->query("SELECT * FROM (SELECT * FROM events WHERE event_schedule >= CURDATE()) AS upcoming ORDER BY upcoming.event_schedule ASC LIMIT 5");


// Fetch recent registrations
$recentRegs = $conn->query("
    SELECT reg.name, reg.delegate_id, reg.event_id 
    FROM (
        SELECT u.name, u.delegate_id, r.event_id 
        FROM registrations r 
        JOIN users u ON r.user_email = u.email
    ) AS reg
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Revels 2025</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="icon" type="image/x-icon" href="assets/icon.png">
    <style>
        body {
            margin: 0;
            background: linear-gradient(to right, #0f0f0f, #331c1c);
            font-family: 'Segoe UI', sans-serif;
            color: orange;
            text-align: center;
        }

        .dashboard-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(255, 165, 0, 0.2);
        }

        .dashboard-title {
            font-size: 32px;
            margin-bottom: 30px;
            color: #ffa500;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .stat-box {
            flex: 1 1 250px;
            margin: 10px;
            background-color: rgba(255, 165, 0, 0.2);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(255, 165, 0, 0.3);
        }

        .stat-box h3 {
            margin-bottom: 10px;
            color: #ff9900;
        }

        .stat-box p {
            font-size: 20px;
            font-weight: bold;
            color: #fff;
        }

        .section {
            text-align: left;
            margin-top: 30px;
        }

        .section h3 {
            color: #ff9900;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        th, td {
            padding: 10px;
            border: 1px solid orange;
            color: white;
            text-align: center;
        }

        th {
            background-color: #ff9900;
            color: black;
        }

        td {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .logout-btn {
            background-color: #ff9900;
            color: black;
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
            display: inline-block;
        }

        .logout-btn:hover {
            background-color: #ffa500;
        }

        .add-event-form {
            background-color: rgba(255, 165, 0, 0.1);
            padding: 20px;
            border-radius: 12px;
            margin-top: 30px;
            box-shadow: 0 0 15px rgba(255, 165, 0, 0.2);
        }

        .form-field {
            margin-bottom: 15px;
        }

        .form-field input, .form-field select, .form-field button {
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            border: 1px solid orange;
            margin-top: 5px;
        }

        .form-field button {
            background-color: #ff9900;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        .form-field button:hover {
            background-color: #ffa500;
        }

        .actions {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .actions form {
            display: inline;
        }

        .actions a {
            color: red;
            font-weight: bold;
            text-decoration: none;
            padding: 5px;
            background-color: #f2f2f2;
            border-radius: 8px;
        }

        .actions a:hover {
            background-color: #ff6f00;
            color: white;
        }

    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1 class="dashboard-title">Welcome, Admin</h1>

        <div class="stats">
            <div class="stat-box">
                <h3>Total Events</h3>
                <p><?= $eventCount ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Registrations</h3>
                <p><?= $registrationCount ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Revenue</h3>
                <p>₹<?= $totalRevenue ?></p>
            </div>
        </div>

        <!-- Add Event Form -->
        <div class="add-event-form">
            <h3>Add New Event</h3>
            <form method="POST">
                <div class="form-field">
                    <label for="event_name">Event Name:</label>
                    <input type="text" id="event_name" name="event_name" required>
                </div>
                <div class="form-field">
                    <label for="event_schedule">Event Date:</label>
                    <input type="date" id="event_schedule" name="event_schedule" required>
                </div>
                <div class="form-field">
                    <label for="event_time">Event Time:</label>
                    <input type="time" id="event_time" name="event_time" required>
                </div>
                <button type="submit" name="add_event">Add Event</button>
            </form>
        </div>

        <!-- Upcoming Events Table -->
        <div class="section">
            <h3>Upcoming Events</h3>
            <table>
                <tr>
                    <th>Event ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Actions</th>
                </tr>
                <?php while ($event = $upcomingEvents->fetch_assoc()): ?>
                    <tr>
                        <td><?= $event['event_id'] ?></td>
                        <td><?= $event['event_name'] ?></td>
                        <td><?= $event['event_schedule'] ?></td>
                        <td><?= $event['event_time'] ?></td>
                        <td class="actions">
                            <a href="admin_dashboard.php?delete_event_id=<?= $event['event_id'] ?>">Delete</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                                <input type="time" name="event_time" value="<?= $event['event_time'] ?>" required>
                                <button type="submit" name="update_event_time">Update Time</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <!-- Recent Registrations -->
        <div class="section">
            <h3>Recent Registrations</h3>
            <table>
                <tr>
                    <th>Participant</th>
                    <th>Delegate ID</th>
                    <th>Event ID</th>
                </tr>
                <?php while ($reg = $recentRegs->fetch_assoc()): ?>
                    <tr>
                        <td><?= $reg['name'] ?></td>
                        <td><?= $reg['delegate_id'] ?></td>
                        <td><?= $reg['event_id'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <!-- Logout Button -->
        <a href="index.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
