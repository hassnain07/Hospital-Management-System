<?php
include('config/connection.php');

if (isset($_POST['add_room'])) {
    
    $room_no    = $_POST['room_no'];
    $room_cost = $_POST['room_cost'];

    $add_qry = "INSERT INTO rooms SET 

           room_no = '".$room_no."',
           room_cost = '".$room_cost."'
             ";

    $run_add_qry = $conn->query($add_qry);

    if ($run_add_qry) { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Room Added successfully");
        // Append the expiry time to the URL
        $url = "rooms.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Room Not Added Successfully");
        // Append the expiry time to the URL
        $url = "rooms.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }

}

if (isset($_POST['update_room'])) {
    
    $room_id        = $_POST['action'];
    $room_no      = $_POST['room_no'];
    $room_cost   = $_POST['room_cost'];

    $upd_qry = "UPDATE rooms SET 

             room_no = '".$room_no."',
             room_cost = '".$room_cost."'
             WHERE room_id = '".$room_id."'";

    $run_upd_qry = $conn->query($upd_qry);

    if ($run_upd_qry) { 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Room Edited successfully");
        // Append the expiry time to the URL
        $url = "rooms.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Room Not Edited Successfully");
        // Append the expiry time to the URL
        $url = "rooms.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }

}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    $id     = $_GET['room_id'];   
    $del_qry = $conn->query("DELETE FROM rooms WHERE room_id = '".$id."'");

    if ($del_qry){ 

        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $okmsg = base64_encode("Room deleted successfully");
        // Append the expiry time to the URL
        $url = "rooms.php?okmsg=$okmsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       } else {
   
        // Calculate the expiry time (e.g., 1 hour from now)
        $expiryTime = time() + (1 * 3); // 1 hour
        $errormsg = base64_encode("Room Not deleted Successfully");
        // Append the expiry time to the URL
        $url = "rooms.php?errormsg=$errormsg&expiry=$expiryTime";
        header("Location: $url");
        exit;
   
       }
   
}

?>