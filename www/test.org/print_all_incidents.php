<?php
session_start();
?>
<?php
#удалить потом, временно
include("func.php");
include("scripts/conf.php");
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Журнал ЭТИ№1 -Все инциденты</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="dist/css/ionicons.min.css"> <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="dist/css/toastr.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="dist/css/fonts.css">
  <link rel="stylesheet" href="dist/css/main.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
       <!-- Content Header (Page header) -->
       <section class="content print_style">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h4> 
                Отчет за текущую смену 
                </h4>  
                <?php 
                
                $shif_info =  get_cur_shift_info($link);
                if ($shif_info!=0) {              
                echo '<small><a href="profile.php?id='.$shif_info['id_user'].'" class="link-black"><img class="img-circle elevation-2" style="height: auto;
                width: 2.1rem;" src="'.get_user_icon($shif_info['id_user'],$link).'"> '. get_user_name_by_id( $shif_info['id_user'],$link).' </a> <u>'.$shif_info['create_date'].' - '.$shif_info['end_date'].'</u> </small>';            
              }
                ?>
              
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/index.php">Главная</a></li>
                
                <li class="breadcrumb-item active">Отчет за текущую смену</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->

    <!-- Main content -->
    <section class="content print_style">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body ">
              <?php
              include "show_incidents_print.php"
              ?>
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
    <footer class="main-footer" style="margin-left:0px;">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0
      </div>
      <strong>Copyright © 2020 ФКУ "Налог-Сервис". </strong>Все права защищены.
    </footer>
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
  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- page script -->
  <script src="plugins/toastr/toastr.min.js"></script>
  <script src="dist/js/demo.js"></script>
  <script>
    $(function() {
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
  </script>
  <script type="text/javascript">
    window.addEventListener("load", window.print());
  </script>
</body>

</html>