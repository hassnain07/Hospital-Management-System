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
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Patients Records</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Patients Records</li>
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
                    <h3 class="card-title">Registered Patients are shown here</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table
                      id="example1"
                      class="table table-bordered table-hover"
                    >
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Addmission Id</th>
                          <th>Patient Name</th>
                          <th>Patient gender</th>
                          <th>Assigned Doctor</th>
                          <th>Patient Type</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 

                    $sel_qry = $conn->query("SELECT * FROM patients WHERE status
                        = 1 ORDER BY admission_id DESC"); while ($row =
                        $sel_qry->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr>
                          <td><?php echo $row['addmission_date']?></td>
                          <td><?php echo $row['admission_id']?></td>
                          <td><?php echo ucfirst($row['patient_name'])?></td>
                          <td><?php echo ucfirst($row['gender'])?></td>
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
                              href="patients_records_mgm.php?admission_id=<?php echo $row['admission_id']?>&amp;action=delete_record"
                              onclick="return confirm('Are you sure you want to delete this entry?')"
                              class="btn btn-danger btn-sm"
                              title="Delete"
                            >
                              <i class="fa-solid fa-trash"></i>
                            </a>

                            <button
                              type="button"
                              class="btn btn-success btn-sm"
                              data-toggle="modal"
                              data-target="#modal-lg<?php echo $row['admission_id']?>"
                            >
                              <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                          </td>
                        </tr>
                        <div
                          class="modal fade"
                          id="modal-lg<?php echo $row['admission_id']?>"
                        >
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Edit Patient Info</h4>
                                
                                <button
                                  type="button"
                                  class="close"
                                  data-dismiss="modal"
                                  aria-label="Close"
                                >
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <form action="patients_records_mgm.php" method="post">
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Patient Name</label>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text">
                                              <i class="fa-solid fa-user"></i>
                                            </span>
                                          </div>
                                          <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter Patient Name"
                                            name="patient_name"
                                            value="<?php echo $row['patient_name']?>"
                                            required
                                          />
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Patient Age</label>
                                        <div class="input-group">
                                          <div class="input-group-prepend">
                                            <span class="input-group-text">
                                              <i class="fa-solid fa-user"></i>
                                            </span>
                                          </div>
                                          <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter Patient Age"
                                            name="patient_age"
                                            value="<?php echo $row['patient_age']?>"
                                            required
                                          />
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <br />
                                  <div class="row">
                                  
                                    <div class="col-md-6">
                                      <label for=""> Patient gender </label>
                                      <br />
                                      <div class="form-group clearfix">
                                        <div
                                          class="icheck-primary d-inline pr-3"
                                        >
                                          <input type="radio" id="radioPrimary1"
                                          name="gender" value="male"
                                          <?php
                            if ($row['gender'] == 'male') {
                             echo "checked";
                            }
                            ?>
                                          required />
                                          <label for="radioPrimary1">
                                            Male
                                          </label>
                                        </div>
                                        <div
                                          class="icheck-primary d-inline pr-3"
                                        >
                                          <input type="radio" id="radioPrimary2"
                                          name="gender" value="female"
                                          <?php
                            if ($row['gender'] == 'female') {
                             echo "checked";
                            }
                            ?>
                                          required />
                                          <label for="radioPrimary2">
                                            Female
                                          </label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                          <input type="radio" id="radioPrimary3"
                                          name="gender" value="other"
                                          <?php
                            if ($row['gender'] == 'other') {
                             echo "checked";
                            }
                            ?>
                                          required />
                                          <label for="radioPrimary3">
                                            Other
                                          </label>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <br /><br />
                                </div>
                              
                              <div class="modal-footer justify-content-between">
                                <button
                                  type="submit"
                                  class="btn btn-default"
                                  data-dismiss="modal"
                                >
                                  Close
                                </button>
                                <input name="upd_pat_rec" type="submit" class="btn btn-primary" value="Save Changes">
                                <input type="hidden" name="admission_id" value="<?php echo $row['admission_id']?>">
                              </div>
                              </form>
                             
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
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
