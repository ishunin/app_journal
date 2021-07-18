<?php
session_start();
#настройки соединения с БД
include '../scripts/conf.php';
#Общие функции
include '../func.php';
#Проверка на разлогинивание
include '../check_exit.php';
#Проверка что польщователь залогинен
#Устанавливаем разрешения на доступ на уровне страницы
$level_access = array(1, 2, 3, 5);
include("../scripts/check.php");
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Журнал ЭТИ№1 - Панель ОБ</title>
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
  <link rel="shortcut icon" href="../dist/img/favicon.ico" type="image/x-icon">
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
          <a href="<?php $_SERVER['DOCUMENT_ROOT']; ?>/index.php" class="nav-link">Домой</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Панель №1</a>
        </li>
      </ul>
      <!-- SEARCH FORM -->
      <?php include("search_disk_form.php"); ?>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <?php include("../notification_nav_bar.php"); ?>
        <!-- Левый слайдбар -->
        <?php include("../profile_bar.php"); ?>
      </ul>
    </nav>
    <!-- /.navbar -->
    <!-- Блок левого меню -->
    <?php include "../left_menu.php"; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h4>Диски на уничтожение</h4>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/index.php">Главная</a></li>
                <li class="breadcrumb-item active">Панель ОБ</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
                <h3 class="card-title"></h3>
                <div class="justify-content-between" style="display: flex;">
                  Диски на уничтожение
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php
                include("table_disk_security_panel.php");
                ?>
              </div>
              <!-- /.card-body -->
              <!-- /.card-header -->
              <div class="card-footer">
              <a class="btn btn-default" href="#" onclick="destroy_all_disk_ob();"><i class="fas fa-skull-crossbones"></i> Уничтожить все диски</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
                <h3 class="card-title"></h3>
                <div class="justify-content-between" style="display: flex;">
                  Диски на хранении (невозможно уничтожить)
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php
                include("table_disk_security_panel_storage.php");
                ?>
              </div>
              <!-- /.card-body -->
              <!-- /.card-header -->
              <div class="card-footer">
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->

            <?php
            include("show_add_panel_secure.php");
            ?>
          </div>
          <div class="card-footer">
            <?php
            #Инициализируем переменные для создания комментария
            $id_comment = 'об';
            $type_comment = 10;
            $page_comment = "ob_dashboard.php";
            $page_back_comment = "accounting/ob_dashboard.php";
            include("comment_disk_form.php");
            ?>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include '../footer.php'; ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!-- Подключаем скрипты js-->
  <?php
  if (isset($_SESSION['success_action'])) {
    echo get_action_notification($_SESSION['success_action']);
  }
  ?>
  <?php
  include("../modal_close_shift.php");
  include("modal_del_disk.php");
  include("modal_reject_disk_from_ob.php");
  include('../js_scripts.php');
  ?>
</body>

</html>