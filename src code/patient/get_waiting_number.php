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

if ($userId !== "") {
    $sql = "SELECT queue FROM triage WHERE patient_ID = ? ORDER BY triage_timestamp DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->bind_result($queue);
    $stmt->fetch();

    if ($queue !== null) {
        echo "$queue";
    } else {
        echo "User Not Found";
    }
} else {
    echo "Invalid User ID";
}

$stmt->close();
$conn->close();
?>
