<?php
include('config/connection.php');
if (isset($_GET['action']) && $_GET['action'] == 'discharge_patient') {

    $id          = $_GET['admission_id']; 
    $doc_id      = $_GET['doc_id']; 
    $room_id     = $_GET['room']; 


    $upd_qry = $conn->prepare("UPDATE patients SET
                               
                                discharge_date = :date,
                                status = :status
                                WHERE admission_id = :id"
                                );

    $date = date('Y-m-d');
    $status = 3;

    $upd_qry->bindParam(':date', $date);
    $upd_qry->bindParam(':status', $status);
    $upd_qry->bindParam(':id', $id); 

      if ($upd_qry->execute()) {

         $sql      = $conn->query("UPDATE doctors SET status = 1 WHERE doctor_id = '".$doc_id."'");
         
         if ($room_id !== 'No room alloted' ) {

         $sql_room      = $conn->query("UPDATE rooms SET status = 1 WHERE room_id = '".$room_id."'");
            
         }

      }

      if ($sql) {
        
        $sel_qry = $conn->query('SELECT * FROM patients WHERE admission_id = "'.$id.'"');
        $row = $sel_qry->fetch(PDO::FETCH_ASSOC);
        if ($row['patient_type'] == 'in_patient') {
    
            $pat_med_qry = "SELECT * FROM patient_medicine WHERE admission_id = '".$id."'";
            $pat_ser_qry = "SELECT * FROM patient_services WHERE admission_id = '".$id."'";
            $pat_doc_qry = "SELECT * FROM doctors WHERE doctor_id = '".$doc_id."'";
            $pat_room_qry = "SELECT * FROM rooms WHERE room_id = '".$room_id."'";
    
            $result1 = $conn->query($pat_med_qry)->fetchAll(PDO::FETCH_ASSOC);
            $result2 = $conn->query($pat_ser_qry)->fetchAll(PDO::FETCH_ASSOC);
            $result3 = $conn->query($pat_doc_qry)->fetch(PDO::FETCH_ASSOC);
            $result4 = $conn->query($pat_room_qry)->fetch(PDO::FETCH_ASSOC);
            $total_med_cost = 0; 
            $total_ser_cost = 0; 
            
           
         
            // Fetch all medicine IDs from $result1
            $medicine_ids = array_column($result1, 'medicine_id');
            $service_ids = array_column($result2, 'service_id');
          
            // Check if there are any service IDs
            if (!empty($service_ids)) {
                // Prepare the list of service IDs for the SQL query
                $service_ids_str = implode(',', $service_ids);
                $sql = "SELECT service_id, service_cost FROM services WHERE service_id IN ($service_ids_str)";
                
                // Fetch all service costs at once
                $sel_ser_costs = $conn->query("SELECT service_id, service_cost FROM services WHERE service_id IN ($service_ids_str)")->fetchAll(PDO::FETCH_ASSOC);
                 
                // Calculate total service cost
                foreach ($sel_ser_costs as $service) {
                    $total_ser_cost += intval($service['service_cost']);
                }
            }
    
    
            // Check if there are any medicine IDs
            if (!empty($medicine_ids)) {
                // Prepare the list of medicine IDs for the SQL query
                $medicine_ids_str = implode(',', $medicine_ids);
    
                // Fetch all medicine costs at once
                $sel_med_costs = $conn->query("SELECT medicine_id, medicine_cost FROM medicines WHERE medicine_id IN ($medicine_ids_str)")->fetchAll(PDO::FETCH_ASSOC);
    
                // Calculate total medicine cost
                foreach ($sel_med_costs as $medicine) {
                    $total_med_cost += intval($medicine['medicine_cost']);
                }
            }
            
            $patient_total = intval($total_med_cost) + intval($total_ser_cost) + intval($result3['charges']) + intval($result4['room_cost']);
            $insert_qry = $conn->query('INSERT INTO patients_bills SET
                                  
                                  admission_id = "'.$id.'",
                                  total_amount = "'.$patient_total.'"
            ');
        }elseif ($row['patient_type'] == 'out_patient') {
            
            $pat_med_qry = "SELECT * FROM patient_medicine WHERE admission_id = '".$id."'";
            $pat_ser_qry = "SELECT * FROM patient_services WHERE admission_id = '".$id."'";
            $pat_doc_qry = "SELECT * FROM doctors WHERE doctor_id = '".$doc_id."'";
    
            $result1 = $conn->query($pat_med_qry)->fetchAll(PDO::FETCH_ASSOC);
            $result2 = $conn->query($pat_ser_qry)->fetchAll(PDO::FETCH_ASSOC);
            $result3 = $conn->query($pat_doc_qry)->fetch(PDO::FETCH_ASSOC);
            $total_med_cost = 0; 
            $total_ser_cost = 0; 
            
           
         
            // Fetch all medicine IDs from $result1
            $medicine_ids = array_column($result1, 'medicine_id');
            $service_ids = array_column($result2, 'service_id');
          
            // Check if there are any service IDs
            if (!empty($service_ids)) {
                // Prepare the list of service IDs for the SQL query
                $service_ids_str = implode(',', $service_ids);
                $sql = "SELECT service_id, service_cost FROM services WHERE service_id IN ($service_ids_str)";
                
                // Fetch all service costs at once
                $sel_ser_costs = $conn->query("SELECT service_id, service_cost FROM services WHERE service_id IN ($service_ids_str)")->fetchAll(PDO::FETCH_ASSOC);
                 
                // Calculate total service cost
                foreach ($sel_ser_costs as $service) {
                    $total_ser_cost += intval($service['service_cost']);
                }
            }
    
    
            // Check if there are any medicine IDs
            if (!empty($medicine_ids)) {
                // Prepare the list of medicine IDs for the SQL query
                $medicine_ids_str = implode(',', $medicine_ids);
    
                // Fetch all medicine costs at once
                $sel_med_costs = $conn->query("SELECT medicine_id, medicine_cost FROM medicines WHERE medicine_id IN ($medicine_ids_str)")->fetchAll(PDO::FETCH_ASSOC);
    
                // Calculate total medicine cost
                foreach ($sel_med_costs as $medicine) {
                    $total_med_cost += intval($medicine['medicine_cost']);
                }
            }
            
            $patient_total = intval($total_med_cost) + intval($total_ser_cost) + intval($result3['charges']);
            $insert_qry = $conn->query('INSERT INTO patients_bills SET
                                  
                                  admission_id = "'.$id.'",
                                  total_amount = "'.$patient_total.'"
            ');






        }
    

      }
      
     if ($insert_qry) { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Logged In sucessfully");
        // Append the expiry time to the URL
        $url = "attended_patients.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Password Or name is incorrect");
        // Append the expiry time to the URL
        $url = "attended_patients.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }

   
}


?>