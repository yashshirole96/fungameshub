<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: userlogin.html"); // Redirect if not logged in
    exit();
}

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "gamehub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$user = $_SESSION['username'];
$sql = "SELECT total_score FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$score = $row['total_score'] ?? 0;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Fun Games Hub</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Importing Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #7cdee5;
            color: #302E28;
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styling */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.2); /* Transparent white */
            backdrop-filter: blur(10px); /* Blur effect */
            padding: 20px 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .logo h1 {
            color: #089AAB;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: #089AAB;
            font-weight: 600;
            transition: 0.3s;
        }

        nav ul li a:hover {
            color: #e04d2e;
        }

        /* Dashboard Section */
        .dashboard-container {
            width: 80%;
            max-width: 800px;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin: 100px auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .dashboard-container h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .dashboard-container p {
            font-size: 1.2rem;
            line-height: 1.6;
            margin: 10px 0;
        }

        /* Score Display */
        .score-box {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ffcc00;
            margin: 20px 0;
        }

        /* Circles Background */
        .dashboard-container::after {
            content: '';
            width: 180px;
            height: 180px;
            background: #fbe260;
            border-radius: 50%;
            position: absolute;
            top: -50px;
            left: -50px;
            z-index: -1;
            animation: float 5s infinite ease-in-out;
        }

        .dashboard-container::before {
            content: '';
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2); /* Transparent white */
            backdrop-filter: blur(10px); /* Blur effect */
            border-radius: 50%;
            position: absolute;
            bottom: -40px;
            right: -40px;
            z-index: -1;
            opacity: 0.6;
            animation: float 6s infinite ease-in-out;
        }

        /* Game List */
        .game-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .game-card {
            background: rgba(255, 255, 255, 0.3);
            padding: 15px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
            transition: 0.3s;
        }

        .game-card h3 {
            color: #ff6f61;
            margin-bottom: 10px;
        }

        .game-card button {
            background: #ff6f61;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .game-card button:hover {
            background: #ff4a3d;
            transform: scale(1.05);
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.2); /* Transparent white */
            backdrop-filter: blur(10px); /* Blur effect */
            margin-top: auto;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Background Elements */
        .piggy {
            position: absolute;
            top: 500px;
            left: 30px;
            width: 100px;
            opacity: 0.7;
            animation: float 4s infinite ease-in-out;
            z-index: -1;
        }

        .star {
            position: absolute;
            top: 200px;
            right: 80px;
            width: 80px;
            opacity: 0.9;
            animation: rotate 6s infinite linear;
            z-index: -1;
        }

        .radio {
            position: absolute;
            right: 50px;
            top: 550px;
            transform: translateY(-50%);
            width: 100px;
            opacity: 0.8;
            animation: float 6s infinite ease-in-out;
            z-index: -1;
        }

        /* Animations */
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo">
            <h1>Fun Games Hub</h1>
            <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="signup.html">User Login</a></li>
                <li><a href="rules.html">Rules</a></li>
            </ul>
        </nav>
        </div>
    </header>

    <!-- Dashboard -->
    <section class="dashboard-container">
        <h2>Welcome, <?php echo htmlspecialchars($user); ?>!</h2>
        <p>Your current score:</p>
        <div class="score-box"><?php echo $score; ?></div>

        <h2>Available Games</h2>
        <div class="game-list"><div class="game-card"><h3>Catch the Falling Object</h3><a href="fall.html"><button>Play</button></a></div>
            <div class="game-card"><h3>Dice Gambling</h3><a href="gambling.html"><button>Play</button></a></div>
            <div class="game-card"><h3>Snake Game</h3><a href="snake.html"><button>Play</button></a></div>
            <div class="game-card"><h3>Fruit Catcher</h3><a href="fruit.html"><button>Play</button></a></div>
            <div class="game-card"><h3>Car dodge</h3><a href="car.html"><button>Play</button></a></div>
        </div>
    </section>

    <img src="images/piggy.png" alt="Piggy" class="piggy">
    <img src="images/star.png" alt="Rotating Star" class="star">
    <img src="images/radio.png" alt="Radio" class="radio">


    <footer>
        <p>&copy; 2025 Fun Games Hub. All rights reserved.</p>
    </footer>

</body>
</html>


fix header