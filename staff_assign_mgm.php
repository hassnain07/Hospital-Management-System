<?php
include('config/connection.php');

if (isset($_POST['add_member'])) {
    
    $first_name = $_POST['first_name'];
    $sur_name = $_POST['sur_name'];
    $designation = $_POST['designation'];

    $add_qry = "INSERT INTO staff SET 

           first_name = :first_name,
           sur_name = :sur_name,
           designation = :designation

             ";
    $run_add_qry = $conn->prepare($add_qry);
    $run_add_qry->bindParam(':first_name',$first_name);
    $run_add_qry->bindParam(':sur_name',$sur_name);
    $run_add_qry->bindParam(':designation',$designation);



    if ($run_add_qry->execute()) { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Member Added sucessfully");
        // Append the expiry time to the URL
        $url = "staff_assign.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Member Not Added sucessfully");
        // Append the expiry time to the URL
        $url = "staff_assign.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }

}

if (isset($_POST['update_member'])) {
    
    $staff_id     = $_POST['action'];
    $first_name = $_POST['first_name'];
    $sur_name   = $_POST['sur_name'];
    $designation = $_POST['designation'];

    $upd_qry = "UPDATE staff SET 

             first_name = :first_name,
             sur_name = :sur_name,
             designation = :designation
             WHERE staff_id = :staff_id";

             $run_upd_qry = $conn->prepare($upd_qry);
             $run_upd_qry->bindParam(':first_name',$first_name);
             $run_upd_qry->bindParam(':sur_name',$sur_name);
             $run_upd_qry->bindParam(':designation',$designation);
             $run_upd_qry->bindParam(':staff_id',$staff_id);

    if ($run_upd_qry->execute()) { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Member Edited sucessfully");
        // Append the expiry time to the URL
        $url = "staff_assign.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Member Not Edited sucessfully");
        // Append the expiry time to the URL
        $url = "staff_assign.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }

}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    $id     = $_GET['staff_id'];   
    $del_qry = $conn->query("DELETE FROM staff WHERE staff_id = '".$id."'");

    if ($del_qry) { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Member Deleted sucessfully");
        // Append the expiry time to the URL
        $url = "staff_assign.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Member not Deleted sucessfully");
        // Append the expiry time to the URL
        $url = "staff_assign.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }
   
}

?>