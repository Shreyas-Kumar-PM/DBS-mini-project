<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Events - Revels 2025</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link rel="icon" type="image/x-icon" href="assets/icon.png">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #222;
        }

        .navbar {
            background-color: #002244;
            color: white;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            font-weight: bold;
        }

        .navbar .signin-btn {
            background-color: orange;
            color: #fff;
            padding: 8px 14px;
            border-radius: 8px;
        }

        .logo {
            height: 50px;
            margin-right: 20px;
        }

        .event-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease;
        }

        .event {
            margin-bottom: 40px;
        }

        .event h2 {
            color: #002244;
            margin-bottom: 10px;
        }

        .event p {
            margin-bottom: 10px;
        }

        .event strong {
            color: #e76f51;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="navbar">
    <img src="assets/mit_image.jpg" class="logo" alt="MIT Logo">
    <a href="index.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="profile.php">Profile</a>
    <a href="register_event.php">Register</a>
    <a href="payment.php">Payment</a>
    <a href="events.php">Events</a>
    <?php if (isset($_SESSION['user'])): ?>
        <a href="logout.php" class="signin-btn">Logout</a>
    <?php else: ?>
        <a href="login.php" class="signin-btn">Log In</a>
    <?php endif; ?>
</div>

<div class="event-container">
    <?php
    $events = [
        "Bandish Bandits" => [
            "description" => "\"Bandish Bandits\" is a battle of the bands event with genres like rock, pop, metal, and indie. Bands perform original or cover tracks judged on musicality, stage presence, and crowd engagement.",
            "structure" => "Prelims and Finals. Judged by professional musicians.",
            "schedule" => "Between April 4 – April 6, 2025"
        ],
        "Mr. and Ms. Revels" => [
            "description" => "A personality and talent hunt testing charisma, confidence, wit, talent, and stage presence. Multiple creative and Q&A rounds.",
            "structure" => "Introduction, Talent, Q&A, Challenge rounds.",
            "schedule" => "April 5 (semi-finals) & April 6, 2025 (finale)"
        ],
        "Street Dance Battle" => [
            "description" => "A head-to-head freestyle street dance competition with cyphers, 1v1, and team battles. Judged on originality, rhythm, and energy.",
            "structure" => "Cyphers, 1v1, optional crew battles, Final Battle.",
            "schedule" => "April 4–6, 2025"
        ],
        "Lehza" => [
            "description" => "Revels’ literary flagship with rounds in writing, speaking, debate, and storytelling. Focused on language flair and originality.",
            "structure" => "Writing, extempore, debate, storytelling.",
            "schedule" => "April 4–6, 2025"
        ],
        "General Quiz" => [
            "description" => "Knowledge battle across science, tech, pop culture, trivia, etc. With prelims and intense buzzer finals.",
            "structure" => "Prelims + Finals with direct, audio, visual, and rapid fire rounds.",
            "schedule" => "April 4 or 5, 2025"
        ],
        "Charades" => [
            "description" => "Classic silent acting game with fun themes like movies, books, and quotes. Pure hilarity and team bonding!",
            "structure" => "Standard, Reverse Charades, Silent Relay rounds.",
            "schedule" => "April 4 or 5, 2025"
        ],
        "Trail and Tail" => [
            "description" => "Outdoor treasure hunt with mental, physical challenges and navigation tasks spread across campus.",
            "structure" => "Puzzle checkpoints + final destination race.",
            "schedule" => "April 4–5, 2025"
        ],
        "Manipal’s Got Talent" => [
            "description" => "Talent show featuring singing, acting, comedy, and unique skills. Open stage for all art forms.",
            "structure" => "Audition rounds and Grand Showcase.",
            "schedule" => "April 4–5, 2025"
        ],
        "Nukkad Natak" => [
            "description" => "Street theatre on social issues with impactful, emotional, and often satirical performances.",
            "structure" => "Team acts with original or inspired scripts.",
            "schedule" => "April 4 or 5, 2025"
        ],
        "Mad Ads" => [
            "description" => "Teams make quirky mock ads with humor, drama, and marketing flair. Quick, creative, and chaotic!",
            "structure" => "Ad presentation + surprise twist round.",
            "schedule" => "April 5, 2025"
        ]
    ];

    foreach ($events as $name => $info) {
        echo "<div class='event'>
                <h2>$name</h2>
                <p><strong>Description:</strong> {$info['description']}</p>
                <p><strong>Structure:</strong> {$info['structure']}</p>
                <p><strong>Scheduled Date:</strong> {$info['schedule']}</p>
              </div>";
    }
    ?>
</div>

</body>
</html>
