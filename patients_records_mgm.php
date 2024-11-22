<?php
include('config/connection.php');

if (isset($_POST['upd_pat_rec'])) {
   
    $patient_name     = $_POST['patient_name'];
    $patient_age      = $_POST['patient_age'];
    $gender           = $_POST['gender'];
    $assigned_doctor  = $_POST['assigned_doctor'];
    $id               = $_POST['admission_id'];
   
 

// Prepare the query with placeholders
$query = "UPDATE patients SET 
           patient_name = :patient_name,
           patient_age = :patient_age, 
           gender = :gender
           WHERE admission_id = '".$id."'";


// Prepare the statement
$stmt = $conn->prepare($query);

// Bind parameters
$stmt->bindParam(':patient_name', $patient_name);
$stmt->bindParam(':patient_age', $patient_age);
$stmt->bindParam(':gender', $gender);

// Execute the statement
$result = $stmt->execute();

    // if ($result) {
    //     $last_item_id = $conn->lastInsertId();

    //     $sql = $conn->query("UPDATE items SET ex_id = '".$last_item_id."' WHERE item_id = '".$last_item_id."'");
        
    //     $insert_ex_stmt = $conn->query("INSERT INTO existing_items SET 
                 
    //               item_id       = '".$last_item_id."',
    //               cat_id        = '".$cat_id."',
    //               item_quantity = '".$item_qty."'

    //     ");
    // }
     
    if ($result) { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Record Edited successfully");
        // Append the expiry time to the URL
        $url = "patients_records.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Record Not Edited Successfully");
        // Append the expiry time to the URL
        $url = "patients_records.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }

}
if (isset($_GET['action']) && $_GET['action'] == 'delete_record') {

    $id     = $_GET['admission_id'];
    $del_stmt = $conn->query("DELETE FROM patients WHERE admission_id = '".$id."'");
        
    if ($del_stmt){ 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Record Deleted successfully");
        // Append the expiry time to the URL
        $url = "patients_records.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Record Not Deleted Successfully");
        // Append the expiry time to the URL
        $url = "patients_records.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }
}



?>