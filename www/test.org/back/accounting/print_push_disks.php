<?php
session_start();
#настройки соединения с БД
include '../scripts/conf_account.php';
#Общие функции
include '../func.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Журнал ЭТИ№1 - Приход дисков</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../dist/css/ionicons.min.css"> <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../dist/css/toastr.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="../dist/css/fonts.css">
  <link rel="stylesheet" href="../dist/css/main.css">
  <script src="../plugins/jquery/jquery.min.js"></script>
  <link rel="shortcut icon" href="<?php echo ("http://".$_SERVER['SERVER_ADDR']."/dist/img/favicon.ico");?>" type="image/x-icon">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php $_SERVER['DOCUMENT_ROOT'];?>/index.php" class="nav-link">Домой</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Панель №1</a>
        </li>
      </ul>
     <!-- SEARCH FORM -->
     <?php include("../search_form.php"); ?>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <?php include("../notification_nav_bar.php"); ?>
        <!-- Левый слайдбар -->
        <?php include("../profile_bar.php"); ?>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h4>Приход</h4>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/index.php">Главная</a></li>
                <li class="breadcrumb-item active" >Приход</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-12">
            <?php
            include ("show_push_disk.php");
            ?>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
     </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include'../footer.php';?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script>
</body>
</html>