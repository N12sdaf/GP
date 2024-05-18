<?php
session_start();
if (!isset($_SESSION['ID']) || (!isset($_SESSION['otp']) != !isset($_SESSION['verify_otp']))) {
    header("Location: login.php");
    exit;
}

$DoctorID = $_SESSION['ID'];

$servername = "127.0.0.1";
$username = "root123";
$password = "root1234";
$dbname = "sleftriage";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $conn->prepare("SELECT clinicNumber FROM doctor WHERE ID = ?");
$query->bind_param('s', $DoctorID);
$query->execute();
$query->bind_result($db_clinicNumber);
$query->fetch();

if ($db_clinicNumber == '1') {
    $queue = "L";
} elseif ($db_clinicNumber == '2') {
    $queue = "M";
} else {
    $queue = "H";
}
$date=date("Y-m-d");
$sql = "SELECT triage.*, patient.name, patient.ID, patient.date_birth,
        TIMESTAMPDIFF(YEAR, patient.date_birth, CURDATE()) AS age
        FROM triage
        JOIN patient ON triage.patient_ID = patient.ID
        WHERE triage.CLEARorNOT = ? AND triage.queue LIKE '{$queue}%' and Triage_timestamp LIKE '{$date}%'";
$clearStatus = "UNCLEAR"; 



$query->close();

$query = $conn->prepare($sql);
$query->bind_param('s', $clearStatus);
$query->execute();
$result = $query->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['waiting_number']) && isset($_POST['report'])) {
        $waitingNumber = $_POST['waiting_number'];
        $report = $_POST['report'];

        $insertSql = "UPDATE triage SET doctor_id = ? ,report = ?, CLEARorNOT = 'CLEAR' WHERE queue = ?";
        $insertQuery = $conn->prepare($insertSql);
        $insertQuery->bind_param('iss', $DoctorID, $report, $waitingNumber);

        if ($insertQuery->execute()) {
            echo "<script>redirectURL = `http://localhost/Self-triage/Doctor/Cases.php`;
            window.location.href = redirectURL;

            </script>";

        } else {
            echo "Error inserting report: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cases</title>
</head>
<link rel="stylesheet" href="./bootstrab/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
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
<button class = 'btn btn-primary btn-lg' style=' position: fixed; top: 10px; left: 60px;' onclick = 'toDash()'>Back to Dashboard</button>

<div class="cases-container">
    <table style="width:100%" class="tb">
    <?php
        if (isset($result)&& $result->num_rows > 0) {

            echo '<h2>Cases</h2>
        <tr>
            <th>Waiting Number</th>
            <th>ID</th>
            <th>Name</th>
            <th>age</th>
            <th>symptoms</th>
            <th>sys</th>
            <th>dia</th>
            <th>pulse</th>
            <th>temp</th>
            <th>SpO2</th>
            <th>triage timestamp</th>
            <th>status</th>
        </tr>';
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["queue"] . "</td>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["age"] . "</td>";
                echo "<td>" . $row["symptoms"] . "</td>";
                echo "<td>" . $row["sys"] . "</td>";
                echo "<td>" . $row["dia"] . "</td>";
                echo "<td>" . $row["pulse"] . "</td>";
                echo "<td>" . $row["temp"] . "</td>";
                echo "<td>" . $row["spO2"] . "</td>";
                echo "<td>" . $row["Triage_timestamp"] . "</td>";
                echo "<td>" . $row["CLEARorNOT"] . "</td>";
                echo "</tr>";
            }
            }else{
            echo '<div class="alert alert-primary d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
            <div>
No cases in the Area currently            </div>
          </div>';
        }
        ?>
    </table>
</div>
<div class="cases-container">
    <div>
    <img class="gif" src="gif/folder.gif" alt="Animated GIF">
        <form method="POST">
            <label class="TEXT" ID="report">Enter the Queue Number of the patient: </label>
            <input id="waitingNum" class="input" type="text" name="waiting_number" placeholder="Enter the Waiting Number of patient here" required><br>
            <textarea name="report" placeholder="Write the report for the patient" rows="4" cols="50" required></textarea><br>
            <button class="btn btn-primary btn-lg" type="submit">Submit</button>
        </form>
    </div>
</div>
<script>

function toDash() {
    window.location.href = 'dashboard.php';
}


</script>
</body>
</html>
