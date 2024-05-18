<?php

include 'phpmailer.php';

session_start();

if (isset($_SESSION['Admin_ID'])) {
    header("Location: logout.php");
    exit;
}

$error = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ID_Ofadmin = $_POST['ID'];
    $password = $_POST['password'];
    $hash = hash('sha512', $password); 

    $servername = "127.0.0.1";
    $username = "root123";
    $dbPassword = "root1234";
    $dbname = "sleftriage";

    $conn = new mysqli($servername, $username, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = $conn->prepare(
    "SELECT Admin_ID, Password, Admin_Name , Email 
    FROM Admin 
    WHERE Admin_ID = ?");
    $query->bind_param('s', $ID_Ofadmin);
    $query->execute();
    $query->bind_result($db_ID, $db_password, $db_name, $db_Email);
    $query->fetch();

    if ($db_ID && $hash === $db_password) { 
        $otp = mt_rand(1000, 9999);
        
        $_SESSION['Admin_ID'] = $db_ID;
        $_SESSION['Admin_Name'] = $db_name;
        $_SESSION['otp'] = $otp;
        $_SESSION['Admin_password'] = $db_password;


        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'selftriage22@gmail.com';
        $mail->Password = 'icrziehnektjrejl';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('selftriage22@gmail.com', 'Admin View'); 
        $mail->addAddress($db_Email, $db_name);

        $mail->Subject = 'Your OTP for Login';
        $mail->Body = 'Hello ' . $db_name . ', This is your OTP : '. $otp .'';

        if ($mail->send()) {
            header("Location: verify_otp.php");
            exit;
        } else {
            $error = '<div class="container">
            <div class="alert alert-danger d-flex align-items-center" role="alert">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
          <div>
          Failed to send OTP, Please try again</div>
        </div>
          </div></div>';
        }
    } else {
        $error = '<div class="container">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
      <div>
      Invalid ID or password </div>
    </div>
      </div></div>';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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


<div class="login-container">
    <h2>Login</h2>
    <form method="POST" action="admin_login.php">
        <label for="ID">ID:</label><br>
        <input type="text" placeholder="ID" name="ID" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" placeholder="Password" name="password" required><br><br>

        <input type="submit" value="Login">
        <?php if (!empty($error)) { echo "$error"; } ?>

    </form>
</div>
</body>
</html>
