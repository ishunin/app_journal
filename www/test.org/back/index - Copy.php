<?php
session_start();
#настройки соединения с БД
include 'scripts/conf.php';
#Общие функции
include 'func.php';
#Проверка на разлогинивание
include 'check_exit.php';
#Проверка что польщователь залогинен
include("scripts/check.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Журнал ЭТИ№1 - Главная</title>
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
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/test.org/index.php'; ?>" class="nav-link">Домой</a>
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
              <h4><i class="nav-icon fas fa-th"></i> Журнал ЭТИ№1</h4>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/test.org/index.php'; ?>">Главная</a></li>
                <li class="breadcrumb-item active">Журнал ЭТИ№1</li>
         
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
                  <i class="fas fa-paperclip"></i> Список закрепленных новостей и инцидентов
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <?php
                $count_keep_record = 0;
                include("error_code_output.php");
                #блок вывода сообщений об операциях
                #include("message_code_output.php");
                include("show_keeped_record.php");
                include("show_keeped_news.php");
                include("show_keeped_jobs.php");
                if ($count_keep_record == 0) {
                  echo '
                  <blockquote class="quote-secondary">
                  <p>Информация:</p>
                  <small>Нет закрепленных записей.</small>
                  </blockquote>
                 ';
                }
                ?>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <small><?php echo 'Закреплено ' . ($count_keep_record) . ' записей'; ?></small>
              </div>
              <!-- /.card-footer-->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                </h3>
                <div class="justify-content-between" style="display: flex;">
                  <?php
                  $action_str = '';
                  if (isset($_COOKIE['permissions']) && $_COOKIE['permissions'] == $_COOKIE['hash'] . '1') {
                    $action_str = '<a class="btn btn-default" href="#" onclick="showMessage2();" >Создать</a> ';
                  } else {
                    $action_str = '<a class="btn btn-default href="#" onclick="#" style="visibility:hidden;">Создать</a> ';
                  }
                  echo  $action_str;
                  ?>
                  <a class="btn btn-default" href="print_all_incidents.php" target="_blank"><i class="fas fa-print"></i> Печать</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php
                include "show_list2.php"
                ?>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- /.card -->
        <!-- Default box -->
        <div class="card">
          <div class="card-header">

            <h3 class="card-title">
              <i class="far fa-envelope-open"></i> Последние опубликованные новости
            </h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <?php
            include("show_last_news.php");
            ?>
          </div>

          <!-- /.card-body -->
          <div class="card-footer">
            <small>Доступно 3 новости</small>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->

        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> <i class="fas fa-wrench"></i>
              Последние опубликованные задания</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <?php
            include("show_last_jobs.php");
            ?>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <small>Доступно 3 задания</small>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><i class="far fa-comments mr-1"></i>Последние опубликованные комментарии</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <?php
            include("show_last_comments_incidents.php");
            echo '<br>';
            include("show_last_comments_news.php");
            ?>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <small>Доступно 6 комментариев</small>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include'footer.php';?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
<!-- Подключаем скрипты js-->
<?php include ('js_scripts.php'); ?>  
</body>
</html>