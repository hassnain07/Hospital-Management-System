<?PHP
include('config/connection.php');
$id = $_GET['admission_id'];

if (isset($_GET['admission_id'])) {
    
    $upd_qry = $conn->query('UPDATE patients_bills SET status = 2 WHERE admission_id = "'.$id.'"');
    $upd_qry = $conn->query('UPDATE patients SET status = 4 WHERE admission_id = "'.$id.'"');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  include('body/title.php');
  ?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-6 offset-3">
        <h2 class="page-header">
          <img src="docs\assets\img\logo1.png" width="20%" alt=""> &nbsp;&nbsp;&nbsp;   Ghani Medical Hospital
        </h2>
    </div>
    <!-- /.col -->
</div>
<h2 class="float-right">Date: <?php echo date('Y-M-d')?></h2>
    <!-- info row -->
    <div class="row invoice-info">
      
    <?php
       $total = $conn->query('SELECT * FROM patients_bills WHERE admission_id = "'.$id.'" AND status = 2')->fetch(PDO::FETCH_ASSOC);
       $patient_info = $conn->query('SELECT * FROM patients WHERE admission_id = "'.$id.'" AND status = 4')->fetch(PDO::FETCH_ASSOC);
    
    ?>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice #<?php echo $total['bill_id']?></b><br>
    
      </div>
      <div class="col-sm-4 invoice-col">
        <b>Patient Name: </b> <?php echo ucfirst($patient_info['patient_name'])?><br>
        
      </div>
      <div class="col-sm-4 invoice-col">
        <b>Admission Id: </b> <?php echo $patient_info['admission_id']?><br>
    
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <br><br>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
   <!-- <div class="col-6"></div> -->
      <!-- /.col -->
      <div class="col-10 offset-1">
        <?php
        $doc_charges  = $conn->query('SELECT * FROM doctors WHERE doctor_id = "'.$patient_info['assigned_doctor'].'"')->fetch(PDO::FETCH_ASSOC);
        $patient_medicines = $conn->query('SELECT * FROM patient_medicine WHERE admission_id = "'.$patient_info['admission_id'].'"')->fetchAll(PDO::FETCH_ASSOC); 
        $patient_services = $conn->query('SELECT * FROM patient_services WHERE admission_id = "'.$patient_info['admission_id'].'"')->fetchAll(PDO::FETCH_ASSOC); 
        $patient_tests = $conn->query('SELECT * FROM patient_tests WHERE admission_id = "'.$patient_info['admission_id'].'"')->fetchAll(PDO::FETCH_ASSOC); 
       
        ?>

        <div class="table-responsive">
          <table class="table" width="100%">
            <tr>
              <th >Admission date: <?php echo $patient_info['addmission_date']?></th>
              <th>Discharge Date: <?php echo $patient_info['discharge_date']?></th>
          
            </tr>
           
            <tr>
              <th>Doctor Charges:</th>
              <td><?php echo $doc_charges['charges']?> Rs</td>
            </tr>

            <?php
            if ($patient_info['patient_type'] == 'in_patient' && $patient_info['alloted_room'] !== "No room alloted" ) {

                $room = $conn->query('SELECT * FROM rooms WHERE room_id = "'.$patient_info['alloted_room'].'"')->fetch(PDO::FETCH_ASSOC);

                $room_cost_per_day = intval($room['room_cost']);
                // Start and end dates
                $start_date = $patient_info['addmission_date'];
                $end_date = $patient_info['discharge_date'];  

                // Convert dates to DateTime objects
                $start_date_obj = new DateTime($start_date);
                $end_date_obj = new DateTime($end_date);

                // Calculate the difference between dates
                $interval = $start_date_obj->diff($end_date_obj);

                // Get the difference in days
                $days_stayed = $interval->days;
                if ($days_stayed  == 0) {
                    $days_stayed = 1;
                }
                // Calculate the total cost
                $total_cost = $room_cost_per_day * $days_stayed;

                ?>
            <tr>
              <th>Room Charges:</th>
              <td><?php echo $total_cost?> Rs</td>
            </tr>
                <?php
            }

            if (!empty($patient_medicines)) {
                foreach ($patient_medicines as $medicines ) {
                    $medicine = $conn->query('SELECT * FROM medicines WHERE medicine_id = "'.$medicines['medicine_id'].'"')->fetch(PDO::FETCH_ASSOC);
                    ?>
                <tr>
                  <th><?php echo $medicine['medicine_name']?></th>
                  <td><?php echo $medicine['medicine_cost']?> Rs</td>
                </tr>
                    <?php
    
                }
            }
            if (!empty($patient_services)) {
                foreach ($patient_services as $services ) {
                    $service = $conn->query('SELECT * FROM services WHERE service_id = "'.$services['service_id'].'"')->fetch(PDO::FETCH_ASSOC);
                    ?>
                <tr>
                  <th><?php echo $service['service_name']?></th>
                  <td><?php echo $service['service_cost']?> Rs</td>
                </tr>
                    <?php
    
                }
            }
            if (!empty($patient_tests)) {
              $total_test_cost = 0;
                foreach ($patient_tests as $tests ) {
                    $test  = $conn->query('SELECT * FROM lab_tests WHERE test_id = "'.$tests['test_id'].'"')->fetch(PDO::FETCH_ASSOC);
                    $total_test_cost += $test['test_cost'];
                    ?>
                <tr>
                  <th><?php echo $test['test_name']?></th>
                  <td><?php echo $test['test_cost']?> Rs</td>
                </tr>
                    <?php
    
                }
            }


            ?>
           
           
            <tr>
              <th>Total:</th>
              <td><?php
              $total_amount_pat = intval($total['total_amount']) + intval($test['test_cost']);
               echo $total_amount_pat?> Rs</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
