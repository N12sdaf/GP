<?php
session_start();

if (!isset($_SESSION['ID']) || (!isset($_SESSION['otp']) != !isset($_SESSION['verify_otp']))) {
    header( 'Location: Login.php' );
    exit;
}

$error = '';

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
    $patientID = $_POST[ 'patientID' ];

    $servername = '127.0.0.1';
    $username = 'root123';
    $dbPassword = 'root1234';
    $dbname = 'sleftriage';

    $conn = new mysqli( $servername, $username, $dbPassword, $dbname );

    if ( $conn->connect_error ) {
        die( 'Connection failed: ' . $conn->connect_error );
    }

    $query = $conn->prepare( "SELECT *, TIMESTAMPDIFF(YEAR, patient.date_birth, CURDATE()) AS age 
    FROM triage
    right outer JOIN patient ON triage.patient_ID = patient.ID 
    WHERE patient.ID = ?" );
    $query->bind_param( 's', $patientID );
    $query->execute();
    $result = $query->get_result();

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang = 'en'>

<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title>Request Patient Information</title>
<link rel="stylesheet" href="./bootstrab/bootstrap.min.css">

<link rel = 'stylesheet' href = 'style.css'>
</head>

<body>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>
<form class = 'admin_fun' method = 'POST'>
<h1>Searching for a patient history</h1>
<input style="width:56%" class = 'patientID' type = 'text' name = 'patientID' placeholder = 'Ex: 1015408841'><br>
<button class = 'btn btn-primary btn-lg'>Confirm</button>
</form>

<div  class = 'cases-container'>
<div  class = 'patientINFO_container'>
<?php
if ( isset( $result ) && $result->num_rows > 0 ) {
    $row = $result->fetch_assoc();
    echo "<div>Patient Name :  $row[NAME]  </div>";
    echo "<div>Patient ID :  $row[ID]  </div>";
    echo "<div>Patient age :  $row[age]  </div>";
    echo "<div>Patient EMAIL :  $row[EMAIL]  </div>";
    echo "<div>Patient Gender :  $row[sex]  </div>";
}elseif(!isset( $result )){
    echo '<div class="alert alert-primary d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
    <div>
    Enter patient ID
</div>
  </div>';
}else{
    echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
    <div>
    No patient found    
    </div>
  </div>';
}
?>
</div>
</div>

<div class = 'cases-container'>

<table style="width:100%" class = 'tb'>
<?php
if ( isset( $result ) && $result->num_rows > 0 ) {
    echo '<h2>Triage history</h2>';
    echo '<tr>';
    echo '<th>Tirage ID</th>';
    echo '<th>Severity Level</th>';
    echo '<th>Symptoms</th>';
    echo '<th>Sys</th>';
    echo '<th>Dia</th>';
    echo '<th>Pulse</th>';
    echo '<th>Temp</th>';
    echo '<th>SpO2</th>';
    echo '<th>Triage Date</th>';
    echo '</tr>';

    foreach ( $result as $row ) {
        echo '<tr>';
        echo '<td>' . $row[ 'ID_triage' ] . '</td>';
        echo '<td>' . $row[ 'Severity_level' ] . '</td>';
        echo '<td>' . $row[ 'symptoms' ] . '</td>';
        echo '<td>' . $row[ 'sys' ] . '</td>';
        echo '<td>' . $row[ 'dia' ] . '</td>';
        echo '<td>' . $row[ 'pulse' ] . '</td>';
        echo '<td>' . $row[ 'temp' ] . '</td>';
        echo '<td>' . $row[ 'spO2' ] . '</td>';
        echo '<td>' . $row[ 'Triage_timestamp' ] . '</td>';

        echo '</tr>';
    }
} elseif(!isset( $result )) {
    echo '<div class="alert alert-primary d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
    <div>
    Enter patient ID
    </div>
  </div>';
}else{
    echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
    <div>
No patient found    </div>
  </div>';
}
?>
</table>
</div>

<button class = 'btn btn-primary btn-lg' style=' position: fixed; top: 10px; left: 60px;' onclick = 'toDash()'>Back to Dashboard</button>
<script>

function toDash() {
    window.location.href = 'dashboard.php';
}

function toRequest() {
    window.location.href = 'patient_history.php';
}
</script>
</body>

</html>
