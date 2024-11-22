<?php
include('config/connection.php');

if (isset($_POST['add_medicine'])) {
    
    $medicine_name    = $_POST['medicine_name'];
    $medicine_cost    = $_POST['medicine_cost'];

    $add_qry = "INSERT INTO medicines SET 

           medicine_name = :medicine_name,
           medicine_cost = :medicine_cost
             ";

    $run_add_qry = $conn->prepare($add_qry);
    $run_add_qry->bindParam(':medicine_name',$medicine_name);
    $run_add_qry->bindParam(':medicine_cost',$medicine_cost);

    if ($run_add_qry->execute()) { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Logged In sucessfully");
        // Append the expiry time to the URL
        $url = "medicines.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Password Or name is incorrect");
        // Append the expiry time to the URL
        $url = "medicines.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }

}

if (isset($_POST['update_medicine'])) {
    
    $medicine_id        = $_POST['action'];
    $medicine_name      = $_POST['medicine_name'];
    $medicine_cost      = $_POST['medicine_cost'];

    $upd_qry = "UPDATE medicines SET 

             medicine_name = :medicine_name,
             medicine_cost = :medicine_cost
             WHERE medicine_id = :medicine_id";

   
             $run_upd_qry = $conn->prepare($upd_qry);
             $run_upd_qry->bindParam(':medicine_name',$medicine_name);
             $run_upd_qry->bindParam(':medicine_cost',$medicine_cost);
             $run_upd_qry->bindParam(':medicine_id',$medicine_id);

    if ($run_upd_qry->execute()){ 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Logged In sucessfully");
        // Append the expiry time to the URL
        $url = "medicines.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Password Or name is incorrect");
        // Append the expiry time to the URL
        $url = "medicines.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }

}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    $id      = $_GET['medicine_id'];   
    $del_qry = $conn->query("DELETE FROM medicines WHERE medicine_id = '".$id."'");
    $del_pat_qry = $conn->query("DELETE FROM patient_medicine WHERE medicine_id = '".$id."'");

    if ($del_pat_qry) { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Medicine Deleted sucessfully");
        // Append the expiry time to the URL
        $url = "medicines.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Medicine Not Deleted Successfully");
        // Append the expiry time to the URL
        $url = "medicines.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }
   
}

?>