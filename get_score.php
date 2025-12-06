<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "gamehub";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_GET['username'];
$sql = "SELECT total_score FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["total_score" => intval($row['total_score'])]);
} else {
    echo json_encode(["total_score" => 0]);
}

$conn->close();
?>
