<?php
$servername = "127.0.0.1";
$username = "root123";
$password = "root1234";
$dbname = "sleftriage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);

$severityLevels = [
    'Low', 'Medium', 'High'
];

if (in_array($data['Severity_level'], $severityLevels)) {
    $triageSql = "CALL InsertTriage(?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($triageSql)) {
        date_default_timezone_set('Asia/Riyadh'); 
        $currentTimestamp = date('Y-m-d H:i:s');
        $stmt->bind_param("ssdddddis", $data['Severity_level'], $data['symptoms'], $data['sys'], $data['dia'], $data['pulse'], $data['temp'], $data['spO2'], $data['patient_ID'], $currentTimestamp);

        if ($stmt->execute()) {
            $response = ['status' => 'success'];
        } else {
            $response = ['status' => 'error', 'message' => $conn->error];
        }
        $stmt->close();
    } else {
        $response = ['status' => 'error', 'message' => $conn->error];
    }
} else {
    $response = ['status' => 'unknown'];
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>
