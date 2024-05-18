<?php

if (isset($_POST['change-doctorid'],$_POST['NewArea'])) {
  $adminpassword=hash('sha512',$_POST['admin-pass-change-doctor']);
  if($adminpassword == $_SESSION['Admin_password']){
    $query = $conn->prepare("UPDATE doctor SET clinicNumber=? WHERE ID=?");
    $query->bind_param('ii',$_POST['NewArea'],$_POST['change-doctorid']);
    $query->execute();

    if($conn->error){
    echo '<div class="container">
    <div class="alert alert-danger d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  <div>
  Failed to change area  </div>
</div>
  </div></div>';
} else {
    echo '<div class="container">
    <div class="alert alert-success d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <div>
Area changed</div>
  </div>
  </div>';
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