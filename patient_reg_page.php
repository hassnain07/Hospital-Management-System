<?php
include('config/connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
     include('body/title.php');
     include('body/font_awesome_links.php');
     ?>
    <style>
        body {
            margin: 0px;
            font-family: 'Poppins', sans-serif;
        }
        .page{
            height: 70vh;
            width: 100%;
        }
    </style>
</head>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
 }


?>
<body>
  
<?php
$sel_qry = $conn->query('SELECT * FROM patients WHERE admission_id = "'.$id.'" AND status = 1');
$row = $sel_qry->fetch(PDO::FETCH_ASSOC);
$sel_doc = $conn->query('SELECT * FROM doctors WHERE doctor_id = "'.$row['assigned_doctor'].'"');
$doc = $sel_doc->fetch(PDO::FETCH_ASSOC);

?>
    <table>
        <tr align ="center">
            <td width="15%">
                <center>
                <img src="docs\assets\img\logo1.png" alt="" style="width: 100%;position:relative;bottom:20px;right:20px ">
                </center>
            </td>
            <td width="70%">
         
            <table width="100%">
                <thead>
                    <th colspan="2" align="left">
                       <h2 style="position:relative;bottom:20px;left:60px"> Ghani Medical Hospital</h2>
                    </th>

                
                </thead>
                <!-- <br> -->
                <tbody>
                    <tr style="position:relative;bottom:20px;">
                        <td><b>Admission Id: </b><?php echo $row['admission_id']?></td>
                        <td><b>Patient Name: </b><?php echo $row['patient_name']?></td>
                        <td><b>Patient Age: </b><?php echo $row['patient_age']?></td>
                    </tr>
                    <tr style="position:relative;bottom:15px;">
                        <td><b>Gender: </b><?php echo $row['gender']?></td>
                        <td><b>Assigned Doctor: </b><?php echo $doc['doctor_name']?></td>
                        <td><b>Admission Date: </b><?php echo $row['addmission_date']?></td>
                    </tr>
                </tbody>
            </table>
            </td>
            
            
        </tr>
        
    </table>
    <hr size="1px">
    <div class="page">



    </div>
<!--     
    <table>
        <tr align   ="center">
        <hr size="1px">
            <td width="30%">
                
                <p align="right"><b>Address:</b>Mr John Smith. 132, My Street, Kingston, New York 12401.</p>
                <p align="right"><b>Contact:</b>091-12938409</p>
              
            </td>
            <td width="70%" align="right">
            
                <img src="docs\assets\img\AdminLTELogo.png" alt="" style="">
          
            </td>
            
            
        </tr>
        
    </table> -->

  
</body>
<script>
    window.print();
    
</script>

</html>