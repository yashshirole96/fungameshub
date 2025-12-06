<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "Error: User not logged in.";
    exit();
}

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "gamehub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_SESSION['username'];
$score = isset($_POST['score']) ? intval($_POST['score']) : 0;

if ($score > 0) {
    // **Increase Total Score Instead of Overwriting**
    $sql = "UPDATE users SET total_score = total_score + ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $score, $user);

    if ($stmt->execute()) {
        echo "Score updated successfully";
    } else {
        echo "Error updating score: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
