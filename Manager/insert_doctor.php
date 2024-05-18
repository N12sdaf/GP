<?php




if (isset($_POST['doctorid'], $_POST['doctorname'], $_POST['doctorpassword'], $_POST['doctoremail'], $_POST['doctorAreanumber'])) {
  $adminpassword=hash('sha512',$_POST['admin-pass-insert-doctor']);
  if($adminpassword == $_SESSION['Admin_password']){
    $doctorid = $_POST['doctorid'];
    $doctorname = $_POST['doctorname'];
    $doctorpassword = $_POST['doctorpassword'];
    $doctoremail = $_POST['doctoremail'];
    $doctorAreanumber = $_POST['doctorAreanumber'];

    $query = $conn->prepare("CALL `InsertDoctor`(?,?,?,?,?);");
    $query->bind_param('ssssi', $doctorid, $doctorname, $doctorpassword, $doctoremail, $doctorAreanumber);

    if ($query->execute()) {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'selftriage22@gmail.com';
        $mail->Password = 'icrziehnektjrejl';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('selftriage22@gmail.com', 'Admin');
        $mail->addAddress($doctoremail, $doctorname);
        $mail->Subject = 'Welcome to our ED';
        $mail->Body = 'Dear ' . $doctorname . ', Welcome to our ED!. Your ID: ' . $doctorid . ' with password: ' . $doctorpassword;

        if ($mail->send()) {
            echo '<div class="container">
            <div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
        Doctor inserted</div>
          </div>
          </div>';
        } else {
            echo '
            <div class="container">
    <div class="alert alert-danger d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  <div>
  Email could not be sent. Mailer Error:'. $mail->ErrorInfo.' </div>
</div>
  </div></div>'; 
        }
    } else {
        echo '<div class="container">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
      <div>
      Failed to insert doctor  </div>
    </div>
      </div></div>';
    }
    
    $query->close();
  }else{
    echo '<div class="container">
    <div class="alert alert-danger d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  <div>
  incorrect admin password  </div>
</div>
  </div></div>';
} 
}
?>
