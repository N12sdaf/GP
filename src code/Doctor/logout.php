<?php
session_start();
$servername = "127.0.0.1";
$username = "root123";
$dbPassword = "root1234";
$dbname = "sleftriage";

$conn = new mysqli($servername, $username, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$doctor_state="inactive";
$query =$conn->prepare( "UPDATE doctor SET Activity_state =? WHERE ID =?");
$query->bind_param('si', $doctor_state,$_SESSION['ID']);
$query->execute();
$conn->close();

$_SESSION = array();
session_destroy();
header("Location: login.php");
exit;
?>
