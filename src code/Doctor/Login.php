<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
session_start();

if (isset($_SESSION['ID'])) {
    header("Location: logout.php");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ID = $_POST['ID'];
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

    $query = $conn->prepare("SELECT ID, password, NAME, Email, clinicNumber FROM doctor WHERE ID = ?");
    $query->bind_param('s', $ID);
    $query->execute();
    $query->bind_result($db_ID, $db_password, $db_name, $db_Email, $db_clinicNumber);
    $query->fetch();
    $query->close();

    if ($db_ID && $hash === $db_password) {
        $otp = mt_rand(1000, 9999);

        $_SESSION['otp'] = $otp;
        $_SESSION['ID'] = $db_ID;
        $_SESSION['name'] = $db_name;
        $_SESSION['clinicNumber'] = $db_clinicNumber;
        
        
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'selftriage22@gmail.com';
        $mail->Password = 'icrziehnektjrejl';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('selftriage22@gmail.com', 'Doctor View'); 
        $mail->addAddress($db_Email, $db_name);

        $mail->Subject = 'Your OTP for Login';
        $mail->Body = 'Hello ' . $db_name . ', This is your OTP : '. $otp .'';

        if ($mail->send()) {
            $doctor_state="Active";
        $query =$conn->prepare( "UPDATE doctor SET Activity_state =? WHERE ID =?");
        $query->bind_param('si', $doctor_state,$db_ID);
        $query->execute();

            header("Location: verify_otp.php");
            exit;
        } else {
            $error = "Failed to send OTP. Please try again.";
        }
    } else {
        $error = "Invalid ID or password.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error)) { echo "<p>$error</p>"; } ?>
        <form method="POST" action="login.php">
            <label for="ID">ID:</label><br>
            <input type="text" placeholder="ID" name="ID" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" placeholder="Password" name="password" required><br><br>
            
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
