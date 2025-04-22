<?php
session_start();
include "db.php";

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'judge') {
    header("Location: login.php");
    exit;
}

$judgeEmail = $_SESSION['user'];

// Fetch event the judge is assigned to
$eventQuery = $conn->query("SELECT event_id, event_name FROM judge_event WHERE judge_email = '$judgeEmail'");
$eventData = $eventQuery->fetch_assoc();

if (!$eventData) {
    echo "No event assigned to you.";
    exit;
}

$eventId = $eventData['event_id'];
$eventName = $eventData['event_name'];

// Handle score submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_score'])) {
    $delegateId = $_POST['delegate_id'];
    $marks = $_POST['marks'];

    $stmt = $conn->prepare("INSERT INTO scores (event_id, delegate_id, marks) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $eventId, $delegateId, $marks);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Score submitted successfully.');</script>";
}

// Fetch leaderboard
$leaderboard = [];
if (isset($_POST['calculate_result'])) {
    $result = $conn->query("
    SELECT delegate_id, marks 
    FROM (
        SELECT delegate_id, marks 
        FROM scores 
        WHERE event_id = $eventId
    ) AS subquery 
    ORDER BY marks DESC
    ");
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Judge Panel - <?= htmlspecialchars($eventName) ?></title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="icon" type="image/x-icon" href="assets/icon.png">
    <style>
        body {
            background: linear-gradient(to right, #0f0f0f, #331c1c);
            font-family: 'Segoe UI', sans-serif;
            color: orange;
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: orange;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 0 10px orange;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            background-color: #222;
            color: orange;
        }

        .btn {
            padding: 10px 20px;
            background-color: orange;
            border: none;
            color: black;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            color: orange;
        }

        th, td {
            padding: 10px;
            border: 1px solid orange;
            text-align: center;
        }

        .logout-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: crimson;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <button onclick="window.location.href='logout.php'" class="logout-btn">Logout</button>

    <div class="container">
        <h2>Judge Panel - <?= htmlspecialchars($eventName) ?></h2>

        <form method="POST">
            <input type="text" name="delegate_id" placeholder="Delegate ID" class="input-field" required>
            <input type="number" name="marks" placeholder="Marks" class="input-field" required>
            <button type="submit" name="submit_score" class="btn">Submit Score</button>
        </form>

        <form method="POST">
            <button type="submit" name="calculate_result" class="btn">Calculate Result</button>
        </form>

        <?php if (!empty($leaderboard)): ?>
            <h3>Leaderboard</h3>
            <table>
                <tr>
                    <th>Rank</th>
                    <th>Delegate ID</th>
                    <th>Marks</th>
                </tr>
                <?php $rank = 1; foreach ($leaderboard as $entry): ?>
                    <tr>
                        <td><?= $rank++ ?></td>
                        <td><?= htmlspecialchars($entry['delegate_id']) ?></td>
                        <td><?= htmlspecialchars($entry['marks']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
