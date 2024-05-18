<?php

$servername = '127.0.0.1';
$username = 'root123';
$password = 'root1234';
$dbname = 'sleftriage';

$conn = new mysqli( $servername, $username, $password, $dbname );

if ( $conn->connect_error ) {
    die( 'Connection failed: ' . $conn->connect_error );
}

$data = json_decode( file_get_contents( 'php://input' ), true );

$sql = 'INSERT INTO triage (Severity_level, symptoms, sys, dia, pulse, temp, spO2, patient_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

if ( $stmt = $conn->prepare( $sql ) ) {
    $stmt->bind_param( 'ssdddddi', $data[ 'Severity_level' ], $data[ 'symptoms' ], $data[ 'sys' ], $data[ 'dia' ], $data[ 'pulse' ], $data[ 'temp' ], $data[ 'spO2' ], $data[ 'patient_ID' ] );
    $stmt->execute();
    $stmt->close();
}

$conn->close();
$response = [ 'status' => 'Data inserted successfully' ];
echo json_encode( $response );
?>
