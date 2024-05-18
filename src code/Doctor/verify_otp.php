<?php
session_start();

if (!isset($_SESSION['ID']) || !isset($_SESSION['otp'])) {
    header("Location: login.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEnteredOTP = $_POST['otp'];
    $_SESSION['verify_otp'] = $userEnteredOTP;

    if ($userEnteredOTP == $_SESSION['otp']) {
       
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Verify OTP</h2>
        <?php if (!empty($error)) { echo "<p>$error</p>"; } ?>
        <form method="POST" action="verify_otp.php">
            <label for="otp">Enter OTP:</label><br>
            <input type="text" placeholder="OTP" name="otp" required><br><br>
            
            <input type="submit" value="Verify">
        </form>
    </div>
</body>
</html>
