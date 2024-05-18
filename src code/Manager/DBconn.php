<?php
$servername = "127.0.0.1";
$username = "root123";
$password = "root1234";
$dbname = "sleftriage";
$casestate="unclear";
$conn = new mysqli($servername, $username, $password, $dbname);
$date=date("Y-m-d");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>