<?php
include('config/connection.php');

if (isset($_POST['reg_patient'])) {
   
    $patient_name     = $_POST['patient_name'];
    $patient_age      = $_POST['patient_age'];
    $patient_type     = $_POST['patient_type'];
    $gender           = $_POST['gender'];
    $assigned_doctor  = $_POST['assigned_doctor'];
    $addmission_date  = date('Y-m-d');

    if (!empty($_POST['alloted_room'])) {
        $alloted_room     = $_POST['alloted_room'];
        $upd_room_qry = $conn->query("UPDATE rooms SET status = 2 WHERE room_id = '".$alloted_room."'");
    }else {
        $alloted_room = "No room alloted";
    }



 

// Prepare the query with placeholders
$query = "INSERT INTO patients (patient_name, patient_age, patient_type, gender, assigned_doctor, alloted_room, addmission_date) 
          VALUES (:patient_name, :patient_age, :patient_type, :gender, :assigned_doctor, :alloted_room, :addmission_date)";

// Prepare the statement
$stmt = $conn->prepare($query);

// Bind parameters
$stmt->bindParam(':patient_name', $patient_name);
$stmt->bindParam(':patient_age', $patient_age);
$stmt->bindParam(':patient_type', $patient_type);
$stmt->bindParam(':gender', $gender);
$stmt->bindParam(':assigned_doctor', $assigned_doctor);
$stmt->bindParam(':alloted_room', $alloted_room);
$stmt->bindParam(':addmission_date', $addmission_date);

// Execute the statement
    $result = $stmt->execute();

    if ($result) {

        $id = $conn->lastInsertId();
        $upd_qry = $conn->query("UPDATE doctors SET status = 2 WHERE doctor_id = '".$assigned_doctor."'");
    
        if ($upd_qry) { 

            // Calculate the expiry time (e.g., 1 hour from now)
            $expiryTime = time() + (1 * 3); // 1 hour
            $okmsg = base64_encode("Patient registered successfully");
            // Append the expiry time to the URL
            $url = "patients_reg.php?okmsg=$okmsg&expiry=$expiryTime";
            header("Location: $url");
            exit;
       
           } else {
       
            // Calculate the expiry time (e.g., 1 hour from now)
            $expiryTime = time() + (1 * 3); // 1 hour
            $errormsg = base64_encode("Patient Not registered Successfully");
            // Append the expiry time to the URL
            $url = "patients_reg.php?errormsg=$errormsg&expiry=$expiryTime";
            header("Location: $url");
            exit;
       
           }

    }
     
  

}




?>