<?php
include('config/connection.php');

if (isset($_POST['add_service'])) {
    
    $service_name    = $_POST['service_name'];
    $service_cost    = $_POST['service_cost'];

    $add_qry = "INSERT INTO services SET 

           service_name = :service_name,
           service_cost = :service_cost
             ";

    $run_add_qry = $conn->prepare($add_qry);
    $run_add_qry->bindParam(':service_name',$service_name);
    $run_add_qry->bindParam(':service_cost',$service_cost);

    if ($run_add_qry->execute()) { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Service Added successfully");
        // Append the expiry time to the URL
        $url = "services.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Service Not Added Successfully");
        // Append the expiry time to the URL
        $url = "services.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }

}

if (isset($_POST['update_service'])) {
    
    $service_id        = $_POST['action'];
    $service_name      = $_POST['service_name'];
    $service_cost      = $_POST['service_cost'];

    $upd_qry = "UPDATE services SET 

             service_name = :service_name,
             service_cost = :service_cost
             WHERE service_id = :id";

             $run_upd_qry = $conn->prepare($upd_qry);
             $run_upd_qry->bindParam(':service_name',$service_name);
             $run_upd_qry->bindParam(':service_cost',$service_cost);
             $run_upd_qry->bindParam(':id',$service_id);

    if ($run_upd_qry->execute()) { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Service Edited successfully");
        // Append the expiry time to the URL
        $url = "services.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Service Not Edited Successfully");
        // Append the expiry time to the URL
        $url = "services.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }

}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    $id      = $_GET['service_id'];   
    $del_qry = $conn->query("DELETE FROM services WHERE service_id = '".$id."'");
    $del_pat_qry = $conn->query("DELETE FROM patient_services WHERE service_id = '".$id."'");

    if ($del_pat_qry) { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Service deleted successfully");
        // Append the expiry time to the URL
        $url = "services.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Service Not deleted Successfully");
        // Append the expiry time to the URL
        $url = "services.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }
   
}

?>