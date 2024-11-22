<?php
include('config/connection.php');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php include('body/title.php')?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <?php 
  include('body/font_awesome_links.php');
  ?>
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">


    <!-- header start -->
    <?php include('body/header.php')?>
    <!-- header end -->


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="row">
          <div class="col-md-12">
            <?php
        include('body/msgs.php');
        ?>
          </div>
        </div>
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Rooms</h1>
            </div>

          </div>
          <div class="row">
            <div class="col-md-12">
              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default"
                style="float:right">
                Add Room
              </button>
              <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Add Room</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="rooms_mgm.php" method="post">
                      <div class="modal-body">
                        <div class="row">

                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Room Number</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter Room Nubmber"
                                  name="room_no" value="" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Room Cost</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter Room Cost"
                                  name="room_cost" value="" required>
                              </div>
                            </div>
                          </div>
                          
                    

                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="add_room" class="btn btn-primary">Add Room</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">



            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Added Rooms are shown here</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Sr#</th>
                      <th>Room Number</th>
                      <th>Room Cost</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    
                    $sel_qry = $conn->query("SELECT * FROM rooms");
                    $i = 1;

                    while ($row = $sel_qry->fetch(PDO::FETCH_ASSOC)) {

                ?>

                    <tr>
                      <td>
                        <?php echo $i;?>
                      </td>
                      <td>
                        <?php echo $row['room_no']?>
                      </td>
                      <td>
                      <?php echo $row['room_cost']?>
                      </td>
                      <td>
                      <?php 
                      if ($row['status'] == 1) {
                        ?>
                      <span class="right badge badge-success">Available</span>
                        <?php
                      }else{
                        ?>
                     <span class="right badge badge-danger">Busy</span>

                        <?php
                      }
                      ?>
                      </td>

                      <td>

                      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-default<?php echo $row['room_id']?>"
                >
                Edit
              </button>



                      </td>
                    </tr>
                    <div class="modal fade" id="modal-default<?php echo $row['room_id']?>">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Update Room Info</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="rooms_mgm.php" method="post">
                      <div class="modal-body">
                        <div class="row">

                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Room Number</label>
                              <div class="input-group">
                                
                                <input type="text" class="form-control"
                                  name="room_no" value="<?php echo $row['room_no']?>" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Room Cost</label>
                              <div class="input-group">
                                
                                <input type="text" class="form-control"
                                  name="room_cost" value="<?php echo $row['room_cost']?>" required>
                              </div>
                            </div>
                          </div>
                          



                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <input type="hidden" name="action" value="<?php echo $row['room_id']?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" name="update_room" class="btn btn-success">Update</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
                    <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>

            <?php
                $i++;
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






  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <script src="https://kit.fontawesome.com/20db2967c4.js" crossorigin="anonymous"></script>
  <script src="dist/js/demo.js"></script>
  <script src="https://kit.fontawesome.com/20db2967c4.js" crossorigin="anonymous"></script>
  <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>

  <!-- page script -->
  <!-- <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script> -->
</body>

</html>