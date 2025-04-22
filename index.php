<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revels 2025 Official</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="icon" type="image/x-icon" href="assets/icon.png">

    <style>
        /* Apply the new background styling */
        body {
            margin: 0;
            background: linear-gradient(to right, #0f0f0f, #331c1c);
            font-family: 'Segoe UI', sans-serif;
            color: orange;
            text-align: center;
        }

        /* Fade-in animation */
        .fade-in {
            opacity: 0;
            animation: fadeIn 1.5s ease-in-out forwards;
        }

        .fade-in-delay-1 { animation-delay: 0.2s; }
        .fade-in-delay-2 { animation-delay: 0.4s; }
        .fade-in-delay-3 { animation-delay: 0.6s; }
        .fade-in-delay-4 { animation-delay: 0.8s; }
        .fade-in-delay-5 { animation-delay: 1s; }
        .fade-in-delay-6 { animation-delay: 1.2s; }
        .fade-in-delay-7 { animation-delay: 1.4s; }
        .fade-in-delay-8 { animation-delay: 1.6s; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Navbar Styling */
        .navbar {
            background: rgba(0, 0, 0, 0.8); /* Dark background with slight transparency */
            overflow: hidden;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar img {
            height: 50px;
            margin: 10px;
            vertical-align: middle;
        }

        .navbar a {
            float: left;
            display: block;
            color: #fff;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .signin-btn {
            background-color: #ff6f61;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 17px;
        }

        .signin-btn:hover {
            background-color: #ff3b2f;
        }

        /* Content Styling */
        .content {
            text-align: center;
            padding: 50px 20px;
            color: #fff;
        }

        .revels-title {
            font-size: 3rem;
            font-weight: bold;
            color: #ff6f61;
            margin-bottom: 20px;
        }

        .revels-description-container {
            margin-top: 50px;
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .revels-description {
            font-size: 1.2rem;
            line-height: 1.8;
            text-align: justify;
            color: #fff;
        }

        .revels-description h2 {
            color: #ff6f61;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        /* Scrollable Image Container */
        .image-scroll-container {
            display: flex;
            overflow-x: scroll;
            gap: 15px;
            padding: 20px 0;
            justify-content: center;
        }

        .image-scroll-container img {
            max-width: 100%;
            height: auto;
            max-height: 200px;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .image-scroll-container img:hover {
            transform: scale(1.05);
        }

    </style>
</head>
<body>
    <div class="navbar">
        <img src="assets/mit_image.jpg" class="logo fade-in fade-in-delay-1">
        <a href="index.php" class="fade-in fade-in-delay-2">Home</a>
        <a href="dashboard.php" class="fade-in fade-in-delay-3">Dashboard</a>
        <a href="profile.php" class="fade-in fade-in-delay-4">Profile</a>
        <a href="register_event.php" class="fade-in fade-in-delay-5">Register</a>
        <a href="payment.php" class="fade-in fade-in-delay-6">Payment</a>
        <a href="https://www.manipal.edu/mit/news-events.html" class="fade-in fade-in-delay-7">News & Events</a>
        <a href="event_list.php" class="fade-in fade-in-delay-8">Events</a>

        <?php if (isset($_SESSION['user'])): ?>
            <a href="logout.php" class="signin-btn fade-in fade-in-delay-8">Logout</a>
        <?php else: ?>
            <a href="login.php" class="signin-btn fade-in fade-in-delay-8">Log In</a>
            <a href="signup.php" class="signin-btn fade-in fade-in-delay-8">Sign Up</a>
        <?php endif; ?>
    </div>

    <div class="content">
        <h1 class="revels-title fade-in fade-in-delay-2">Revels'25</h1>
        <img src="assets/revelsImage.jpg" class="poster fade-in fade-in-delay-3" alt="Revels Poster" style="height: 400px; width: 800px;">
        <p class="tagline fade-in fade-in-delay-4">
            Explore the culture, traditions, and talents in the grand cultural fest of Manipal Institute Of Technology!
        </p>

        <!-- Revels Description Section -->
        <div class="revels-description-container fade-in fade-in-delay-5">
            <h2>Welcome to Revels'25</h2>
            <p class="revels-description">
                Revels'25 is an exciting celebration of culture, creativity, and talent, held annually at the Manipal Institute of Technology (MIT). It's a platform where students and enthusiasts from across the country come together to showcase their passion, creativity, and diversity through various cultural events. Revels'25 promises a unique experience of performances, competitions, workshops, and unforgettable memories. 

                With an extensive range of events in categories like music, dance, drama, arts, and fashion, Revels'25 ensures there’s something for everyone to enjoy and participate in. It's an incredible opportunity to immerse yourself in the lively atmosphere and connect with like-minded individuals from various walks of life.
            </p>
        </div>

        <!-- Scrollable images section -->
        <div class="image-scroll-container">
            <img src="assets/image1.jpeg" alt="Revels 2019">
            <img src="assets/image2.jpeg" alt="Revels 2020">
            <img src="assets/image3.jpeg" alt="Revels 2021">
            <img src="assets/image4.jpeg" alt="Revels 2022">
            <img src="assets/image5.jpeg" alt="Revels 2023">
            <img src="assets/image6.jpeg" alt="Revels 2024">
            <img src="assets/image7.jpeg" alt="Revels 2024">
            <img src="assets/image8.jpeg" alt="Revels 2024">
            <img src="assets/image8.jpg" alt="Revels 2024">
            <img src="assets/image9.jpg" alt="Revels 2024">
        </div>
    </div>
    <!-- Contact Information Section -->
    <div class="contact-section fade-in fade-in-delay-6">
        <h2>Contact Information</h2>
        <div class="contact-cards">
            <div class="contact-card">
                <h3>Shreyas Kumar P M</h3>
                <p>📞 9087760888</p>
            </div>
            <div class="contact-card">
                <h3>Saurabh Sharma</h3>
                <p>📞 9098284266</p>
            </div>
            <div class="contact-card">
                <h3>Akhil Varanasi</h3>
                <p>📞 9535638152</p>
            </div>
        </div>
    </div>
    <br><br>
</body>
</html>



