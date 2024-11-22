<?php
if (isset($_GET['okmsg'])) {

    $expiryTime = $_GET['expiry'];
    // Check if the current time is past the expiry time
    if (time() > $expiryTime) {
        
    }else {
      
  

  ?>
<!-- HTML code for the alert -->
<div id="successAlert" class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h1>Success!</h1>
    <h6><?php echo base64_decode($_GET['okmsg']); ?></h6>
</div>
<!-- JavaScript code to remove the alert after a certain time -->
<script>
    // Function to remove the alert after a specified time
    function removeAlert() {
        var alertDiv = document.getElementById('successAlert');
        if (alertDiv) {
            alertDiv.remove(); // Remove the alert
        }
    }

    // Call removeAlert function after 5 seconds (adjust as needed)
    setTimeout(removeAlert, 5000); // 5000 milliseconds = 5 seconds
</script>
  <?php
    }
}

?>




<?php
if (isset($_GET['errormsg'])) {
  $expiryTime = $_GET['expiry'];
  // Check if the current time is past the expiry time
  if (time() > $expiryTime) {
      
  }else {
 ?>
<!-- HTML code for the error alert -->
<div id="errorAlert" class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong><h1>Error!</h1></strong>
    <h5><?php echo base64_decode($_GET['errormsg']); ?></h5>
</div>

<!-- JavaScript code to remove the error alert after a certain time -->
<script>
    // Function to remove the error alert after a specified time
    function removeErrorAlert() {
        var errorAlertDiv = document.getElementById('errorAlert');
        if (errorAlertDiv) {
            errorAlertDiv.remove(); // Remove the error alert
        }
    }

    // Call removeErrorAlert function after 5 seconds (adjust as needed)
    setTimeout(removeErrorAlert, 5000); // 5000 milliseconds = 5 seconds
</script>
 <?php
  }
}



?>
