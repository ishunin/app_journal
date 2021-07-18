<?php
session_start();
#настройки соединения с БД
include 'scripts/conf.php';
#Общие функции
include 'func.php';
#Проверка на разлогинивание
include 'check_exit.php';
#Устанавливаем разрешения на доступ на уровне страницы
$level_access = array(0, 1, 2, 4, 5);
#Проверка что польщователь залогинен
include("scripts/check.php");
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Журнал ЭТИ№1 - Просмотр всех инцидентов смены</title>
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
  <script src="plugins/jquery/jquery.min.js"></script>
  <link rel="shortcut icon" href="dist/img/favicon.ico" type="image/x-icon">
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
          <a href="/index.php" class="nav-link">Домой</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Панель №1</a>
        </li>
      </ul>
      <!-- SEARCH FORM -->
      <?php include("search_form.php"); ?>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <?php include("notification_nav_bar.php"); ?>
        <!-- Левый слайдбар -->
        <?php include("profile_bar.php"); ?>
      </ul>
    </nav>
    <!-- /.navbar -->
    <!-- Блок левого меню -->
    <?php include "left_menu.php"; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Инциденты</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/index.php">Главная</a></li>
                <li class="breadcrumb-item active">Инцидет</li>
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
                <h3 class="card-title">
                  <div class="justify-content-between" style="display: flex;">
                    <?php
                     $level_access_but = array(1,5);
                      $is_allowed_button = is_allow($_COOKIE['permissions'], $level_access_but);
                      if (is_shift_open($_GET['ID'], $link)) {
                        if ($is_allowed_button) {
                          $but_shift = '<a class="btn btn-default" href="#" onclick="upload_file(' . $_GET['ID'] . ');"><i class="fas fa-link mr-1"></i>Добавить отчет за текущую смену</a>';
                        } else {
                          $but_shift = '* <small>Недостаточно прав для добавления файла отчета</small>';
                        }
                      } else {
                        $but_shift = '*Невозможно добавить отчет т.к. смена закрыта';
                      }
                      echo $but_shift;
                    ?>
                  </div>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php
                if (is_shift_open($_GET['ID'], $link)) {
                  echo '<div class="ribbon-wrapper ribbon-xl">
              <div class="ribbon bg-success text-xl">
              Открыта
              </div>
              </div>
              ';
                } else {
                  echo '<div class="ribbon-wrapper ribbon-xl">
                <div class="ribbon bg-secondary text-xl">
                Закрыта
                </div>
                </div>
                ';
                }
                include("shift_info.php");
                #Блок вывода ошибок при добавлении / редактировании / удаление записей инцидентов
                include("error_code_output.php");
                #блок вывода сообщений об операциях
                #include ("message_code_output.php");
                include "show_incidents.php"
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
    </div>
    <!-- /.content-wrapper -->
    <?php include 'footer.php'; ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!-- Подключаем скрипты js-->
  <?php
  include('js_scripts.php');
  ?>
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <script>
    $(function() {
      // Summernote
      $("#area_content").summernote();
      $("#area_action").summernote();
    })
  </script>
</body>

</html>