<?php
include('config/connection.php');

if (isset($_POST['add_test'])) {
    
    $test_name    = $_POST['test_name'];
    $test_cost    = $_POST['test_cost'];

    $add_qry = "INSERT INTO lab_tests SET 

           test_name      = :name,
           test_cost      = :test_cost
             ";


             

    $run_add_qry = $conn->prepare($add_qry);
    $run_add_qry->bindParam(":name",$test_name);
    $run_add_qry->bindParam(":test_cost",$test_cost);

    if ($run_add_qry->execute()) { 

         // Calculate the expiry time (e.g., 1 hour from now)
         $expiryTime = time() + (1 * 3); // 1 hour
         $okmsg = base64_encode("Test added sucessfully");
         // Append the expiry time to the URL
         $url = "lab_tests.php?okmsg=$okmsg&expiry=$expiryTime";
         header("Location: $url");
         exit;
    
        } else {
    
         // Calculate the expiry time (e.g., 1 hour from now)
         $expiryTime = time() + (1 * 3); // 1 hour
         $errormsg = base64_encode("Test Not added sucessfully");
         // Append the expiry time to the URL
         $url = "lab_tests.php?errormsg=$errormsg&expiry=$expiryTime";
         header("Location: $url");
         exit;
    
        }

}

if (isset($_POST['update_test'])) {
    
    $test_id        = $_POST['action'];
    $test_name      = $_POST['test_name'];
    $test_cost          = $_POST['test_cost'];

    $upd_qry = "UPDATE lab_tests SET 

             test_name = :name,
             test_cost = :test_cost
             WHERE test_id = :id";

             $run_add_qry = $conn->prepare($upd_qry);
             $run_add_qry->bindParam(":name",$test_name);
             $run_add_qry->bindParam(":test_cost",$test_cost);
             $run_add_qry->bindParam(":id",$test_id);

    if ($run_add_qry->execute()) { 

          // Calculate the expiry time (e.g., 1 hour from now)
          $expiryTime = time() + (1 * 3); // 1 hour
          $okmsg = base64_encode("Test Updated sucessfully");
          // Append the expiry time to the URL
          $url = "lab_tests.php?okmsg=$okmsg&expiry=$expiryTime";
          header("Location: $url");
          exit;
    
        } else {
    
         // Calculate the expiry time (e.g., 1 hour from now)
         $expiryTime = time() + (1 * 3); // 1 hour
         $errormsg = base64_encode("Test Not Updated sucessfully");
         // Append the expiry time to the URL
         $url = "lab_tests.php?errormsg=$errormsg&expiry=$expiryTime";
         header("Location: $url");
         exit;
    
        }

}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    $id     = $_GET['doctor_id'];   
    $del_qry = $conn->query("DELETE FROM doctors WHERE doctor_id = '".$id."'");

    if ($del_qry) { 

          // Calculate the expiry time (e.g., 1 hour from now)
          $expiryTime = time() + (1 * 3); // 1 hour
          $okmsg = base64_encode("Logged In sucessfully");
          // Append the expiry time to the URL
          $url = "doctor_assign.php?okmsg=$okmsg&expiry=$expiryTime";
          header("Location: $url");
          exit;
        } else {
      // Calculate the expiry time (e.g., 1 hour from now)
      $expiryTime = time() + (1 * 3); // 1 hour
      $errormsg = base64_encode("Password Or name is incorrect");
      // Append the expiry time to the URL
      $url = "doctor_assign.php?errormsg=$errormsg&expiry=$expiryTime";
      header("Location: $url");
      exit;
    
        }
   
}

?>