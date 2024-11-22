<?php
include('config/connection.php');


if (isset($_POST['alot_med_service'])) {

    $admission_id = $_POST['patient_id'];
    
    if (!empty($_POST['medicines']) && !empty($_POST['services'])) {
       
        foreach ($_POST['medicines'] as $medicine) {
            
            $query = $conn->query("INSERT INTO patient_medicine SET
                                
                                    admission_id = '".$admission_id."',
                                    medicine_id  = '".$medicine."'

            ");
            
        }
        foreach ($_POST['services'] as $service) {
            
            $query = $conn->query("INSERT INTO patient_services SET
                                
                                    admission_id = '".$admission_id."',
                                    service_id   = '".$service."'

            ");
            
        }

        
      
    }elseif (!empty($_POST['medicines'])) {

        foreach ($_POST['medicines'] as $medicine) {
            
            $query = $conn->query("INSERT INTO patient_medicine SET
                                
                                    admission_id = '".$admission_id."',
                                    medicine_id  = '".$medicine."'

            ");
            
        }
    

    }elseif (!empty($_POST['services'])) {

        foreach ($_POST['services'] as $service) {
            
            $query = $conn->query("INSERT INTO patient_services SET
                                
                                    admission_id = '".$admission_id."',
                                    service_id   = '".$service."'

            ");
            
        }

    }else {

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("No Medicine or service selected");
        // Append the expiry time to the URL
        $url = "patient_med_service.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
    
    }


    if($query){

        $upd_qry = $conn->query("UPDATE patients SET status = 2 WHERE admission_id = '".$admission_id."'");

    }

    if ($upd_qry)  { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Given sucessfully");
        // Append the expiry time to the URL
        $url = "patient_med_service.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Not Given Successfully");
        // Append the expiry time to the URL
        $url = "patient_med_service.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }

}

?>