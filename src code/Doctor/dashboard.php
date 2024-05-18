<?php
session_start();
if (!isset($_SESSION['ID']) || (!isset($_SESSION['otp']) != !isset($_SESSION['verify_otp']))) {
    header("Location: logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<link rel="stylesheet" href="./bootstrab/bootstrap.min.css">

<link rel="stylesheet" href="style.css">

<body>
<div class="dashboard-container">
<h2 style="color: blue">Welcome to Your Dashboard</h2>
    <p>Hello Dr.<?php echo $_SESSION['name']; ?> <br> with ID: <?php echo $_SESSION['ID']; ?> <br> Area : <?php  
    if($_SESSION['clinicNumber']==1){
        echo "Low";  
    }elseif($_SESSION['clinicNumber']==2){
        echo "Medium";  

    }else{
        echo "High";  

    }
  

?></p>
    <form action="Cases.php" method="post">
    <button class="btn btn-primary btn-lg" type="submit" style="width:90%">See The Cases</button>
    </form><br>
    <button class="btn btn-primary btn-lg" id="P_info_butt" style="width:90%" onclick="toRequest()">request patient information</button>
<br><br>
    <form action="logout.php" method="post">
    <button class="btn btn-secondary  btn-lg" type="submit" style="width:90%">Logout</button> 
</form>
</div>
<script>

function toRequest(){
    window.location.href = "patient_history.php";

}
</script>
</body>
</html>
