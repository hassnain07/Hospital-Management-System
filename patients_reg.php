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

    <!-- Ionicons -->
    <link
      rel="stylesheet"
      href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"
    />
    <!-- Tempusdominus Bootstrap 4 -->
    <link
      rel="stylesheet"
      href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"
    />
    <!-- iCheck -->
    <link
      rel="stylesheet"
      href="plugins/icheck-bootstrap/icheck-bootstrap.min.css"
    />
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css" />
    <!-- overlayScrollbars -->
    <link
      rel="stylesheet"
      href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css"
    />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css" />
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css" />
  </head>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
  include('body/header.php');

  ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
      <!-- <iframe src="patient_reg_page.php"  style="display:none;"></iframe> -->

        
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <?php include("body/msgs.php");?>
            </div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Patient Registration</h1>
              </div>
              <!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Patient Registeration</li>
                </ol>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            
            <form action="patients_reg_mgm.php" method="post">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title">Patient Registration Form</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
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
                            pattern="[^\d]+"
                            title="Enter Alphabets only"
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
                            type="number"
                            min="1"
                            max="150"
                            class="form-control"
                            placeholder="Enter Patient Age"
                            name="patient_age"
                            id="patAge"
                            oninput="ageLimit()"
                            required
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="row">
                    <div class="col-md-6">
                      <label for=""> Patient Type </label>

                      <select
                        name="patient_type"
                        id="pat_type"
                        class="form-control"
                        onchange="patType()"
                        required
                      >
                        <option value="">Select Patient Type</option>
                        <option value="in_patient">Admit Patient</option>
                        <option value="out_patient">OPD Patient</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for=""> Patient gender </label>
                      <br />
                      <div class="form-group clearfix">
                        <div class="icheck-primary d-inline pr-3">
                          <input
                            type="radio"
                            id="radioPrimary1"
                            name="gender"
                            value="male"
                            required
                          />
                          <label for="radioPrimary1"> Male </label>
                        </div>
                        <div class="icheck-primary d-inline pr-3">
                          <input
                            type="radio"
                            id="radioPrimary2"
                            name="gender"
                            value="female"
                            required
                          />
                          <label for="radioPrimary2"> Female </label>
                        </div>
                        <div class="icheck-primary d-inline">
                          <input
                            type="radio"
                            id="radioPrimary3"
                            name="gender"
                            value="other"
                            required
                          />
                          <label for="radioPrimary3"> Other </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="row">
                    <div class="col-md-6">
                      <label for=""> Assign Doctor </label>
                      <select
                        name="assigned_doctor"
                        id=""
                        class="form-control"
                        required
                      >
                        <option value="">Assign Doctor To patient</option>
                        <?php
                         $sel_qry = $conn->query("SELECT * FROM doctors WHERE
                        status = 1"); while ($row =
                        $sel_qry->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $row['doctor_id']?>">
                          <span
                            ><?php echo $row['doctor_name']?>
                            (<?php echo $row['specialization']?>)</span
                          >
                        </option>
                        <?php
                         
                         }
                         ?>
                      </select>
                    </div>
                    <div class="col-md-6" id="roomRow" style="display: none">
                      <label for=""> Available Room </label>
                      <select
                        name="alloted_room"
                        id=""
                        class="form-control"
                         
                      >
                        <option value="">Allot Room To patient</option>
                        <?php
                         $sel_qry = $conn->query("SELECT * FROM rooms WHERE
                        status = 1"); while ($row =
                        $sel_qry->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $row['room_id']?>">
                          <span
                            ><?php echo $row['room_no']?>
                            (<?php echo $row['room_cost']?>)</span
                          >
                        </option>
                        <?php
                         
                         }
                         ?>
                      </select>
                    </div>
                  </div>
                  <br /><br />
                  <div class="row">
                    <div class="col-md-6 offset-3">
                      <input type="submit" name="reg_patient" value="Register Patient" class="btn btn-block btn-info">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
            </form>
          </div>
          <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge("uibutton", $.ui.button);
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
    <script>
      function ageLimit() {
        let patAge = document.getElementById('patAge');
        if (patAge.value >= 150) {
          window.alert("Age is greater than 150");
          patAge.value = 0;
        }
        
      }
      function patType() {
        pat_type = document.getElementById("pat_type");
        roomRow = document.getElementById("roomRow");
        //  console.log();
        if (pat_type.value == "in_patient") {
          roomRow.style.display = "block";
        } else {
          roomRow.style.display = "none";
        }
      }
    </script>
  </body>
</html>
