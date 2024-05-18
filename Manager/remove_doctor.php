<?php

if (isset($_POST['remove-doctorid'] , $_POST['admin-pass-remove-doctor'])) {
  $adminpassword=hash('sha512',$_POST['admin-pass-remove-doctor']);
  if($adminpassword == $_SESSION['Admin_password']){
    $query = $conn->prepare("DELETE FROM doctor WHERE ID=?");
    $query->bind_param('i', $_POST['remove-doctorid']);
    $query->execute();

    if($conn->error){
    echo '<div class="container">
    <div class="alert alert-danger d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  <div>
  Failed to remove doctor  </div>
</div>
  </div></div>';
} else {
    echo '<div class="container">
    <div class="alert alert-success d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <div>
Doctor removed</div>
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