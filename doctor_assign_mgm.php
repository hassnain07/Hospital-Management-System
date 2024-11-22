<?php
include('config/connection.php');

if (isset($_POST['add_doctor'])) {
    
    $doctor_name    = $_POST['doctor_name'];
    $charges    = $_POST['charges'];
    $specialization = $_POST['specialization'];

    $add_qry = "INSERT INTO doctors SET 

           doctor_name    = :name,
           charges        = :charges,
           specialization = :specialization
             ";


             

    $run_add_qry = $conn->prepare($add_qry);
    $run_add_qry->bindParam(":name",$doctor_name);
    $run_add_qry->bindParam(":charges",$charges);
    $run_add_qry->bindParam(":specialization",$specialization);

    if ($run_add_qry->execute()) { 

         // Calculate the expiry time (e.g., 1 hour from now)
         $expiryTime = time() + (1 * 3); // 1 hour
         $okmsg = base64_encode("Doctor added sucessfully");
         // Append the expiry time to the URL
         $url = "doctor_assign.php?okmsg=$okmsg&expiry=$expiryTime";
         header("Location: $url");
         exit;
    
        } else {
    
         // Calculate the expiry time (e.g., 1 hour from now)
         $expiryTime = time() + (1 * 3); // 1 hour
         $errormsg = base64_encode("Doctor Not added sucessfully");
         // Append the expiry time to the URL
         $url = "doctor_assign.php?errormsg=$errormsg&expiry=$expiryTime";
         header("Location: $url");
         exit;
    
        }

}

if (isset($_POST['update_doctor'])) {
    
    $doctor_id        = $_POST['action'];
    $doctor_name      = $_POST['doctor_name'];
    $charges          = $_POST['charges'];
    $specialization   = $_POST['specialization'];

    $upd_qry = "UPDATE doctors SET 

             doctor_name = :name,
             specialization = :specialization,
             charges = :charges
             WHERE doctor_id = :id";

             $run_add_qry = $conn->prepare($upd_qry);
             $run_add_qry->bindParam(":name",$doctor_name);
             $run_add_qry->bindParam(":charges",$charges);
             $run_add_qry->bindParam(":specialization",$specialization);
             $run_add_qry->bindParam(":id",$doctor_id);

    if ($run_add_qry->execute()) { 

          // Calculate the expiry time (e.g., 1 hour from now)
          $expiryTime = time() + (1 * 3); // 1 hour
          $okmsg = base64_encode("Doctor Updated sucessfully");
          // Append the expiry time to the URL
          $url = "doctor_assign.php?okmsg=$okmsg&expiry=$expiryTime";
          header("Location: $url");
          exit;
    
        } else {
    
         // Calculate the expiry time (e.g., 1 hour from now)
         $expiryTime = time() + (1 * 3); // 1 hour
         $errormsg = base64_encode("Doctor Not Updated sucessfully");
         // Append the expiry time to the URL
         $url = "doctor_assign.php?errormsg=$errormsg&expiry=$expiryTime";
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