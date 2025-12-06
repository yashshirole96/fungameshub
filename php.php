<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gamehub";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
} else {
    echo "Database Connection Successful!";
}

$conn->close();
?>
