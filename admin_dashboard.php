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

// Add Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_event'])) {
    $event_name = $_POST['event_name'];
    $event_schedule = $_POST['event_schedule'];
    $event_time = $_POST['event_time'];

    $stmt = $conn->prepare("INSERT INTO events (event_name, event_schedule, event_time) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $event_name, $event_schedule, $event_time);
    $stmt->execute();
    $stmt->close();
}

// Delete Event
if (isset($_GET['delete_event_id'])) {
    $event_id = $_GET['delete_event_id'];

    $stmt = $conn->prepare("DELETE FROM events WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();
}

// Update Event Time
if (isset($_POST['update_event_time'])) {
    $event_id = $_POST['event_id'];
    $event_time = $_POST['event_time'];

    $stmt = $conn->prepare("UPDATE events SET event_time = ? WHERE event_id = ?");
    $stmt->bind_param("si", $event_time, $event_id);
    $stmt->execute();
    $stmt->close();
}

// Assign Judge
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_judge'])) {
    $judge_id = $_POST['judge_id'];
    $event_id = $_POST['event_id'];

    $check = $conn->prepare("SELECT * FROM judge_assignments WHERE judge_id = ?");
    $check->bind_param("i", $judge_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Judge already assigned to another event!');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO judge_assignments (judge_id, event_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $judge_id, $event_id);
        $stmt->execute();
        $stmt->close();
    }

    $check->close();
}

// Fetch stats
$eventCount = $conn->query("SELECT COUNT(*) AS total_events FROM events")->fetch_assoc()['total_events'];
$registrationCount = $conn->query("SELECT COUNT(*) AS total_regs FROM registrations")->fetch_assoc()['total_regs'];
$revenueResult = $conn->query("SELECT SUM(amount) AS total_revenue FROM payment");
$totalRevenue = $revenueResult->fetch_assoc()['total_revenue'] ?? 0;

// Fetch events and users
$upcomingEvents = $conn->query("SELECT * FROM events WHERE event_schedule >= CURDATE() ORDER BY event_schedule ASC LIMIT 5");
$recentRegs = $conn->query("SELECT users.name, users.delegate_id, registrations.event_id FROM registrations JOIN users ON registrations.user_email = users.email");
$judges = $conn->query("SELECT * FROM judges");
$events = $conn->query("SELECT event_id, event_name FROM events");
$assignedJudges = $conn->query("
    SELECT j.name, e.event_name 
    FROM judge_assignments ja
    JOIN judges j ON ja.judge_id = j.judge_id
    JOIN events e ON ja.event_id = e.event_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            background-color: rgba(255, 255, 255, 0.05);
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
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid orange;
            text-align: center;
        }
        th {
            background-color: #ff9900;
            color: black;
        }
        td {
            color: white;
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

    <!-- Add Event -->
    <div class="add-event-form">
        <h3>Add New Event</h3>
        <form method="POST">
            <div class="form-field">
                <label for="event_name">Event Name:</label>
                <input type="text" name="event_name" required>
            </div>
            <div class="form-field">
                <label for="event_schedule">Event Date:</label>
                <input type="date" name="event_schedule" required>
            </div>
            <div class="form-field">
                <label for="event_time">Event Time:</label>
                <input type="time" name="event_time" required>
            </div>
            <button type="submit" name="add_event">Add Event</button>
        </form>
    </div>

    <!-- Upcoming Events -->
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
                        <a href="?delete_event_id=<?= $event['event_id'] ?>">Delete</a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                            <input type="time" name="event_time" required>
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

    <!-- Judge Management -->
    <div class="section">
        <h3>Judge Details</h3>
        <table>
            <tr>
                <th>Judge ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php foreach ($judges as $judge): ?>
                <tr>
                    <td><?= $judge['judge_id'] ?></td>
                    <td><?= $judge['name'] ?></td>
                    <td><?= $judge['email'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3 style="margin-top: 30px;">Assign Judge to Event</h3>
        <form method="POST" class="add-event-form">
            <div class="form-field">
                <label for="judge_id">Select Judge:</label>
                <select name="judge_id" required>
                    <option disabled selected>Select a judge</option>
                    <?php
                    $judgesList = $conn->query("SELECT * FROM judges");
                    while ($j = $judgesList->fetch_assoc()):
                    ?>
                        <option value="<?= $j['judge_id'] ?>"><?= $j['name'] ?> (<?= $j['email'] ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-field">
                <label for="event_id">Select Event:</label>
                <select name="event_id" required>
                    <option disabled selected>Select an event</option>
                    <?php foreach ($events as $e): ?>
                        <option value="<?= $e['event_id'] ?>"><?= $e['event_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="assign_judge">Assign Judge</button>
        </form>

        <!-- Assigned Judges Table -->
        <h3 style="margin-top: 30px;">Assigned Judges</h3>
        <table>
            <tr>
                <th>Judge Name</th>
                <th>Event Name</th>
            </tr>
            <?php while ($row = $assignedJudges->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['event_name'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Logout -->
    <a href="index.php" class="logout-btn">Logout</a>
</div>
</body>
</html>
