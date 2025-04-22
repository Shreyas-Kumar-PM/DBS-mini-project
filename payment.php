<?php
session_start();
include "db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pass_type = $_POST['pass_type'];
    $email = $_SESSION['user'];

    // Set amount based on pass type
    $amount = ($pass_type === 'general') ? 250 : 500;

    // Update user's pass type
    $update = $conn->query("UPDATE users SET pass_type='$pass_type' WHERE email='$email'");

    if ($update) {
        // Insert into payment table
        $payment_date = date('Y-m-d H:i:s');
        
        // Begin transaction to handle error gracefully
        $conn->begin_transaction();
        try {
            $insertPayment = $conn->query("INSERT INTO payment (email, amount, pass_type, payment_date) VALUES ('$email', '$amount', '$pass_type', '$payment_date')");

            if ($insertPayment) {
                $conn->commit();
                echo "<script>alert('Payment marked as successful!'); window.location.href = 'register_event.php';</script>";
                exit;
            } else {
                $conn->rollback();
                echo "<script>alert('Payment updated, but logging to payment table failed.');</script>";
            }
        } catch (mysqli_sql_exception $e) {
            $conn->rollback();
            // If a duplicate payment error occurs, show a specific message
            if ($e->getCode() == 45000) {
                echo "<script>alert('You have already made a payment.'); window.location.href = 'profile.php';</script>";
            } else {
                echo "<script>alert('An error occurred: " . $e->getMessage() . "'); window.location.href = 'profile.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Payment failed. Please try again.'); window.location.href = 'profile.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment - Revels 2025</title>
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
            max-width: 700px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.05);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(255, 165, 0, 0.2);
        }

        .form-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: orange;
        }

        .payment-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
            flex-wrap: wrap;
        }

        .form-container form {
            flex: 1;
        }

        .radio-option {
            margin-bottom: 20px;
            text-align: left;
        }

        .radio-option input {
            margin-right: 10px;
        }

        .btn {
            padding: 10px 25px;
            font-size: 16px;
            background-color: orange;
            color: black;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .btn:hover {
            background-color: #ffaa00;
        }

        .qr-image {
            max-width: 250px;
            height: auto;
            border: 2px solid #ccc;
            border-radius: 12px;
        }

        .qr-text {
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
            color: orange;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="form-title">Select Your Delegate Pass & Pay</h2>

        <div class="payment-wrapper">
            <!-- Form Section -->
            <form method="POST">
                <div class="radio-option">
                    <input type="radio" id="general" name="pass_type" value="general" required>
                    <label for="general">General Pass - ₹250</label>
                </div>

                <div class="radio-option">
                    <input type="radio" id="flagship" name="pass_type" value="flagship">
                    <label for="flagship">Flagship Pass - ₹500</label>
                </div>

                <button type="submit" class="btn">I’ve Paid, Continue</button>
            </form>

            <!-- QR Code Section -->
            <div>
                <img src="assets/qr_code.jpeg" alt="Scan to Pay QR" class="qr-image">
                <p class="qr-text">Scan to pay via UPI</p>
            </div>
        </div>
    </div>
</body>
</html>





