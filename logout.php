<?php
include('config/connection.php');
session_destroy();
  // Calculate the expiry time (e.g., 1 hour from now)
  $expiryTime = time() + (1 * 3); // 1 hour
  $errormsg = base64_encode("Logged Out Successfully");
  // Append the expiry time to the URL
  $url = "index.php?okmsg=$errormsg&expiry=$expiryTime";
  header("Location: $url");

?>