<?php


if (isset($_POST['doctorEmail'], $_POST['subjecttext'], $_POST['Emailtext'])) {
    $doctorEmail = $_POST['doctorEmail'];
    $subject = $_POST['subjecttext'];
    $emailText = $_POST['Emailtext'];


    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'selftriage22@gmail.com';
    $mail->Password = 'icrziehnektjrejl';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('selftriage22@gmail.com', 'ED Admin');
    $mail->addAddress($doctorEmail);
    $mail->Subject = $subject;
    $mail->Body = $emailText;

    if ($mail->send()) {
        echo '<div class="container">
        <div class="alert alert-success d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
        <div>
    Email sent </div>
      </div>
      </div>';
         } else {
        echo '<div class="container">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
      <div>
      Failed to send email  </div>
    </div>
      </div></div>' . $mail->ErrorInfo;
    }
}
?>
