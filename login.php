<?php
session_start();
$servername = "sql302.infinityfree.com";
$username = "if0_38381261"; // XAMPP default
$password = "h5On2c3OO5"; // No password for root in XAMPP
$dbname = "if0_38381261_gamehub";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Validate input (prevent SQL injection)
    $sql = "SELECT password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Check if password matches (Assuming passwords are hashed using password_hash())
        if (password_verify($pass, $hashed_password)) {
            $_SESSION['username'] = $user;
            header("Location: dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            echo "<script>alert('Invalid username or password'); window.location.href='userlogin.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password'); window.location.href='userlogin.html';</script>";
    }
    
    $stmt->close();
}
$conn->close();
?>
