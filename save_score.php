<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "gamehub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_SESSION['username'] ?? 'player1'; // Default player
$score = isset($_POST['score']) ? intval($_POST['score']) : 0;

$sql = "UPDATE users SET total_score = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $score, $user);

if ($stmt->execute()) {
    echo "Score updated successfully";
} else {
    echo "Error updating score: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
