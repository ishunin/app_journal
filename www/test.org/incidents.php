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
  <title>Журнал ЭТИ№1 - Инциденты</title>
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
  <link rel="stylesheet" href="dist/css/gijgo.min.css">
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
              <h4><i class="fas fa-exclamation-circle"></i> Инциденты</h4>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/index.php">Главная</a></li>
                <li class="breadcrumb-item active">Инциденты</li>
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
                </h3>
                <div class="justify-content-between" style="display: flex;">
                  <?php
                  #Устанавливаем разрешения на доступ на уровне кнопок управления
                  $level_access = array(1, 2, 4, 5);
                  $action_str = '';
                  $is_allowed_button = is_allow($_COOKIE['permissions'], $level_access);
                  if ($is_allowed_button) {
                    $action_str = '<a class="btn btn-default" href="#" onclick="showMessage2();" >Создать</a> ';
                  } else {
                    $action_str = '<small>* Требуется повышение прав для создания инцидента</small>';
                  }
                  echo  $action_str;
                  ?>
                  <a class="btn btn-default" href="print_all_incidents.php" target="_blank"><i class="fas fa-print"></i> Печать</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php
                #Блок функций
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
            <a name="comment"></a>
            <?php //include("show_add_panel_incidents.php"); ?>
            

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  Дополнительная панель:
                </h3>
              </div>
              <div class="card-body">
                <!--  <h4>Custom Content Below</h4>-->
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist" style="margin-bottom: 20px" ;>
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Комментарии</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Изменения</a>
                  </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                  <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab"> 
                        <?php// echo show_comments($link, '', 101); ?>
                        <?php //echo show_comments($link, '', 1); ?>
                        <?php include("show_last_comments_incidents.php"); ?>                     
                  </div>
                  <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                      <?php echo(print_all_list_changes($link,0)); ?>
                  </div>
                </div>
              </div>
              <!-- /.card -->
              <div class="card-footer">
                <?php
                #Инициализируем переменные для создания комментария
                $id_comment = '';
                $type_comment = 101;
                $page_comment = "incidents.php";
                $page_back_comment = "incidents.php";
                //include("comment_form.php");
                ?>
              </div>
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
  <?php include('js_scripts.php'); ?>
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