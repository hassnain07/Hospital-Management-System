<?php
include("config/connection.php");
if (isset($_POST['add_admin'])) {
    
    $username    = $_POST['admin_name'];
    $password    = $_POST['password'];
    $role        = $_POST['role'];


    $sel_qry = $conn->query("SELECT * FROM admins WHERE admin_name = '".$username."' OR password = '".$password."'");

    if ($sel_qry->rowCount() > 0) {
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Password Or name is incorrect");
        // Append the expiry time to the URL
        $url = "access_control.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
    }

    $insert_stmt = $conn->prepare("INSERT INTO admins SET 
                       
                       admin_name  = :username,
                       role        = :role,
                       password    = :password
    
    ");

    $insert_stmt->bindParam(':username', $username);
    $insert_stmt->bindParam(':role', $role);
    $insert_stmt->bindParam(':password', $password);

    


    // if ($insert_stmt->execute()) {
       
    //     $admin_id = $conn->lastInsertId();
    //     $selected_role = $_POST['role'];
        
        
    //     foreach ($selected_role as $role_id) {
            
    //         $insert_access = $conn->query("INSERT INTO user_access SET
                        
    //                     admin_id = '".$admin_id."',
    //                     role_id  = '".$role_id."'
            
    //         ");
    //     }

    // }
    if ($insert_stmt->execute()){ 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Logged In sucessfully");
        // Append the expiry time to the URL
        $url = "access_control.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Password Or name is incorrect");
        // Append the expiry time to the URL
        $url = "access_control.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }


}


?>