<?php
include 'access_validation.php';

?>
<?php
include 'phpmailer.php';
include 'DBconn.php';
include 'ED_info.php';
include 'insert_doctor.php';
include 'control_size.php';
include 'insert_patient.php';
include 'call_doctor.php';
include 'remove_doctor.php';
include 'change-doc-area.php';





$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <link rel="stylesheet" href="./bootstrab/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

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


    <h1 class="title_div">Dashboard</h1>
   <div class=severity_container>
<div class="container">

   <div class="severity_div" id="low"> Low cases<br><?php echo $numberOflow;?>  </div>   
   <div class="severity_div" id="med">medium cases<br><?php echo $numberOfmed;?>   </div>   
   <div class="severity_div" id="high">High cases<br><?php echo $numberOfhigh;?>  </div> <br>
   <div class="severity_div" id="total_patient">Total cases<br><?php echo $numberOflow+$numberOfmed+$numberOfhigh;?>  </div>
<div class="severity_div"> unclear cases<br><?php echo $numberOfunclear;?></div>
<div class="severity_div"> clear cases<br><?php echo $numberOfclear;?></div><br>
<div class="severity_div"> Low Area Fullness <br><?php echo ceil(($percentagOflow/$lowsize)*100).'%'; ?> <button class="btn btn-primary" id="addl">Control</button>
</div>
<div class="severity_div"> Medium Area Fullness<br><?php echo ceil(($percentageOfmed/$medsize)*100).'%';?> <button class="btn btn-primary" id="addm">Control</button>
</div>
<div class="severity_div"> High Area Fullness<br><?php 
echo ceil(($percentageOfHigh/$highsize)*100).'%';?> <button class="btn btn-primary" id="addh">Control</button>
</div>
<br>
<div class="severity_div" id="AcDoc"> Active Doctors in Low Area <br><?php echo $low_Active;?>  </div>   
<div class="severity_div" id="AcDoc"> Active Doctors in Medium Area  <br><?php echo $med_Active;?>  </div>   
<div class="severity_div" id="AcDoc"> Active Doctors in High Area  <br><?php echo $high_Active;?>  </div>   

</div>


<form action="dashboard.php"  method="POST" class="insertdoc" id="lowform">
<label for="id" class="form-label">New Area size:</label><br>
    <input type="text" name="New_low_size" id="lowsize" value="<?php echo $lowsize; ?>">
    <input type="submit" class="button-18" value="Change">
    <button id="close_low" type="button"> <img src="x-butt.png" alt="close"></button>

</form>
<form action="dashboard.php"  method="POST" class="insertdoc" id="medform">
<label for="medsize" class="form-label">New Area size:</label><br>
    <input type="text" name="New_med_size" id="medsize" value="<?php echo $medsize; ?>">
    <input type="submit" class="button-18" value="Change">
    <button id="close_med" type="button"> <img src="x-butt.png" alt="close"></button>

</form>
<form action="dashboard.php"  method="POST" class="insertdoc" id="highform">
<label for="highsize" class="form-label">New Area size:</label><br>
    <input type="text" name="New_high_size" id="highsize" value="<?php echo $highsize; ?>">
    <input type="submit" class="button-18" value="Change">
    <button id="close_high" type="button"> <img src="x-butt.png" alt="close"></button>

</form>





<button class="btn btn-primary btn-lg"  style="width:25%;margin:2px" id="open_doctor_insert">Insert a doctor</button>
<form action="" method="POST" id="inertdocform" class="insertdoc" style="width:30%">
    <h2>Inserting new doctor</h2>
<label for="id" class="form-label">ID:</label>
      <input type="text" class="form-control" name="doctorid" required>
      <label for="name" class="form-label">Name:</label>
      <input type="text" class="form-control" name="doctorname" required>
      <label for="email" class="form-label">Email:</label>
      <input type="email" class="form-control" name="doctoremail" required>
      <input type="password" id="password" name="doctorpassword" class="form-control" placeholder="Generated Password" readonly>
      <button class="btn btn-primary btn-lg" type="button" onclick="generatePassword()">Generate Password</button><br>
      <label for="clinicNumber" class="form-label">Area Number:</label>
      <select class="form-select" id="validationDefault04" name="doctorAreanumber" required>
      <option selected disabled value="Choose...">Choose...</option>
      <option value="1">Low</option>
      <option value="2">Medium</option>
      <option value="3">High</option>

    </select>
            <label for="password" class="form-label">Admin password:</label>
            <input type="password" class="form-control" name="admin-pass-insert-doctor" required>
