<?php
session_start();
if (!isset($_SESSION['Admin_ID']) || (!isset($_SESSION['otp']) != !isset($_SESSION['verify_otp']))) {
    header("Location: logout.php");
    exit;
}
?>