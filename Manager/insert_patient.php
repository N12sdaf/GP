<?php
if (isset($_POST['patientid'], $_POST['patientname'], $_POST['patientemail'],  $_POST['patientbirth'],$_POST['patientsex'])) {
    $patientid = $_POST['patientid'];
    $patientname = $_POST['patientname'];
    $patientbirth = $_POST['patientbirth'];
    $patientemail = $_POST['patientemail'];
    $patientsex = $_POST['patientsex'];

    $query = $conn->prepare("INSERT INTO patient (`ID`, `NAME`, `EMAIL`, `date_birth`, `sex`) VALUES (?,?,?,?,?)");
    $query->bind_param('issss', $patientid, $patientname, $patientemail, $patientbirth, $patientsex);
    $query->execute();
if($conn->error){
    echo '<div class="container">
    <div class="alert alert-danger d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  <div>
  Failed to insert patient  </div>
</div>
  </div></div>';
}else{
    echo '<div class="container">
    <div class="alert alert-success d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <div>
Patient inserted</div>
  </div>
  </div>';
}
    $query->close();

}
?>