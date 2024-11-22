<?php
include('config/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php
  include('body/title.php');
  include('body/font_awesome_links.php');
  ?>

    <!-- Google Font: Source Sans Pro -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
    <!-- DataTables -->
    <link
      rel="stylesheet"
      href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"
    />
    <link
      rel="stylesheet"
      href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css"
    />
    <link
      rel="stylesheet"
      href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css"
    />
      <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css" />
  </head>
  <body class="hold-transition sidebar-mini">
    <div class="wrapper">
      <?php
  include('body/header.php');
  ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <?php
                include('body/msgs.php');
                ?>
                </div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Attended Patients Records</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Attended Patients</li>
                </ol>
              </div>
            </div>
          </div>
          <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Attended Patients are shown here</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table
                      id="example1"
                      class="table table-bordered table-hover"
                    >
                      <thead>
                        <tr>
                          <th>Addmission Date</th>
                          <th>Addmission Id</th>
                          <th>Patient Name</th>
                          <th>Assigned Doctor</th>
                          <th>Patient Type</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 

                    $sel_qry = $conn->query("SELECT * FROM patients WHERE status
                        = 2"); while ($row =
                        $sel_qry->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr>
                          <td><?php echo $row['addmission_date']?></td>
                          <td><?php echo $row['admission_id']?></td>
                          <td><?php echo ucfirst($row['patient_name'])?></td>
                          <td>
                            <?php 
                        $sel_doc = $conn->query("SELECT * FROM doctors WHERE
                            doctor_id = '".$row['assigned_doctor']."'"); $doc =
                            $sel_doc->fetch(PDO::FETCH_ASSOC); echo
                            $doc['doctor_name']."(".$doc['specialization'].")";
                            ?>
                          </td>
                          <td>
                            <?php 
                         if ($row['patient_type'] == 'out_patient') {
                            echo "OPD Patient";
                         }elseif($row['patient_type'] == 'in_patient'){
                            echo "Admitted Patient";
                         }
                    ?>
                          </td>
                          <td>
                            <a
                              href="attended_patients_mgm.php?admission_id=<?php echo $row['admission_id']?>&amp;action=discharge_patient&amp;doc_id=<?php echo $row['assigned_doctor']?>&amp;room=<?php echo $row['alloted_room']?>"
                              onclick="return confirm('Are you sure you want to discharge this patient?')"
                              class="btn btn-danger btn-sm"
                              title="Discharge Patient"
                            >
                            <i class="fa-solid fa-eject"></i>
                            </a>

                           
                          </td>
                        </tr>
                        
                        <?php
                    }
                  ?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script> 
    <!-- Page specific script -->
    <script>
      $(function () {
        $("#example1")
          .DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print"],
          })
          .buttons()
          .container()
          .appendTo("#example1_wrapper .col-md-6:eq(0)");
        $("#example2").DataTable({
          paging: true,
          lengthChange: false,
          searching: false,
          ordering: true,
          info: true,
          autoWidth: false,
          responsive: true,
        });
      });
    </script>
  </body>
</html>
