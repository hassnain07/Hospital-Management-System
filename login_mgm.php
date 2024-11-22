<?php
include("config/connection.php");

if(isset($_POST['admin_login'])){

    $name = $_POST['admin_name'];
    $pass = $_POST['admin_pass'];

    $sel_qry = "SELECT * FROM admins WHERE admin_name = '".$name."' AND password = $pass";
    $run_sel = $conn->query($sel_qry);
    
    $admin_data_arr = $run_sel->fetch(PDO::FETCH_ASSOC);
    $records = $run_sel->rowCount();

    
    if($records > 0){

        $_SESSION['admin_id']  = $admin_data_arr['admin_id'];
           // Calculate the expiry time (e.g., 1 hour from now)
           $expiryTime = time() + (1 * 3); // 1 hour
           $okmsg = base64_encode("Logged In sucessfully");
           // Append the expiry time to the URL
           $url = "dashboard.php?okmsg=$okmsg&expiry=$expiryTime";
           header("Location: $url");
           exit;
    }
    else {
         // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Password Or name is incorrect");
        // Append the expiry time to the URL
        $url = "index.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
        }
  
}


?>



