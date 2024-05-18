<?php
if(isset($_POST['New_low_size'])){
$Area=1;
$newSize=$_POST['New_low_size'];
if ($newSize != 0){
$query =$conn->prepare( "UPDATE Area SET Area_size =? WHERE Area_number =?");
$query->bind_param('ii', $newSize,$Area);
$query->execute();
if($conn->error){
    echo '<div class="container">
    <div class="alert alert-danger d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  <div>
  Failed to update Area size  </div>
</div>
  </div></div>';
}else{
    echo '<div class="container">
    <div class="alert alert-success d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <div>
Area size updated</div>
  </div>
  </div>';
  echo '<script>
  setTimeout(function() {
      window.location.href = "dashboard.php"; 
  }, 2000);
</script>';

}
$query->close();
}else{
    echo '<div class="container">
    <div class="alert alert-danger d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  <div>
  Area size cannot be zero  </div>
</div>
  </div></div>'; 
}
}

if(isset($_POST['New_med_size']) ){
    $Area=2;
    $newSize=$_POST['New_med_size'];
   
    if ($newSize != 0){
          $query =$conn->prepare( "UPDATE Area SET Area_size =? WHERE Area_number =?");
    $query->bind_param('ii', $newSize,$Area);
    $query->execute();
   
    if($conn->error){
        echo '<div class="container">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
      <div>
      Failed to update Area size  </div>
    </div>
      </div></div>';
    }else{
        echo '<div class="container">
        <div class="alert alert-success d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
        <div>
    Area size updated</div>
      </div>
      </div>';
      echo '<script>
  setTimeout(function() {
      window.location.href = "dashboard.php"; 
  }, 2000);
</script>';
    }  
    $query->close();
    }else{
        echo '<div class="container">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
      <div>
      Area size cannot be zero  </div>
    </div>
      </div></div>'; 
    }
  
    
    }
    
if(isset($_POST['New_high_size'])){
    $Area=3;
    $newSize=$_POST['New_high_size'];

   if ($newSize != 0){
          $query =$conn->prepare( "UPDATE Area SET Area_size =? WHERE Area_number =?");
    $query->bind_param('ii', $newSize,$Area);
    $query->execute();
    if($conn->error){
        echo '<div class="container">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
      <div>
      Failed to update Area size  </div>
    </div>
      </div></div>';
    }else{
        echo '<div class="container">
        <div class="alert alert-success d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
        <div>
    Area size updated</div>
      </div>
      </div>';
      echo '<script>
  setTimeout(function() {
      window.location.href = "dashboard.php"; 
  }, 2000);
</script>';
    }
    $query->close(); 
    
    }else{
        echo '<div class="container">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
      <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
      <div>
      Area size cannot be zero  </div>
    </div>
      </div></div>'; 
    }
    
    }

?>