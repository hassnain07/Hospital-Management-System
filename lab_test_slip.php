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
// if (isset($_GET['id'])) {
    //  }
    
        $id = 23;

?>
<body>
  
<?php
$sel_qry = $conn->query('SELECT * FROM patient_tests WHERE admission_id = "'.$id.'" AND status = 1');
$row = $sel_qry->fetch(PDO::FETCH_ASSOC);
$sel_doc = $conn->query('SELECT * FROM lab_tests WHERE test_id = "'.$row['test_id'].'"');


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
                       <h3 style="position:relative;bottom:20px;left:60px">Lab test reports</h3>
                    </th>

                
                </thead>
                <!-- <br> -->
                <tbody>
                    <tr style="position:relative;bottom:20px;">
                        <td><b>Admission Id: </b><?php echo $row['admission_id']?></td>
                        <?php
                        while ($doc = $sel_doc->fetch(PDO::FETCH_ASSOC)) {
?>
                            <td><b>Patient Name: </b><?php echo $doc['test_name']?></td>
<?php
                        }
                        ?>
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