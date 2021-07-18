<?php
session_start();
/*
if(isset($_GET['exit']) && $_GET['exit']==1) {
  SetCookie("id","");
   SetCookie("hash","");
   header('Location: login.php'); exit();
   }
include("scripts/check.php");

*/?>
<?php
#удалить потом, временно
include("scripts/conf.php");
include ("func.php"); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Журнал ЭТИ№1 - Информация об инциденте</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">


  <!-- Ionicons -->
  <link rel="stylesheet" href="dist/css/ionicons.min.css">  <!-- DataTables -->
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
    <script src="plugins/jquery/jquery.min.js"></script>


<style>
  
</style>


</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          
              <?php
                  include "show_one_page.php";
              ?>
            
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

  <!-- /.content-wrapper -->
  <footer class="main-footer" style="margin-left:0px;">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.4
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
</script>


 <script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script>

</body>
</html>