<button class="btn btn-primary" type="submit" class="insertdoctor">Insert</button>

      <button style="color:white" type="button" id="close_doctor_insert"> 
        <img src="x-butt.png" alt="close">
    </button>

</form>


<button class="btn btn-primary btn-lg"  style="width:25%;margin:2px" id="open_doctor_remove">remove a doctor</button>
<form action="" method="POST" id="removedocform" class="insertdoc">
    <h2>Remove doctor</h2>
<label for="id" class="form-label">ID:</label><br>
      <input type="text" class="form-control" name="remove-doctorid" required><br>
      <label for="password" class="form-label">Admin password:</label><br>
      <input type="password" class="form-control" name="admin-pass-remove-doctor" required><br>
      <button class="btn btn-primary" type="submit" class="insertdoctor">Remove</button>

      <button style="color:white" type="button" id="close_doctor_remove"> 
        <img src="x-butt.png" alt="close">
    </button>

</form>

<button class="btn btn-primary btn-lg"  style="width:25%;margin:2px" id="open_doctor_change">Change a doctor Area</button>
<form action="" method="POST" id="ChangeDocAreaForm" class="insertdoc">
    <h2>Change doctor Area</h2>
<label for="id" class="form-label">ID:</label><br>
      <input type="text" class="form-control" name="change-doctorid" required><br>
      <label for="id" class="form-label">New Area:</label><br>
      <select class="form-select" id="validationDefault04" name="NewArea" required>
      <option selected disabled value="Choose...">Choose...</option>
      <option value="1">Low</option>
      <option value="2">Medium</option>
      <option value="3">High</option>

    </select>      <label for="password" class="form-label">Admin password:</label><br>
      <input type="password" class="form-control" name="admin-pass-change-doctor" required><br>
      <button class="btn btn-primary" type="submit" class="insertdoctor">Change</button>

      <button style="color:white" type="button" id="close_doctor_change"> 
        <img src="x-butt.png" alt="close">
    </button>

</form>




<button class="btn btn-primary btn-lg"  style="width:25%;margin:2px" id="open_patient_insert">Insert a patient</button>
<form action="" method="POST" id="inertpatientform" class="insertdoc">
    <h2>Insert new patient</h2>
<label for="id" class="form-label">ID:</label><br>
      <input type="text" class="form-control" name="patientid" required>
      <label for="name" class="form-label">Name:</label>
      <input type="text" class="form-control" name="patientname" required>
      <label for="email" class="form-label">Email:</label>
      <input type="email" class="form-control" name="patientemail" required>
      <label for="clinicNumber" class="form-label">Gender:</label>
      <select class="form-select" id="validationDefault04" name="patientsex" required>
      <option selected disabled value="Choose...">Choose...</option>
      <option value="female">Female</option>
      <option value="male">Male</option>

    </select>
      <label for="clinicNumber" class="form-label">Date of birth:</label>
      <input type="date" class="form-control" name="patientbirth" required>
      <button class="btn btn-primary" type="submit" class="insertpatient">Insert</button>

      <button style="color:white" type="button" id="close_patient_insert">
    <img src="x-butt.png" alt="close">
</button>

</form>






<button class="btn btn-primary btn-lg"  style="width:25%;margin:2px" id="open_email_sender">call a doctor</button>



   
    <form action="" method="POST" id="Email_form" class="insertdoc">
<label for="docEmail" class="form-label">Email address</label>
<input type="email" class="form-control" id="docEmail" name="doctorEmail">
<label for="SubEmail" class="form-label">Subject</label>
<input type="text" class="form-control" id="SubEmail" name="subjecttext">
<label for="BodyEmail" class="form-label">Body</label>
<input type="textarea" class="form-control" id="BodyEmail" name="Emailtext">
<button class="button-18" id="email_send" type="submit">Send</button>
<button type="button" id="close_email_sender">  <img src="x-butt.png" alt="close"></button>

    </form>






<button class="btn btn-primary btn-lg"  style="width:25%;margin:2px" id="P_info_butt" onclick="toRequest()">request patient information</button>
<br><br>
<form action="logout.php" method="post">
    <button class="btn btn-secondary  btn-lg" style="width:76%" type="submit">Logout</button> 
</form>

</div>

<script src="./bootstrab/bootstrap.bundle.min.js"></script>
<script src="dashboard.js"></script>
</body>
</html>