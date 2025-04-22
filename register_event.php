<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user'];

// Fetch user's pass type
$res = $conn->query("SELECT pass_type FROM users WHERE email='$email'");
$user = $res->fetch_assoc();

if (!$user || $user['pass_type'] === 'none') {
    header("Location: payment.php");
    exit;
}

$passType = $user['pass_type'];

// Fetch events based on pass
if ($passType === 'general') {
    $eventQuery = "SELECT * FROM events WHERE event_type = 'general'";
} else {
    // For flagship pass, show all events
    $eventQuery = "SELECT * FROM events";
}

$eventRes = $conn->query($eventQuery);

$errorMessage = '';  // Initialize an empty error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $event_id = $_POST['event_id'];
        
        // Start the transaction
        $conn->begin_transaction();
        
        // Attempt to register the user for the event
        $stmt = $conn->prepare("INSERT INTO registrations (user_email, event_id) VALUES (?, ?)");
        $stmt->bind_param("si", $email, $event_id);
        $stmt->execute();
        
        // Commit the transaction
        $conn->commit();
        
        // Registration successful, redirect to profile page
        $_SESSION['message'] = "Event registered successfully!";
        header("Location: profile.php");
        exit;
        
    } catch (mysqli_sql_exception $e) {
        // In case of error (trigger is invoked), catch the exception
        $conn->rollback();
        
        // Set the error message
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register for Events - Revels 2025</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="icon" type="image/x-icon" href="assets/icon.png">
</head>
<body>
    <div class="form-container">
        <h2 class="form-title">Register for Events (<?= ucfirst($passType) ?> Pass)</h2>

        <?php
        // Check if there is a session message to display
        if (isset($_SESSION['message'])) {
            echo '<div class="message">' . htmlspecialchars($_SESSION['message']) . '</div>';
            unset($_SESSION['message']); // Clear the message after displaying it
        }
        ?>

        <!-- Display error message if exists -->
        <?php if ($errorMessage): ?>
            <div class="error-message">
                <?= htmlspecialchars($errorMessage) ?>
            </div>
            <script>
                // Redirect to profile page after 5 seconds
                setTimeout(function() {
                    window.location.href = "profile.php";
                }, 5000); // 5 seconds delay
            </script>
        <?php endif; ?>

        <?php if ($eventRes->num_rows > 0): ?>
            <?php while ($event = $eventRes->fetch_assoc()): ?>
                <div class="event-box">
                    <h3><?= htmlspecialchars($event['event_name']) ?></h3>
                    <p><?= htmlspecialchars($event['event_description']) ?></p>
                    <p><strong>Type:</strong> <?= ucfirst($event['event_type']) ?></p>
                    <form method="POST" action="">
                        <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">
                        <button type="submit" class="btn">Register</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No events available for your pass type.</p>
        <?php endif; ?>
    </div>
</body>
</html>
