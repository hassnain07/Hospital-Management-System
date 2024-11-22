<?php
include('config/connection.php');

if (isset($_POST['give_test'])) {

    $admission_id = $_POST['patient_id'];
    
       
        foreach ($_POST['tests'] as $test) {
            
            $query = $conn->query("INSERT INTO patient_tests SET
                                
                                    admission_id = '".$admission_id."',
                                    test_id  = '".$test."'

            ");
            
        }
       

    if ($query)  { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Given sucessfully");
        // Append the expiry time to the URL
        $url = "patient_tests.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Not Given Successfully");
        // Append the expiry time to the URL
        $url = "patient_tests.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }

}

?>