<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "gamehub";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['username'] = $user;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password'); window.location.href='signup.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password'); window.location.href='signup.php';</script>";
    }
    
    $stmt->close();
}

// Handle signup
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password, total_score) VALUES (?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $hashed_pass);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href='signup.php';</script>";
    } else {
        echo "<script>alert('Error: Username might already exist.'); window.location.href='signup.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <div id="container" class="container">
        <div class="row">
            <div class="col align-items-center flex-col sign-up">
                <div class="form-wrapper align-items-center">
                    <div class="form sign-up">
                        <form action="" method="POST">
                            <div class="input-group">
                                <i class='bx bxs-user'></i>
                                <input type="text" name="username" placeholder="Username" required>
                            </div>
                            <div class="input-group">
                                <i class='bx bxs-lock-alt'></i>
                                <input type="password" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" name="signup">Sign up</button>
                        </form>
                        <p>
                            <span>Already have an account?</span>
                            <b onclick="toggle()" class="pointer">Sign in here</b>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col align-items-center flex-col sign-in">
                <div class="form-wrapper align-items-center">
                    <div class="form sign-in">
                        <form action="" method="POST">
                            <div class="input-group">
                                <i class='bx bxs-user'></i>
                                <input type="text" name="username" placeholder="Username" required>
                            </div>
                            <div class="input-group">
                                <i class='bx bxs-lock-alt'></i>
                                <input type="password" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" name="login">Sign in</button>
                        </form>
                        <p>
                            <b>Forgot password?</b>
                        </p>
                        <p>
                            <span>Don't have an account?</span>
                            <b onclick="toggle()" class="pointer">Sign up here</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row content-row">
            <div class="col align-items-center flex-col">
                <div class="text sign-in">
                    <h2>Welcome</h2>
                </div>
                <div class="img sign-in"></div>
            </div>

            <div class="col align-items-center flex-col">
                <div class="img sign-up"></div>
                <div class="text sign-up">
                    <h2>Join with us</h2>
                </div>
            </div>
        </div>
    </div>

    <script>
    let container = document.getElementById('container');
    function toggle() {
        container.classList.toggle('sign-in');
        container.classList.toggle('sign-up');
    }
    setTimeout(() => {
        container.classList.add('sign-in');
    }, 200);
    </script>
</body>
</html>
