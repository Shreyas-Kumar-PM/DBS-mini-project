<?php
session_start();
include "db.php";

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Get the user's email and the event ID from the POST request
$email = $_SESSION['user'];
$event_id = $_POST['event_id'];

// Ensure that the event ID is provided
if (empty($event_id)) {
    $_SESSION['message'] = "Invalid event selection.";
    header("Location: register_event.php");
    exit;
}

// Check if the user has already registered for the event
$res = $conn->query("SELECT * FROM registrations WHERE user_email = '$email' AND event_id = '$event_id'");

if ($res->num_rows > 0) {
    // If the user is already registered, show a message and redirect
    $_SESSION['message'] = "You have already registered for this event.";
    header("Location: register_event.php");
    exit;
}

// Insert the registration into the database
$query = "INSERT INTO registrations (user_email, event_id) VALUES ('$email', '$event_id')";

if ($conn->query($query) === TRUE) {
    // Successfully registered, set a success message and redirect to profile.php
    $_SESSION['message'] = "Successfully registered for the event!";
    header("Location: profile.php");
    exit;
} else {
    // If there is an error in the query, set an error message and redirect back to register_event.php
    $_SESSION['message'] = "There was an error registering for the event. Please try again.";
    header("Location: register_event.php");
    exit;
}
?>
