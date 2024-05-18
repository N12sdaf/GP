<?php
$servername = "127.0.0.1";
$username = "root123";
$password = "root1234";
$dbname = "sleftriage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = isset($_GET["userId"]) ? $_GET["userId"] : "";


$sql = "SELECT name FROM patient WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
    echo $name;
} else {
    echo "User Not Found";
}

$stmt->close();
?>
