<?php
session_start();
include 'db.php';

// Check if the user is logged in as a judge
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'judge') {
    header("Location: login.php");
    exit;
}

// Get the event details for the judge (you can modify this based on your database structure)
$judge_id = $_SESSION['user']['judge_id'];
$query = "SELECT e.event_id, e.event_name
          FROM events e 
          JOIN judge_assignments ja ON e.event_id = ja.event_id
          WHERE ja.judge_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $judge_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    die("No event assigned to you.");
}

// Handle scoring submission
$error_message = ""; // Initialize error message variable
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_score'])) {
    $delegate_id = $_POST['delegate_id'];
    $score = $_POST['score'];

    // Check if the delegate_id exists in the users table
    $user_check_query = "SELECT delegate_id FROM users WHERE delegate_id = ?";
    $user_check_stmt = $conn->prepare($user_check_query);
    $user_check_stmt->bind_param("s", $delegate_id);
    $user_check_stmt->execute();
    $user_check_result = $user_check_stmt->get_result();

    if ($user_check_result->num_rows === 0) {
        // Delegate ID not found in the users table
        $error_message = "No user found with Delegate ID: " . htmlspecialchars($delegate_id);
    } else {
        // Insert the score into the database
        $score_query = "INSERT INTO scores (delegate_id, event_name, score) 
                        VALUES (?, ?, ?)";
        $score_stmt = $conn->prepare($score_query);
        $score_stmt->bind_param("ssi", $delegate_id, $event['event_name'], $score);
        $score_stmt->execute();
        $score_stmt->close();
    }
}

// Fetch the leaderboard based on scores entered for this event
$leaderboard_query = "SELECT delegate_id, total_score
FROM (
    SELECT delegate_id, SUM(score) AS total_score
    FROM scores
    WHERE event_name = ?
    GROUP BY delegate_id
) AS subquery
ORDER BY total_score DESC";
$leaderboard_stmt = $conn->prepare($leaderboard_query);
$leaderboard_stmt->bind_param("s", $event['event_name']);
$leaderboard_stmt->execute();
$leaderboard_result = $leaderboard_stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judge Scoring - Revels 2025</title>
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

        .form-container {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(255, 165, 0, 0.5);
            width: 600px;
            margin: 50px auto;
            color: orange;
        }

        .form-title {
            font-size: 32px;
            margin-bottom: 30px;
            color: orange;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            margin: 15px 0;
            border: none;
            border-radius: 10px;
            background-color: #222;
            color: orange;
            font-size: 16px;
        }

        .btn {
            background-color: orange;
            color: #000;
            border: none;
            padding: 14px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            font-size: 18px;
        }

        .btn:hover {
            background-color: #ff9900;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 15px;
            border: 1px solid orange;
            color: white;
            text-align: center;
        }

        th {
            background-color: #ff9900;
            color: black;
            font-size: 18px;
        }

        td {
            background-color: rgba(255, 255, 255, 0.05);
            font-size: 16px;
        }

        .logout-btn {
            background-color: #ff9900;
            color: black;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 40px;
            font-size: 18px;
            display: inline-block;
        }

        .logout-btn:hover {
            background-color: #ffa500;
        }

        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="form-title">Event: <?= $event['event_name'] ?></h2>

        <!-- Display error message if delegate ID is not found -->
        <?php if ($error_message): ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php endif; ?>

        <!-- Scoring Form -->
        <form method="POST">
            <input type="text" name="delegate_id" class="input-field" placeholder="Enter Delegate ID (REVxxxxx)" required>
            <input type="number" name="score" class="input-field" placeholder="Enter Score" min="0" max="100" required>
            <button type="submit" name="submit_score" class="btn">Submit Score</button>
        </form>

        <hr>

        <!-- Leaderboard Table -->
        <h3>Leaderboard</h3>
        <table>
            <tr>
                <th>Rank</th>
                <th>Delegate ID</th>
                <th>Total Score</th>
            </tr>
            <?php
            // Display leaderboard if scores are available
            $rank = 1;
            while ($row = $leaderboard_result->fetch_assoc()) {
                echo "<tr><td>{$rank}</td><td>{$row['delegate_id']}</td><td>{$row['total_score']}</td></tr>";
                $rank++;
            }
            ?>
        </table>

        <!-- Logout Button -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
